<x-student-layout>
    <x-slot name="title">
        {{ __('Application Submitted') }}
    </x-slot>

    @php
        $application = \App\Models\Application::where('user_id', auth()->user()->id)
            ->with(['payments', 'user'])
            ->latest()
            ->first();
        $payment = $application->payments()->latest()->first();
    @endphp

    <div class="container-fluid">
        <!-- Success Message -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Application Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading">Application Successful!</h4>
                            <p>
                                Your application has been successfully submitted and payment confirmed. We are currently processing your application. You will receive an email update once it has been reviewed.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Application and Payment Details -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Application Details</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Application ID:</strong> {{ $application->application_number }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($application->status) }}</p>
                        <p><strong>Submission Date:</strong> {{ $application->submitted_at?->format('M d, Y H:i') }}</p>
                        <p><strong>Payment Amount:</strong> ₦{{ number_format($payment->amount, 2) }}</p>
                        <p><strong>Total Charged:</strong> ₦{{ number_format($payment->total_charged, 2) }}</p>
                        <p><strong>Payment Reference:</strong> {{ $payment->reference }}</p>
                        <p><strong>Payment Date:</strong> {{ $payment->created_at?->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Details -->
        <div class="mt-4 row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Student Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <p><strong>Full Name:</strong> {{ $application->user?->full_name }}</p>
                                <p><strong>Email:</strong> {{ $application->user?->email }}</p>
                                <p><strong>Phone:</strong> {{ $application->user?->phone }}</p>
                                <p><strong>Date of Birth:</strong> {{ $application->user?->date_of_birth?->format('M d, Y') }}</p>
                                <p><strong>Gender:</strong> {{ ucfirst($application->user?->gender) }}</p>
                            </div>
                            <div class="col-md-5">
                                <img class="img-thumbnail" src="{{ $application->user?->photo }}" width="100%" height="" alt="">
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Printable Receipt -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Payment Receipt</h5>
                        <button onclick="printReceipt()" class="btn btn-primary btn-sm float-end">Print Receipt</button>
                    </div>
                    <div class="card-body" id="receipt">
                        <h5 class="text-center">Payment Receipt</h5>
                        <hr>
                        <p class="text-center">
                            <img src="{{ $application->user?->photo }}" alt="" width="150" height="150" class="img-thumbnail">
                        </p>
                        <p><strong>Student Name:</strong> {{ $application->user?->full_name }}</p>
                        <p><strong>Application ID:</strong> {{ $application->application_number ?? '-' }}</p>
                        <p><strong>Payment Reference:</strong> {{ $payment->reference ?? '-' }}</p>
                        <p><strong>Amount Paid:</strong> ₦{{ number_format($payment->amount, 2) }}</p>
                        <p><strong>Payment Date:</strong> {{ $payment->created_at?->format('M d, Y H:i') }}</p>
                        <p><strong>Payment Status:</strong> <span class="badge bg-success">Successful</span></p>
                        <small class="text-muted">Generated on {{ $application->created_at?->format('M d, Y') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printReceipt() {
            const receipt = document.getElementById('receipt').innerHTML;
            const originalContent = document.body.innerHTML;
            document.body.innerHTML = receipt;
            window.print();
            document.body.innerHTML = originalContent;
        }
    </script>
</x-student-layout>
