<x-guest-layout>
    <x-slot name="title">
        {{ __('Register') }}
    </x-slot>

    <div class="container px-3 py-3">
        <div class="login-header">
            <h2 class="fw-bold">Welcome!</h2>
            <p class="text-muted">Let's guide you to seamless academic automation.</p>
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
        </div>


        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="login-form">

                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="first_name" class="form-label required-field">First Name</label>
                        <input type="text" name="first_name"
                            class="form-control @error('first_name') is-invalid @enderror" id="first_name"
                            placeholder="Enter first name" value="{{ old('first_name') }}">
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="last_name" class="form-label required-field">Last Name</label>
                        <input type="text" name="last_name"
                            class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                            placeholder="Enter last name" value="{{ old('last_name') }}">
                        @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label required-field">Phone Number</label>
                    <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror"
                        id="phone" placeholder="Enter phone number" value="{{ old('phone') }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label required-field">Email Address</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        id="email" placeholder="Enter email address" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="password" class="form-label required-field">Password</label>
                            <div class="password-field">
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" id="password"
                                    placeholder="Enter password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <button type="button" class="password-toggle" id="togglePassword">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label required-field">Confirm
                                Password</label>
                            <div class="password-field">
                                <input type="password" name="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    id="password_confirmation" placeholder="Confirm password">
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <button type="button" class="password-toggle" id="togglePasswordConfirm">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-login">Create Account</button>
            </div>
        </form>

        <div class="mt-4 signup-link">
            <span>Already have an account? </span>
            <a href="{{ route('login') }}">Sign In</a>
        </div>
    </div>

    <!-- Additional JavaScript for password confirmation toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
            const passwordConfirmField = document.getElementById('password_confirmation');

            togglePasswordConfirm.addEventListener('click', function() {
                const type = passwordConfirmField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirmField.setAttribute('type', type);

                // Toggle eye icon
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        });
    </script>
</x-guest-layout>
