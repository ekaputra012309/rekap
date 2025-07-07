<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Contracts\PasswordUpdateResponse;
use Laravel\Fortify\Contracts\ProfileInformationUpdatedResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        Fortify::authenticateUsing(function (Request $request) {
            $login = $request->input('login');   // <— one input for both
        
            $user = User::where('email', $login)
                        ->orWhere('username', $login)
                        ->first();
        
            if ($user && Hash::check($request->password, $user->password)) {
                return $user;        // authentication successful
            }
        
            return null;             // authentication failed
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // Login
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // Register
        Fortify::registerView(function () {
            return view('auth.register');
        });

        // Custom Register Redirect
        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
            public function toResponse($request): RedirectResponse
            {
                // return redirect()->route('login'); // 👈 Change to your route
                return redirect()->route('login')->with('toast', [
                    'type' => 'success',
                    'message' => 'Register is successfully!',
                ]);
            }
        });
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request): RedirectResponse
            {                
                return redirect()->route('dashboard')->with('toast', [
                    'type' => 'primary',
                    'message' => 'Welcome to your dashboard!',
                ]);                
            }
        });

        $this->app->instance(PasswordUpdateResponse::class, new class implements PasswordUpdateResponse {
            public function toResponse($request): \Illuminate\Http\RedirectResponse
            {
                return redirect()->route('profile.edit')->with('toast', [
                    'type' => 'success',
                    'message' => 'Password updated successfully!',
                ]);
            }
        });

        $this->app->instance(ProfileInformationUpdatedResponse::class, new class implements ProfileInformationUpdatedResponse {
            public function toResponse($request): \Illuminate\Http\RedirectResponse
            {
                return redirect()->route('profile.edit')->with('toast', [
                    'type' => 'success',
                    'message' => 'Profile updated successfully!',
                ]);
            }
        });
    }
}