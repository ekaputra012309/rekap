@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<main class="form-signin w-100 m-auto">
  <form method="POST" action="{{ route('register') }}">
    @csrf
    <h1 class="h3 mb-3 fw-normal text-center">Register</h1>

    <div class="form-floating mb-2">
      <input type="text" name="name" class="form-control" id="floatingName" placeholder="Your name" required>
      <label for="floatingName">Name</label>
    </div>

    <div class="form-floating mb-2">
      <input type="email" name="email" class="form-control" id="floatingEmail" placeholder="name@example.com" required>
      <label for="floatingEmail">Email</label>
    </div>

    <div class="form-floating mb-2">
      <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
      <label for="floatingPassword">Password</label>
    </div>

    <div class="form-floating mb-3">
      <input type="password" name="password_confirmation" class="form-control" id="floatingConfirm" placeholder="Confirm Password" required>
      <label for="floatingConfirm">Confirm Password</label>
    </div>

    <button type="submit" class="btn btn-success w-100 py-2">Register</button>
  </form>
</main>
@endsection
