@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<main class="form-signin w-100 m-auto">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <h1 class="h3 mb-3 fw-normal text-center">Please sign in</h1>

        <div class="form-floating mb-2">
            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required autofocus>
            <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
            <label for="floatingPassword">Password</label>
        </div>

        <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
    </form>
</main>
@endsection
