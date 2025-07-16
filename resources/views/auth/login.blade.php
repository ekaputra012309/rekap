@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <main class="form-signin w-100 m-auto">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="text-center mb-3">
                <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name }}" height="120">
            </div>

            {{-- <h1 class="h3 mb-3 fw-normal text-center">Please sign in</h1> --}}

            <div class="form-floating mb-2">
                <input type="text" name="login" class="form-control" id="login" value="{{ old('login') }}"
                    placeholder="Email or username" required autofocus>
                <label for="floatingInput">Email or username</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                <label for="floatingPassword">Password</label>
            </div>

            <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>

            <p class="mb-25 text-center mt-4">&copy; 2025 {{ $company->name ?? 'Kitacodinginaja' }}</p>
        </form>
    </main>
@endsection
