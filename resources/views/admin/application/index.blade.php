<x-admin-layout>
    <x-slot name="title">
        {{ __('Applications') }}
    </x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Student Applications</h4>
                        <div class="card-tools">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                    Filter by Status <i class="fas fa-filter"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('admin.applications') }}">All</a>
                                    <a class="dropdown-item"
                                        href="{{ route('admin.applications', ['status' => 'draft']) }}">Draft</a>
                                    <a class="dropdown-item"
                                        href="{{ route('admin.applications', ['status' => 'submitted']) }}">Submitted</a>
                                    <a class="dropdown-item"
                                        href="{{ route('admin.applications', ['status' => 'under_review']) }}">Under
                                        Review</a>
                                    <a class="dropdown-item"
                                        href="{{ route('admin.applications', ['status' => 'approved']) }}">Approved</a>
                                    <a class="dropdown-item"
                                        href="{{ route('admin.applications', ['status' => 'rejected']) }}">Rejected</a>
                                </div>
                            </div>
                            <div class="ms-2 btn-group">
                                <button type="button" class="btn btn-success dropdown-toggle"
                                    data-bs-toggle="dropdown">
                                    Filter by Payment <i class="fas fa-money-bill"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('admin.applications') }}">All</a>
                                    <a class="dropdown-item"
                                        href="{{ route('admin.applications', ['payment' => 'paid']) }}">Paid</a>
                                    <a class="dropdown-item"
                                        href="{{ route('admin.applications', ['payment' => 'pending']) }}">Pending</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="" class="table table-striped table-bordered dt-responsive w-100">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Application #</th>
                                    <th>Student</th>
                                    <th>Academic Session</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Submitted</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($applications as $application)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $application->application_number }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.show', $application->user_id) }}">
                                                {{ $application->user->full_name }}
                                            </a>
                                        </td>
                                        <td>{{ $application->academicSession->name }}</td>
                                        <td>
                                            <span
                                                class="badge
                                                @if ($application->status == 'approved') bg-success
                                                @elseif($application->status == 'rejected') bg-danger
                                                @elseif($application->status == 'under_review') bg-warning
                                                @elseif($application->status == 'submitted') bg-info
                                                @else bg-secondary @endif">
                                                {{ ucfirst($application->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge
                                                @if ($application->payment_status == 'paid') bg-success
                                                @elseif($application->payment_status == 'failed') bg-danger
                                                @else bg-warning @endif">
                                                {{ ucfirst($application->payment_status) }}
                                            </span>
                                        </td>
                                        <td>{{ $application->submitted_at ? $application->submitted_at->format('M d, Y') : 'Not submitted' }}
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.applications.show', $application->id) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                                    data-bs-toggle="dropdown">
                                                    <i class="fas fa-cog"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    @if ($application->status == 'submitted' || $application->status == 'under_review')
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.applications.review', $application->id) }}">
                                                            <i class="fas fa-check-circle"></i> Review
                                                        </a>
                                                    @endif
                                                    @if ($application->status != 'approved')
                                                        <form
                                                            action="{{ route('admin.applications.approve', $application->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="dropdown-item text-success">
                                                                <i class="fas fa-check"></i> Approve
                                                            </button>
                                                        </form>
                                                    @endif
                                                    @if ($application->status != 'rejected')
                                                        <a class="dropdown-item text-danger" href="#"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#rejectModal{{ $application->id }}">
                                                            <i class="fas fa-times"></i> Reject
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No applications found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $applications->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($applications as $application)
        <!-- Reject Modal -->
        <div class="modal fade" id="rejectModal{{ $application->id }}" tabindex="-1"
            aria-labelledby="rejectModalLabel{{ $application->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('admin.applications.reject', $application->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="rejectModalLabel{{ $application->id }}">Reject Application</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3 form-group">
                                <label for="rejection_reason">Reason for Rejection</label>
                                <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Reject Application</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @push('styles')
        <!-- Bootstrap 5 CSS -->
        {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    @endpush

    @push('scripts')
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}

        <script>

            $(document).ready(function() {

                // Initialize Bootstrap dropdowns and modals
                var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
                var dropdownList = dropdownElementList.map(function(dropdownToggleEl) {
                    return new bootstrap.Dropdown(dropdownToggleEl)
                })

                var modalElementList = [].slice.call(document.querySelectorAll('.modal'))
                var modalList = modalElementList.map(function(modalEl) {
                    return new bootstrap.Modal(modalEl)
                })
            });
        </script>
    @endpush
</x-admin-layout>
