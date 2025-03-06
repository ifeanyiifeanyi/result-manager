<x-student-layout>
    <x-slot name="title">
        {{ __('Application Status') }}
    </x-slot>

    @php
        $application = \App\Models\Application::where('user_id', auth()->user()->id)
            ->with(['payments', 'user', 'academicSession'])
            ->latest()
            ->first();
        $payment = $application?->payments()->latest()->first();
        $school = \App\Models\School::first();
    @endphp

    <div class="container">
        <div class="status-card">
            <!-- Status Banner -->
            <div class="status-banner {{ $application ? $application->status : 'no-application' }}">
                <div class="banner-content">
                    @if ($application)
                        @if ($application->status === \App\Models\Application::STATUS_APPROVED)
                            <i class="fas fa-check-circle banner-icon"></i>
                            <h1 class="banner-title">Congratulations!</h1>
                            <p class="banner-text">Your application has been approved. Welcome aboard!</p>
                            <button id="printAdmissionBtn" class="btn btn-white">
                                <i class="fas fa-print"></i> Print Admission Letter
                            </button>
                        @elseif ($application->status === \App\Models\Application::STATUS_REJECTED)
                            <i class="fas fa-times-circle banner-icon"></i>
                            <h1 class="banner-title">Application Not Approved</h1>
                            <p class="banner-text">Please review the feedback and try again next session.</p>
                        @else
                            <i class="fas fa-hourglass-half banner-icon fa-spin"></i>
                            <h1 class="banner-title">Application In Progress</h1>
                            <p class="banner-text">We're processing your application. Stay tuned!</p>
                        @endif
                    @else
                        <i class="fas fa-file-alt banner-icon"></i>
                        <h1 class="banner-title">No Application Found</h1>
                        <p class="banner-text">Ready to begin your journey? Start now!</p>
                        <a href="{{ route('student.application.start') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> Start Application
                        </a>
                    @endif
                </div>
            </div>

            @if ($application)
                <!-- Progress Tracker -->
                <div class="progress-tracker">
                    <div class="progress-steps">
                        <div class="step {{ $application->status !== 'draft' ? 'completed' : '' }}">
                            <i class="fas fa-file-alt"></i>
                            <span>Submitted</span>
                        </div>
                        <div
                            class="step {{ in_array($application->status, ['under_review', 'approved', 'rejected']) ? 'completed' : '' }}">
                            <i class="fas fa-search"></i>
                            <span>Under Review</span>
                        </div>
                        <div
                            class="step {{ in_array($application->status, ['approved', 'rejected']) ? 'completed' : '' }}">
                            <i class="fas fa-clipboard-check"></i>
                            <span>Decision</span>
                        </div>
                        <div class="step {{ $application->status === 'approved' ? 'completed' : '' }}">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Enrollment</span>
                        </div>
                    </div>
                </div>

                <!-- Application Details -->
                <div class="details-grid">
                    <!-- Application Info -->
                    <div class="info-card">
                        <h2><i class="fas fa-file-alt"></i> Application Details</h2>
                        <div class="info-item">
                            <span class="label">Application ID:</span>
                            <span class="value">{{ $application->application_number }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Submitted:</span>
                            <span class="value">{{ $application->submitted_at->format('M d, Y') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Session:</span>
                            <span class="value">{{ $application->academicSession->name ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Status:</span>
                            <span
                                class="status {{ $application->status }}">{{ Str::upper($application->status) }}</span>
                        </div>
                        @if ($application->status === 'rejected')
                            <div class="feedback">
                                <h3><i class="fas fa-exclamation-circle"></i> Feedback</h3>
                                <p>{{ $application->rejection_reason }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Payment Info -->
                    <!-- Update the payment info section button -->
                    <div class="info-card">
                        <h2><i class="fas fa-credit-card"></i> Payment Details</h2>
                        @if ($payment)
                            <div class="info-item">
                                <span class="label">Amount:</span>
                                <span class="value">₦{{ number_format($payment->amount, 2) }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Date:</span>
                                <span class="value">{{ $payment->created_at?->format('M d, Y') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Reference:</span>
                                <span class="value">{{ $payment->reference }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Status:</span>
                                <span class="status {{ $payment->status }}">{{ Str::upper($payment->status) }}</span>
                            </div>
                            <button id="printReceiptBtn" class="btn btn-primary"><i class="fas fa-download"></i>
                                Receipt</button>
                        @else
                            <p class="no-data"><i class="fas fa-exclamation-triangle"></i> No payment recorded</p>
                            <a href="#" class="btn btn-primary"><i class="fas fa-credit-card"></i> Make
                                Payment</a>
                        @endif
                    </div>


                    {{-- RECIPT VIEW SECTION ------  --}}
                    <!-- Add the printable receipt section -->
                    <div id="printableReceipt" class="printable">
                        <div class="receipt">
                            <div class="receipt-header">
                                <img src="{{ asset($school->logo ?? '') }}" alt="Logo" class="logo rounded-circel img-fluid">
                                <div>
                                    <h1>{{ $school->name ?? '' }}</h1>
                                    <p>Excellence in Education</p>
                                </div>
                            </div>

                            <h2>OFFICIAL RECEIPT</h2>
                            <div class="receipt-container">
                                <div class="receipt-section">
                                    <h3>Receipt Details</h3>
                                    <div class="receipt-item">
                                        <span class="receipt-label">Receipt Number:</span>
                                        <span class="receipt-value">{{ $payment->reference }}</span>
                                    </div>
                                    <div class="receipt-item">
                                        <span class="receipt-label">Payment Date:</span>
                                        <span
                                            class="receipt-value">{{ $payment->created_at?->format('F d, Y') }}</span>
                                    </div>
                                    <div class="receipt-item">
                                        <span class="receipt-label">Amount Paid:</span>
                                        <span class="receipt-value">₦{{ number_format($payment->amount, 2) }}</span>
                                    </div>
                                    <div class="receipt-item">
                                        <span class="receipt-label">Payment Status:</span>
                                        <span
                                            class="receipt-value status-text {{ $payment->status }}">{{ Str::upper($payment->status) }}</span>
                                    </div>
                                    <div class="receipt-item">
                                        <span class="receipt-label">Payment For:</span>
                                        <span class="receipt-value">Application Fee -
                                            {{ $application->academicSession->name }}</span>
                                    </div>
                                </div>

                                <div class="receipt-section">
                                    <h3>Student Information</h3>
                                    <div class="receipt-item">
                                        <span class="receipt-label">Student Name:</span>
                                        <span
                                            class="receipt-value">{{ $application->user->getFullNameAttribute() }}</span>
                                    </div>
                                    <div class="receipt-item">
                                        <span class="receipt-label">Application ID:</span>
                                        <span class="receipt-value">{{ $application->application_number }}</span>
                                    </div>
                                    <div class="receipt-item">
                                        <span class="receipt-label">Email:</span>
                                        <span class="receipt-value">{{ $application->user->email }}</span>
                                    </div>
                                    <div class="receipt-item">
                                        <span class="receipt-label">Phone:</span>
                                        <span class="receipt-value">{{ $application->user->phone }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="receipt-footer">
                                <p class="validation">This is a computer-generated receipt and requires no signature.
                                </p>
                                <div class="watermark">PAID</div>
                                <p class="contact">For any queries, please contact: finance@university.edu |
                                    +1234567890</p>
                            </div>
                        </div>
                    </div>
                    {{-- PAYMENT RECIEPT VIEW ENDS HERE  --}}

                    <!-- Personal Info -->
                    <div class="info-card">
                        <h2><i class="fas fa-user"></i> Personal Details</h2>
                        <div class="profile justify-space-between d-flex">
                            <img src="{{ $application->user->photo }}" alt="Photo" class="avatar">
                            <div>
                                <div class="info-item">
                                    <span class="label">Name:</span>
                                    <span class="value">{{ $application->user->getFullNameAttribute() }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="label">Email:</span>
                                    <span class="value">{{ $application->user->email }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="label">Phone:</span>
                                    <span class="value">{{ $application->user->phone }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="label">Gender:</span>
                                    <span class="value">{{ ucfirst($application->user->gender ?? 'N/A') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Emergency Contact -->
                    <div class="info-card">
                        <h2><i class="fas fa-phone-alt"></i> Emergency Contact</h2>
                        <div class="info-item">
                            <span class="label">Name:</span>
                            <span class="value">{{ $application->user->kin_contact_name ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Relationship:</span>
                            <span class="value">{{ $application->user->kin_contact_relationship ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Phone:</span>
                            <span class="value">{{ $application->user->kin_contact_phone ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label"></span>
                            <span class="value">{{ $application->user->kin_contact_address ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Approved Application Sections -->
                @if ($application->status === 'approved')
                    <!-- Documents -->
                    <div class="documents">
                        <h2><i class="fas fa-file-download"></i> Documents</h2>
                        <div class="document-grid">
                            @foreach ([['title' => 'Admission Letter', 'icon' => 'fa-file-certificate', 'id' => 'downloadAdmissionBtn'], ['title' => 'Student Handbook', 'icon' => 'fa-book'], ['title' => 'Academic Calendar', 'icon' => 'fa-calendar-alt'], ['title' => 'Fee Structure', 'icon' => 'fa-money-check-alt']] as $doc)
                                <div class="document">
                                    <i class="fas {{ $doc['icon'] }}"></i>
                                    <div>
                                        <h3>{{ $doc['title'] }}</h3>
                                        <button class="btn btn-primary"
                                            @if (isset($doc['id'])) id="{{ $doc['id'] }}" @endif>
                                            <i class="fas fa-download"></i> Download
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Next Steps -->
                    <div class="next-steps">
                        <h2><i class="fas fa-tasks"></i> Next Steps</h2>
                        <div class="steps-grid">
                            @foreach ([['title' => 'Complete Registration', 'desc' => 'Submit documents & profile', 'link' => '#', 'text' => 'Start'], ['title' => 'Pay Tuition Fees', 'desc' => 'View payment schedule', 'link' => '#', 'text' => 'Pay'], ['title' => 'Orientation', 'desc' => 'Check schedule', 'link' => '#', 'text' => 'View'], ['title' => 'Course Registration', 'desc' => 'Select courses', 'link' => '#', 'text' => 'Browse']] as $index => $step)
                                <div class="step-card">
                                    <span class="step-number">{{ $index + 1 }}</span>
                                    <div>
                                        <h3>{{ $step['title'] }}</h3>
                                        <p>{{ $step['desc'] }}</p>
                                        <a href="{{ $step['link'] }}"
                                            class="btn btn-outline">{{ $step['text'] }}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Admission Letter (Printable) -->
                    <div id="printableAdmission" class="printable">
                        <div class="letter">
                            <div class="letter-header">
                                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
                                <div>
                                    <h1>UNIVERSITY NAME</h1>
                                    <p>Excellence in Education</p>
                                </div>
                            </div>
                            <h2>LETTER OF ADMISSION</h2>
                            <p class="ref">Ref: {{ $application->application_number }}</p>
                            <p class="date">{{ now()->format('F d, Y') }}</p>
                            <div class="address">
                                <p>{{ $application->user->getFullNameAttribute() }}</p>
                                <p>{{ $application->user->address }}</p>
                                <p>{{ $application->user->city }}, {{ $application->user->state }}</p>
                                <p>{{ $application->user->country }}</p>
                            </div>
                            <p>Dear {{ $application->user->first_name }},</p>
                            <div class="letter-body">
                                <p><strong>OFFER OF PROVISIONAL ADMISSION</strong></p>
                                <p>We are pleased to offer you provisional admission for the
                                    {{ $application->academicSession->name }} session...</p>
                                <!-- Add full letter content here -->
                            </div>
                            <div class="signature">
                                <img src="{{ asset('images/signature.png') }}" alt="Signature">
                                <p>Prof. John Doe<br>Registrar</p>
                            </div>
                            <p class="footer">University Address | Phone: +1234567890 | Email:
                                admissions@university.edu</p>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="actions">
                    <a href="{{ route('student.dashboard') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> Dashboard
                    </a>
                    @if ($application->status === 'approved')
                        <a href="#" class="btn btn-primary">
                            <i class="fas fa-graduation-cap"></i> Enroll
                        </a>
                    @else
                        <a href="#" class="btn btn-primary">
                            <i class="fas fa-question-circle"></i> Support
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const printBtn = document.getElementById('printAdmissionBtn');
            const downloadBtn = document.getElementById('downloadAdmissionBtn');

            [printBtn, downloadBtn].forEach(btn => {
                if (btn) btn.addEventListener('click', () => {
                    const printArea = document.getElementById('printableAdmission');
                    printArea.style.display = 'block';
                    window.print();
                    setTimeout(() => printArea.style.display = 'none', 1000);
                });
            });
        });
    </script>
    <style>
        /* Main Container and Card Styling */
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 15px;
        }

        .status-card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        /* Banner Styling */
        .status-banner {
            padding: 2.5rem;
            color: white;
            text-align: center;
            position: relative;
        }

        .status-banner.approved {
            background: linear-gradient(135deg, #28a745, #218838);
        }

        .status-banner.rejected {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }

        .status-banner.under_review,
        .status-banner.pending {
            background: linear-gradient(135deg, #fd7e14, #e76300);
        }

        .status-banner.draft {
            background: linear-gradient(135deg, #6c757d, #5a6268);
        }

        .status-banner.no-application {
            background: linear-gradient(135deg, #007bff, #0069d9);
        }

        .banner-content {
            max-width: 600px;
            margin: 0 auto;
        }

        .banner-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .banner-title {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .banner-text {
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            opacity: 0.9;
        }

        /* Progress Tracker */
        .progress-tracker {
            padding: 2rem;
            background-color: #f8f9fa;
            border-bottom: 1px solid #eaeaea;
        }

        .progress-steps {
            display: flex;
            justify-content: space-between;
            position: relative;
        }

        .progress-steps::before {
            content: '';
            position: absolute;
            top: 25px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #e9ecef;
            z-index: 1;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            width: 25%;
        }

        .step i {
            background-color: #e9ecef;
            color: #6c757d;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }

        .step.completed i {
            background-color: #28a745;
            color: white;
        }

        .step span {
            font-size: 0.9rem;
            color: #6c757d;
            font-weight: 500;
        }

        .step.completed span {
            color: #28a745;
        }

        /* Details Grid */
        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 1.5rem;
            padding: 1.5rem;
        }

        @media (max-width: 768px) {
            .details-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Info Cards */
        .info-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            border: 1px solid #eaeaea;
            height: 100%;
        }

        .info-card h2 {
            font-size: 1.25rem;
            color: #343a40;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border-bottom: 1px solid #eaeaea;
            padding-bottom: 0.75rem;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }

        .label {
            color: #6c757d;
            font-weight: 500;
        }

        .value {
            color: #343a40;
            font-weight: 600;
            text-align: right;
        }

        /* Status Indicators */
        .status {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .status.approved {
            background-color: #d4edda;
            color: #155724;
        }

        .status.rejected {
            background-color: #f8d7da;
            color: #721c24;
        }

        .status.under_review,
        .status.pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status.draft {
            background-color: #e2e3e5;
            color: #383d41;
        }

        /* Profile Section */
        /* .profile {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        } */

        .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #f8f9fa;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        /* Feedback Section */
        .feedback {
            margin-top: 1rem;
            padding: 1rem;
            background-color: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #dc3545;
        }

        .feedback h3 {
            font-size: 1rem;
            color: #dc3545;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .feedback p {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 0;
        }

        /* Documents Section */
        .documents {
            padding: 1.5rem;
            background-color: #f8f9fa;
            border-top: 1px solid #eaeaea;
        }

        .documents h2 {
            font-size: 1.25rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .document-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .document {
            background-color: white;
            border-radius: 8px;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #eaeaea;
        }

        .document i {
            font-size: 2rem;
            color: #007bff;
        }

        .document h3 {
            font-size: 1rem;
            margin-bottom: 0.75rem;
        }

        /* Next Steps Section */
        .next-steps {
            padding: 1.5rem;
            background-color: white;
        }

        .next-steps h2 {
            font-size: 1.25rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .step-card {
            padding: 1.25rem;
            border-radius: 8px;
            border: 1px solid #eaeaea;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            position: relative;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .step-number {
            background-color: #007bff;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            flex-shrink: 0;
        }

        .step-card h3 {
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .step-card p {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }

        /* Action Buttons */
        .actions {
            display: flex;
            justify-content: space-between;
            padding: 1.5rem;
            border-top: 1px solid #eaeaea;
        }

        /* Button Styling */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border-radius: 6px;
            padding: 0.5rem 1.25rem;
        }

        .btn-white {
            background-color: white;
            color: #343a40;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-white:hover {
            background-color: rgba(255, 255, 255, 0.9);
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
            border: 1px solid #007bff;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }

        .btn-outline {
            background-color: transparent;
            color: #007bff;
            border: 1px solid #007bff;
        }

        .btn-outline:hover {
            background-color: #007bff;
            color: white;
        }

        /* No Data States */
        .no-data {
            color: #6c757d;
            font-style: italic;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        /* Printable Admission Letter */
        .printable {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: white;
            z-index: 999;
            overflow: auto;
            padding: 2rem;
        }

        .letter {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
            border: 1px solid #ddd;
        }

        .letter-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #007bff;
        }

        .letter-header .logo {
            width: 100px;
        }

        .letter-header h1 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .letter h2 {
            text-align: center;
            font-size: 1.3rem;
            font-weight: 700;
            margin: 1.5rem 0;
        }

        .letter .ref,
        .letter .date {
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .letter .address {
            margin: 1.5rem 0;
        }

        .letter-body {
            margin: 1.5rem 0;
        }

        .signature {
            margin-top: 3rem;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .signature img {
            width: 150px;
            margin-bottom: 0.5rem;
        }

        .footer {
            margin-top: 3rem;
            text-align: center;
            font-size: 0.8rem;
            color: #6c757d;
            border-top: 1px solid #eaeaea;
            padding-top: 1rem;
        }

        /* Print Media Styles */
        @media print {
            body * {
                visibility: hidden;
            }

            .printable,
            .printable * {
                visibility: visible;
            }

            .printable {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .no-print {
                display: none !important;
            }
        }

        /* Responsive Adjustments */
        @media (max-width: 576px) {
            .status-banner {
                padding: 1.5rem;
            }

            .banner-icon {
                font-size: 2.5rem;
            }

            .banner-title {
                font-size: 1.5rem;
            }

            .progress-steps {
                overflow-x: auto;
                padding-bottom: 1rem;
            }

            .step {
                min-width: 100px;
            }

            .document-grid,
            .steps-grid {
                grid-template-columns: 1fr;
            }

            .actions {
                flex-direction: column;
                gap: 1rem;
            }

            .actions .btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* Bootstrap Overrides */
        .card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
        }

        /* Add Font Awesome Reference */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
    </style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const printBtn = document.getElementById('printAdmissionBtn');
        const downloadBtn = document.getElementById('downloadAdmissionBtn');
        const printReceiptBtn = document.getElementById('printReceiptBtn');

        [printBtn, downloadBtn].forEach(btn => {
            if (btn) btn.addEventListener('click', () => {
                const printArea = document.getElementById('printableAdmission');
                printArea.style.display = 'block';
                window.print();
                setTimeout(() => printArea.style.display = 'none', 1000);
            });
        });

        if (printReceiptBtn) {
            printReceiptBtn.addEventListener('click', () => {
                const printArea = document.getElementById('printableReceipt');
                printArea.style.display = 'block';
                window.print();
                setTimeout(() => printArea.style.display = 'none', 1000);
            });
        }
    });
</script>

<!-- Add receipt-specific styles -->
<style>
    /* Receipt Styling */
    #printableReceipt {
        background-color: white;
        font-family: Arial, sans-serif;
    }

    .receipt {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem;
        border: 1px solid #ddd;
        background-color: white;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .receipt-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #007bff;
    }

    .receipt-header .logo {
        width: 100px;
    }

    .receipt-header h1 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .receipt h2 {
        text-align: center;
        font-size: 1.5rem;
        font-weight: 700;
        margin: 1.5rem 0;
        color: #007bff;
    }

    .receipt-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    @media (max-width: 768px) {
        .receipt-container {
            grid-template-columns: 1fr;
        }
    }

    .receipt-section {
        padding: 1.5rem;
        border: 1px solid #eaeaea;
        border-radius: 8px;
        background-color: #f8f9fa;
    }

    .receipt-section h3 {
        font-size: 1.1rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #ddd;
        color: #343a40;
    }

    .receipt-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    .receipt-label {
        color: #6c757d;
        font-weight: 500;
    }

    .receipt-value {
        color: #343a40;
        font-weight: 600;
        text-align: right;
    }

    .status-text.success,
    .status-text.completed {
        color: #28a745;
    }

    .status-text.pending {
        color: #fd7e14;
    }

    .status-text.failed {
        color: #dc3545;
    }

    .receipt-footer {
        margin-top: 2rem;
        text-align: center;
        position: relative;
    }

    .validation {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .contact {
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: 2rem;
        border-top: 1px solid #eaeaea;
        padding-top: 1rem;
    }

    .watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-45deg);
        font-size: 4rem;
        color: rgba(40, 167, 69, 0.1);
        font-weight: bold;
        letter-spacing: 0.5rem;
        pointer-events: none;
        z-index: 1;
    }

    /* Print Media Styles */
    @media print {
        body * {
            visibility: hidden;
        }

        .printable,
        .printable * {
            visibility: visible;
        }

        .printable {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }

        .no-print {
            display: none !important;
        }

        .receipt {
            box-shadow: none;
            border: none;
        }
    }
</style>
</x-student-layout>
