<x-student-layout>
    <x-slot name="title">
        {{ __('Application Status') }}
    </x-slot>

    @php
        $application = \App\Models\Application::where('user_id', auth()->user()->id)
            ->with(['payments', 'user'])
            ->latest()
            ->first();
        $payment = $application?->payments()->latest()->first();
    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Your Application Status</h5>
                    </div>
                    <div class="card-body">
                        @if($application)
                            <div class="row">
                                <!-- Application Details -->
                                <div class="col-md-4">
                                    <h6>Application Details</h6>
                                    <p><strong>ID:</strong> {{ $application->application_number }}</p>
                                    <p><strong>Status:</strong> {{ ucfirst($application->status) }}</p>
                                    <p><strong>Submitted:</strong> {{ $application->submitted_at->format('M d, Y H:i') }}</p>
                                    @if($application->status === \App\Models\Application::STATUS_REJECTED)
                                        <p><strong>Rejection Reason:</strong> {{ $application->rejection_reason }}</p>
                                    @endif
                                </div>

                                <!-- Payment Details -->
                                <div class="col-md-4">
                                    <h6>Payment Details</h6>
                                    @if($payment)
                                        <p><strong>Amount:</strong> ₦{{ number_format($payment->amount, 2) }}</p>
                                        <p><strong>Total Charged:</strong> ₦{{ number_format($payment->total_charged, 2) }}</p>
                                        <p><strong>Reference:</strong> {{ $payment->reference }}</p>
                                        <p><strong>Paid At:</strong> {{ $payment->paid_at?->format('M d, Y H:i') }}</p>
                                        <p><strong>Status:</strong> {{ ucfirst($payment->status) }}</p>
                                    @else
                                        <p>No payment recorded yet.</p>
                                    @endif
                                </div>

                                <!-- Student Details -->
                                <div class="col-md-4">
                                    <h6>Your Information</h6>
                                    <p><strong>Name:</strong> {{ $application->user->getFullNameAttribute() }}</p>
                                    <p><strong>Email:</strong> {{ $application->user->email }}</p>
                                    <p><strong>Phone:</strong> {{ $application->user->phone }}</p>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info">
                                You have not submitted any applications yet.
                                <a href="{{ route('student.application.start') }}" class="btn btn-primary btn-sm">Start Application</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-student-layout>