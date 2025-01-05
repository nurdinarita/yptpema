@extends('layouts.main')

@section('content')
<div class="card-body login-card-body">
    <h4 class="login-box-msg" style="font-weight: bold">Login Page</h4>
    
    <!-- Display error message -->
    @if ($errors->has('loginError'))
        <div class="text-danger text-center mb-3">
            {{ $errors->first('loginError') }}
        </div>
    @endif

    <form id="loginForm" action="{{ route('login') }}" method="post" novalidate>
      @csrf
      <div class="mb-3">
        <div class="input-group">
          <input type="email" id="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div id="emailError" class="text-danger mt-1" style="font-size: 0.875rem;"></div>
      </div>

      <div class="mb-3">
        <div class="input-group">
          <input type="password" id="password" class="form-control" placeholder="Password" name="password" required autocomplete="current-password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div id="passwordError" class="text-danger mt-1" style="font-size: 0.875rem;"></div>
      </div>

      <div class="row">
        <div class="col-8">
          <div class="icheck-primary">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">
              Remember Me
            </label>
          </div>
        </div>
        <div class="col-4">
          <button type="submit" class="btn btn-primary btn-block">Sign In</button>
        </div>
      </div>
    </form>

    <p class="mb-1">
      <a href="forgot-password.html">I forgot my password</a>
    </p>
    <p class="mb-0">
      <a href="{{ url('/register') }}" class="text-center">Register a new membership</a>
    </p>
  </div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
      const form = document.getElementById("loginForm");
      const emailInput = document.getElementById("email");
      const passwordInput = document.getElementById("password");

      form.addEventListener("submit", function (event) {
        let valid = true;

        // Clear previous errors
        const emailError = document.querySelector("#emailError");
        const passwordError = document.querySelector("#passwordError");

        if (!emailInput.value.trim()) {
          emailInput.classList.add("is-invalid");
          emailError.textContent = "Email is required.";
          valid = false;
        } else {
          emailInput.classList.remove("is-invalid");
          emailError.textContent = "";
        }

        if (!passwordInput.value.trim()) {
          passwordInput.classList.add("is-invalid");
          passwordError.textContent = "Password is required.";
          valid = false;
        } else {
          passwordInput.classList.remove("is-invalid");
          passwordError.textContent = "";
        }

        if (!valid) {
          event.preventDefault(); // Prevent form submission if validation fails
        }
      });
    });
</script>
@endsection

