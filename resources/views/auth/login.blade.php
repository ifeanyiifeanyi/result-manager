<x-guest-layout>

    <x-slot name="title">
        {{ __('Login') }}
    </x-slot>

    <div class="container px-3 py-3">
        <div class="login-header">
            <h2 class="fw-bold">Welcome!</h2>
            <p class="text-muted">Let's guide you to seamless academic automation.</p>
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="login-form">
                <h3 class="mb-4">Sign in</h3>

                <div class="mb-3">
                    <label for="email" class="form-label required-field">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        id="email" placeholder="Email" value="{{ old('email') }}" autocomplete="email">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label required-field">Password</label>
                    <div class="password-field">
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" id="password"
                            placeholder="Password" autocomplete="current-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <div class="forgot-password d-flex justify-content-between">
                    <div class="remember-me">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">Remember Me</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-login">Login</button>
            </div>
        </form>

        <div class="signup-link">
            <span>Need an account? </span>
            <a href="{{ route('register') }}">Sign Up</a>
        </div>
    </div>

</x-guest-layout>
