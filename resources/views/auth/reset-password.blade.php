<x-guest-layout>
    <x-slot name="title">
        {{ __('Reset Password') }}
    </x-slot>

    <div class="container px-3 py-3">
        <div class="login-header">
            <h2 class="fw-bold">Reset Password</h2>
            <p class="text-muted">Enter your email address, the new password and confirm password</p>
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
        </div>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <div class="login-form">
                <div class="mb-3">
                    <label for="email" class="form-label required-field">Email Address</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        id="email" placeholder="Enter email address" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

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

                <button type="submit" class="btn-login">Reset Password</button>
            </div>
        </form>

    </div>
</x-guest-layout>
