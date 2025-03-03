<x-guest-layout>

    <x-slot name="title">
        {{ __('Confirm Password') }}
    </x-slot>

    <div class="container px-3 py-3">
        <div class="login-header">
            <h2 class="fw-bold">Confirm Password</h2>
            <p class="text-muted">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </p>
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf
            <div class="login-form">


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

                <button type="submit" class="btn-login">Confirm Password</button>
            </div>
        </form>

    </div>

</x-guest-layout>
