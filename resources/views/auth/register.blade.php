@extends('layouts.main')

@section('content')
<div class="card-body register-card-body">
    <h4 class="login-box-msg" style="font-weight: bold">Register</h4>

    <form id="registerForm" action="{{ url('/register') }}" method="post" novalidate>
      @csrf
      <div class="mb-3">
        <div class="input-group">
          <input type="text" id="name" class="form-control" placeholder="Full name" name="name" value="{{ old('name') }}" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div id="nameError" class="text-danger mt-1" style="font-size: 0.875rem;"></div>
      </div>

      <div class="mb-3">
        <div class="input-group">
          <input type="email" id="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required>
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
          <input type="password" id="password" class="form-control" placeholder="Password" name="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div id="passwordError" class="text-danger mt-1" style="font-size: 0.875rem;"></div>
      </div>

      <div class="mb-3">
        <div class="input-group">
          <input type="password" id="password_confirmation" class="form-control" placeholder="Retype password" name="password_confirmation" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div id="passwordConfirmationError" class="text-danger mt-1" style="font-size: 0.875rem;"></div>
      </div>

      <div class="row">
        <div class="col-4 offset-8">
          <button type="submit" class="btn btn-primary btn-block">Register</button>
        </div>
      </div>
    </form>

    <a href="{{ url('/login') }}" class="text-center">I already have a membership</a>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
      const form = document.getElementById("registerForm");
      const nameInput = document.getElementById("name");
      const emailInput = document.getElementById("email");
      const passwordInput = document.getElementById("password");
      const passwordConfirmationInput = document.getElementById("password_confirmation");

      form.addEventListener("submit", function (event) {
        let valid = true;

        // Clear previous errors
        const nameError = document.querySelector("#nameError");
        const emailError = document.querySelector("#emailError");
        const passwordError = document.querySelector("#passwordError");
        const passwordConfirmationError = document.querySelector("#passwordConfirmationError");

        if (!nameInput.value.trim()) {
          nameInput.classList.add("is-invalid");
          nameError.textContent = "Name is required.";
          valid = false;
        } else {
          nameInput.classList.remove("is-invalid");
          nameError.textContent = "";
        }

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

        if (passwordConfirmationInput.value !== passwordInput.value) {
          passwordConfirmationInput.classList.add("is-invalid");
          passwordConfirmationError.textContent = "Passwords do not match.";
          valid = false;
        } else {
          passwordConfirmationInput.classList.remove("is-invalid");
          passwordConfirmationError.textContent = "";
        }

        if (!valid) {
          event.preventDefault(); // Prevent form submission if validation fails
        }
      });
    });
</script>
@endsection
