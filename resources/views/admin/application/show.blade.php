<!-- resources/views/admin/application/show.blade.php -->
<x-admin-layout>
    <x-slot name="title">{{ __('Application Details') }}</x-slot>

    <div class="container-fluid">
        <!-- Application Header with Status -->
        <div class="mb-4 row">
            <div class="col-md-12">
                <div class="card">
                    <div class="text-white card-header bg-primary">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="m-0">Application #{{ $application->application_number }}</h4>
                            <div>
                                <span class="badge bg-{{ $application->status == 'approved' ? 'success' : ($application->status == 'Rejected' ? 'danger' : ($application->status == 'under_review' ? 'warning' : 'info')) }} p-2">
                                    {{ ucfirst($application->status) }}
                                </span>
                                <span class="badge bg-{{ $application->payment_status == 'Successful' ? 'success' : ($application->payment_status == 'failed' ? 'danger' : 'warning') }} p-2 ms-2">
                                    Payment: {{ ucfirst($application->payment_status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Student Information -->
            <div class="col-md-4">
                <div class="mb-4 card">
                    <div class="card-header">
                        <h5 class="card-title">Student Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 text-center">
                            <div class="mx-auto avatar-circle">
                                <span class="initials">{{ substr($application->user->first_name, 0, 1) }}{{ substr($application->user->last_name, 0, 1) }}</span>
                            </div>
                        </div>
                        <table class="table table-borderless">
                            <tr>
                                <th>Name:</th>
                                <td>{{ $application->user->full_name }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $application->user->email }}</td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td>{{ $application->user->phone }}</td>
                            </tr>
                            <tr>
                                <th>Applied For:</th>
                                <td>{{ $application->academicSession->name }}</td>
                            </tr>
                            <tr>
                                <th>Applied On:</th>
                                <td>{{ $application->created_at->format('M d, Y') }}</td>
                            </tr>
                            <tr>
                                <th>Submitted:</th>
                                <td>{{ $application->submitted_at ? $application->submitted_at->format('M d, Y') : 'Not submitted' }}</td>
                            </tr>
                            @if($application->reviewed_at)
                            <tr>
                                <th>Reviewed:</th>
                                <td>{{ $application->reviewed_at->format('M d, Y') }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="mb-4 card">
                    <div class="card-header">
                        <h5 class="card-title">Payment Information</h5>
                    </div>
                    <div class="card-body">
                        @if($application->payment_status == 'Successful')
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i> Payment received on {{ $application->created_at ? $application->created_at?->format('M d, Y') : 'Unknown date' }}
                            </div>
                            <table class="table table-borderless">
                                <tr>
                                    <th>Transaction ID:</th>
                                    <td>{{ $application->payments?->first()->reference ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Amount:</th>
                                    <td>{{ $application->payments?->first()->amount ? 'N'.number_format($application->payments?->first()->amount, 2) : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Method:</th>
                                    <td>{{ $application->payments?->first()->currency ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        @elseif($application->payment_status == 'failed')
                            <div class="alert alert-danger">
                                <i class="fas fa-times-circle"></i> Payment failed
                               
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-clock"></i> Payment pending
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Admin Actions -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="gap-2 d-grid">
                            @if($application->status == 'submitted')
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#reviewModal">
                                    <i class="fas fa-search"></i> Mark for Review
                                </button>
                            @endif

                            @if(in_array($application->status, ['submitted', 'under_review']))
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal">
                                    <i class="fas fa-check"></i> Approve Application
                                </button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                    <i class="fas fa-times"></i> Reject Application
                                </button>
                            @endif

                            <a href="{{ route('admin.applications') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Application Details/Answers -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Application Responses</h5>
                    </div>
                    <div class="card-body">
                        @if($answers && $answers->count() > 0)
                            <div class="accordion" id="applicationAnswers">
                                @foreach($answers->groupBy(function($item) { return $item->question->section ?? 'General'; }) as $section => $sectionAnswers)
                                    <div class="mb-3 accordion-item">
                                        <h2 class="accordion-header" id="heading{{ Str::slug($section) }}">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ Str::slug($section) }}" aria-expanded="true" aria-controls="collapse{{ Str::slug($section) }}">
                                                {{ $section }}
                                            </button>
                                        </h2>
                                        <div id="collapse{{ Str::slug($section) }}" class="accordion-collapse collapse show" aria-labelledby="heading{{ Str::slug($section) }}">
                                            <div class="accordion-body">
                                                @foreach($sectionAnswers as $answer)
                                                    <div class="pb-3 mb-4 border-bottom">
                                                        <h6 class="text-primary">{{ $answer->question->text }}</h6>

                                                        @if($answer->question->type == 'file' && $answer->answer)
                                                            <div class="mt-2">
                                                                <a href="{{ Storage::url($answer->answer) }}" class="btn btn-sm btn-info" target="_blank">
                                                                    <i class="fas fa-file-download"></i> View Uploaded File
                                                                </a>
                                                            </div>
                                                        @elseif($answer->question->type == 'checkbox' && $answer->answer)
                                                            @php $options = json_decode($answer->answer, true) @endphp
                                                            <ul class="list-group list-group-flush">
                                                                @foreach($options as $option)
                                                                    <li class="list-group-item bg-light">{{ $option }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @elseif($answer->question->type == 'radio' || $answer->question->type == 'select')
                                                            <p class="p-2 rounded bg-light">{{ $answer->answer }}</p>
                                                        @elseif($answer->question->type == 'textarea')
                                                            <div class="p-3 rounded bg-light">
                                                                {!! nl2br(e($answer->answer)) !!}
                                                            </div>
                                                        @else
                                                            <p class="p-2 rounded bg-light">{{ $answer->answer }}</p>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @elseif($application->status == 'draft')
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> This application is still in draft mode. No responses have been submitted yet.
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i> No application responses found.
                            </div>
                        @endif
                    </div>
                </div>

                @if($application->status == 'rejected' && $application->rejection_reason)
                    <div class="mt-4 card">
                        <div class="text-white card-header bg-danger">
                            <h5 class="mb-0 card-title">Rejection Reason</h5>
                        </div>
                        <div class="card-body">
                            <p>{{ $application->rejection_reason }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal for Mark as Under Review -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Confirm Review Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to mark this application as "Under Review"?</p>
                    <p>This will notify the applicant that their application is being reviewed.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="{{ route('admin.applications.review', $application) }}" class="btn btn-warning">Mark as Under Review</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Approve Application -->
    <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveModalLabel">Confirm Approval</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to approve this application?</p>
                    <p>This will notify the applicant that their application has been approved.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="{{ route('admin.applications.approve', $application) }}" class="btn btn-success">Approve Application</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Reject Application -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Reject Application</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.applications.reject', $application) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>Please provide a reason for rejecting this application:</p>
                        <div class="mb-3">
                            <label for="rejection_reason" class="form-label">Rejection Reason</label>
                            <textarea class="form-control @error('rejection_reason') is-invalid @enderror" id="rejection_reason" name="rejection_reason" rows="4" required></textarea>
                            @error('rejection_reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <p class="text-muted small">This reason will be shared with the applicant.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Reject Application</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .avatar-circle {
            width: 80px;
            height: 80px;
            background-color: #007bff;
            text-align: center;
            border-radius: 50%;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
        }

        .initials {
            position: relative;
            top: 20px;
            font-size: 32px;
            line-height: 40px;
            color: #fff;
        }
    </style>
    @endpush
</x-admin-layout>
