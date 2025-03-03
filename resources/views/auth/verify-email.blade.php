<x-guest-layout>

    <x-slot name="title">
        {{ __('Email Verification') }}
    </x-slot>
    <div class="container px-3 py-3">
        <div class="login-header">
            <h2 class="fw-bold">Verify Email Address</h2>
            <p class="text-muted">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </p>
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-success">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="mt-4 d-flex justify-content-center">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-primary-button>
                        {{ __('Resend Verification Email') }}
                    </x-primary-button>
                </div>
            </form>
            &nbsp;
            &nbsp;
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="btn btn-outline-primary">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
