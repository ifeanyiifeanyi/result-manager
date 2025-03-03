<x-guest-layout>
    <x-slot name="title">
        {{ __('Forgot Password') }}
    </x-slot>


    <div class="container px-3 py-3">
        <div class="login-header">
            <h2 class="fw-bold">{{ __('Forgot Password?') }}</h2>
            <p class="text-muted"> {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</p>
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
        </div>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="login-form">
                <div class="mb-3">
                    <label for="email" class="form-label required-field">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        id="email" placeholder="Email" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <x-primary-button class="btn-login">
                    {{ __('Email Password Reset Link') }}
                </x-primary-button>
            </div>
        </form>
    </div>

</x-guest-layout>
