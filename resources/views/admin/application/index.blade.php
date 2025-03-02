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
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                    Filter by Status
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('admin.applications') }}">All</a>
                                    <a class="dropdown-item" href="{{ route('admin.applications', ['status' => 'draft']) }}">Draft</a>
                                    <a class="dropdown-item" href="{{ route('admin.applications', ['status' => 'submitted']) }}">Submitted</a>
                                    <a class="dropdown-item" href="{{ route('admin.applications', ['status' => 'under_review']) }}">Under Review</a>
                                    <a class="dropdown-item" href="{{ route('admin.applications', ['status' => 'approved']) }}">Approved</a>
                                    <a class="dropdown-item" href="{{ route('admin.applications', ['status' => 'rejected']) }}">Rejected</a>
                                </div>
                            </div>
                            <div class="ml-2 btn-group">
                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                    Filter by Payment
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('admin.applications') }}">All</a>
                                    <a class="dropdown-item" href="{{ route('admin.applications', ['payment' => 'paid']) }}">Paid</a>
                                    <a class="dropdown-item" href="{{ route('admin.applications', ['payment' => 'pending']) }}">Pending</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                            <table id="datatable-buttons"class="table table-striped table-bordered dt-responsive w-100">
                                <thead>
                                    <tr>
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
                                            <td>{{ $application->application_number }}</td>
                                            <td>
                                                <a href="{{ route('admin.users.show', $application->user_id) }}">
                                                    {{ $application->user->full_name }}
                                                </a>
                                            </td>
                                            <td>{{ $application->academicSession->name }}</td>
                                            <td>
                                                <span class="badge
                                                    @if($application->status == 'approved') badge-success
                                                    @elseif($application->status == 'rejected') badge-danger
                                                    @elseif($application->status == 'under_review') badge-warning
                                                    @elseif($application->status == 'submitted') badge-info
                                                    @else badge-secondary
                                                    @endif">
                                                    {{ ucfirst($application->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge
                                                    @if($application->payment_status == 'paid') badge-success
                                                    @elseif($application->payment_status == 'failed') badge-danger
                                                    @else badge-warning
                                                    @endif">
                                                    {{ ucfirst($application->payment_status) }}
                                                </span>
                                            </td>
                                            <td>{{ $application->submitted_at ? $application->submitted_at->format('M d, Y') : 'Not submitted' }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.applications.show', $application->id) }}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
                                                        <i class="fas fa-cog"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        @if($application->status == 'submitted' || $application->status == 'under_review')
                                                            <a class="dropdown-item" href="{{ route('admin.applications.review', $application->id) }}">
                                                                <i class="fas fa-check-circle"></i> Review
                                                            </a>
                                                        @endif
                                                        @if($application->status != 'approved')
                                                            <form action="{{ route('admin.applications.approve', $application->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="dropdown-item text-success">
                                                                    <i class="fas fa-check"></i> Approve
                                                                </button>
                                                            </form>
                                                        @endif
                                                        @if($application->status != 'rejected')
                                                            <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#rejectModal{{ $application->id }}">
                                                                <i class="fas fa-times"></i> Reject
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No applications found</td>
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

    @foreach($applications as $application)
        <!-- Reject Modal -->
        <div class="modal fade" id="rejectModal{{ $application->id }}" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('admin.applications.reject', $application->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="rejectModalLabel">Reject Application</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="rejection_reason">Reason for Rejection</label>
                                <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Reject Application</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @push('scripts')
    <script>
        $(function() {
            // Any specific JS for the applications page
        });
    </script>
    @endpush
</x-admin-layout>
