<x-admin-layout>
    <x-slot name="title">
        {{ __('Student Profile') }}
    </x-slot>

    <div class="py-4 container-fluid">
        <!-- Page Heading -->
        <div class="mb-4 d-sm-flex align-items-center justify-content-between">
            <h1 class="mb-0 text-secondary h3">Student Profile: {{ $student->full_name }}</h1>
            <div>
                <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
                <a href="{{ route('admin.students') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-arrow-left me-1"></i> Back to Students
                </a>
            </div>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <!-- Profile Card -->
            <div class="mb-4 col-xl-4 col-md-6">
                <div class="border-4 shadow card h-100 border-start border-primary">
                    <div class="flex-row py-3 card-header d-flex align-items-center justify-content-between bg-light">
                        <h6 class="m-0 fw-bold text-primary">Student Information</h6>
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="text-muted fas fa-ellipsis-v fa-sm fa-fw"></i>
                            </a>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <img class="mb-3 img-profile rounded-circle" src="{{ $student->photo }}"
                                alt="{{ $student->full_name }}" style="width: 150px; height: 150px; object-fit: cover;">
                            <h5 class="fw-bold">{{ $student->full_name }}</h5>
                            <p class="mb-2">
                                <span class="badge bg-{{ $student->is_active ? 'success' : 'danger' }}">
                                    {{ $student->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                @if ($student->is_blacklisted)
                                    <span class="badge bg-dark">Blacklisted</span>
                                @endif
                            </p>
                            <p class="mb-1 text-muted">
                                <i class="fas fa-id-card me-2"></i> ID: {{ $student->id_number }}
                            </p>
                            <p class="mb-1 text-muted">
                                <i class="fas fa-user me-2"></i> Username: {{ $student->username }}
                            </p>
                        </div>
                        <hr>
                        <div class="mt-3">
                            <p class="mb-2">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                <span class="fw-bold">Email:</span> {{ $student->email }}
                            </p>
                            <p class="mb-2">
                                <i class="fas fa-phone text-primary me-2"></i>
                                <span class="fw-bold">Phone:</span> {{ $student->phone ?? 'Not provided' }}
                            </p>
                            <p class="mb-2">
                                <i class="fas fa-venus-mars text-primary me-2"></i>
                                <span class="fw-bold">Gender:</span> {{ ucfirst($student->gender) }}
                            </p>
                            <p class="mb-2">
                                <i class="fas fa-birthday-cake text-primary me-2"></i>
                                <span class="fw-bold">Date of Birth:</span>
                                {{ $student->date_of_birth?->format('M d, Y') }}
                            </p>
                            <p class="mb-2">
                                <i class="fas fa-clock text-primary me-2"></i>
                                <span class="fw-bold">Last Login:</span>
                                {{ $student->last_login_at ? $student->last_login_at?->diffForHumans() : 'Never' }}
                            </p>

                        </div>


                    </div>
                </div>
            </div>

            <!-- Contact Information Card -->
            <div class="mb-4 col-xl-4 col-md-6">
                <div class="border-4 shadow card h-100 border-start border-info">
                    <div class="py-3 card-header bg-light">
                        <h6 class="m-0 fw-bold text-info">Contact Information</h6>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-3 fw-bold">Address</h6>
                        <p class="mb-1">{{ $student->address ?? 'Not provided' }}</p>
                        @if ($student->address_line_2)
                            <p class="mb-1">{{ $student->address_line_2 }}</p>
                        @endif
                        <p class="mb-3">
                            {{ collect([$student->city, $student->state, $student->postal_code])->filter()->join(', ') }}
                            {{ $student->country ? ', ' . $student->country : '' }}
                        </p>

                        <hr>

                        <h6 class="mb-3 fw-bold">Emergency Contact</h6>
                        @if ($student->kin_contact_name)
                            <p class="mb-2">
                                <i class="fas fa-user text-info me-2"></i>
                                <span class="fw-bold">Name:</span> {{ $student->kin_contact_name }}
                            </p>
                            <p class="mb-2">
                                <i class="fas fa-phone text-info me-2"></i>
                                <span class="fw-bold">Phone:</span> {{ $student->kin_contact_phone ?? 'Not provided' }}
                            </p>
                            <p class="mb-2">
                                <i class="fas fa-users text-info me-2"></i>
                                <span class="fw-bold">Relationship:</span>
                                {{ $student->kin_contact_relationship ?? 'Not provided' }}
                            </p>
                            @if ($student->kin_contact_address)
                                <p class="mb-2">
                                    <i class="fas fa-home text-info me-2"></i>
                                    <span class="fw-bold">Address:</span> {{ $student->kin_contact_address }}
                                </p>
                            @endif
                        @else
                            <p class="text-muted">No emergency contact information provided.</p>
                        @endif

                        <hr>

                        <div class="mt-3">
                            <form action="{{ route('admin.students.send-verification-email', $student) }}"
                                method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-info btn-sm">
                                    <i class="fas fa-envelope me-1"></i> Send Verification Email
                                </button>
                            </form>
                            <hr>

                            <!-- Add action buttons at the bottom of the card -->
                            <div class="mt-4 d-flex justify-content-between">
                                <form action="{{ route('admin.students.reset-password', $student) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-key fa-sm fa-fw me-1"></i>
                                        Password
                                    </button>
                                </form>

                                <form action="{{ route('admin.students.toggle-active', $student) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="btn btn-{{ $student->is_active ? 'outline-danger' : 'outline-success' }} btn-sm">
                                        <i
                                            class="fas {{ $student->is_active ? 'fa-user-slash' : 'fa-user-check' }} fa-sm fa-fw me-1"></i>
                                        {{ $student->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>

                                <button type="button"
                                    class="btn btn-{{ $student->is_blacklisted ? 'outline-success' : 'outline-dark' }} btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#blacklistModal">
                                    <i
                                        class="fas {{ $student->is_blacklisted ? 'fa-user-check' : 'fa-ban' }} fa-sm fa-fw me-1"></i>
                                    {{ $student->is_blacklisted ? 'Unblacklist' : 'Blacklist' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Applications Card -->
            <div class="mb-4 col-xl-4 col-md-12">
                <div class="border-4 shadow card h-100 border-start border-success">
                    <div class="flex-row py-3 card-header d-flex align-items-center justify-content-between bg-light">
                        <h6 class="m-0 fw-bold text-success">Academic Applications</h6>
                        <a href="#" class="btn btn-success btn-sm">
                            <i class="fas fa-plus me-1"></i> Add Application
                        </a>
                    </div>
                    <div class="card-body">
                        @if ($student->applications->count() > 0)
                            <div class="list-group">
                                @foreach ($student->applications as $application)
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">{{ $application->academicSession->name }}</h6>
                                            <small>
                                                <span
                                                    class="badge bg-{{ $application->status_color }}">{{ $application->status }}</span>
                                            </small>
                                        </div>
                                        <small class="text-muted">Applied:
                                            {{ $application->created_at->format('M d, Y') }}</small>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="py-4 text-center">
                                <i class="mb-3 fas fa-folder-open fa-3x text-muted"></i>
                                <p class="mb-0">No applications found for this student.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Timeline -->
        <!-- Activity Timeline -->
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-4 shadow card">
                    <div class="py-3 card-header bg-light">
                        <h6 class="m-0 fw-bold text-primary">Activity Timeline</h6>
                    </div>
                    <div class="card-body">
                        @if (count($activities) > 0)
                            <div class="timeline">
                                @foreach ($activities as $activity)
                                    <div class="timeline-item">
                                        <div class="timeline-item-marker">
                                            <div class="timeline-item-marker-text">
                                                {{ $activity->created_at->format('M d') }}
                                            </div>
                                            <div class="timeline-item-marker-indicator bg-primary"></div>
                                        </div>
                                        <div class="timeline-item-content">
                                            <p class="mb-0">
                                                {{ $activity->description }}
                                                @if ($activity->properties->count() > 0)
                                                    <button class="btn btn-sm btn-link" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#activity-{{ $activity->id }}"
                                                        aria-expanded="false">
                                                        <i class="fas fa-caret-down"></i>
                                                    </button>
                                                @endif
                                            </p>
                                            <small class="text-muted">
                                                {{ $activity->created_at->diffForHumans() }}
                                                @if ($activity->causer)
                                                    by {{ $activity->causer->full_name ?? 'System' }}
                                                @endif
                                            </small>

                                            @if ($activity->properties->count() > 0)
                                                <div class="mt-2 collapse" id="activity-{{ $activity->id }}">
                                                    <div class="card card-body bg-light">
                                                        <h6 class="mb-2">Changes:</h6>
                                                        <ul class="mb-0">
                                                            @foreach ($activity->properties['attributes'] ?? [] as $key => $value)
                                                                @if (isset($activity->properties['old'][$key]) && $activity->properties['old'][$key] !== $value)
                                                                    <li>
                                                                        <strong>{{ ucfirst($key) }}</strong>:
                                                                        <span
                                                                            class="text-danger">{{ $activity->properties['old'][$key] }}</span>
                                                                        →
                                                                        <span
                                                                            class="text-success">{{ $value }}</span>
                                                                    </li>
                                                                @elseif(!isset($activity->properties['old'][$key]))
                                                                    <li>
                                                                        <strong>{{ ucfirst($key) }}</strong>:
                                                                        <span
                                                                            class="text-success">{{ $value }}</span>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="py-5 text-center timeline-placeholder">
                                <i class="mb-3 fas fa-history fa-3x text-muted"></i>
                                <p class="mb-0">No activity records found for this student.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Blacklist Modal -->
    <div class="modal fade" id="blacklistModal" tabindex="-1" aria-labelledby="blacklistModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.students.toggle-blacklist', $student) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="blacklistModalLabel">
                            {{ $student->is_blacklisted ? 'Remove from Blacklist' : 'Blacklist Student' }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if ($student->is_blacklisted)
                            <p>Are you sure you want to remove this student from the blacklist?</p>
                            <p><strong>Current blacklist reason:</strong> {{ $student->blacklist_reason }}</p>
                        @else
                            <p>Are you sure you want to blacklist this student?</p>
                            <div class="mb-3">
                                <label for="blacklist_reason" class="form-label">Reason for blacklisting</label>
                                <textarea class="form-control" id="blacklist_reason" name="blacklist_reason" rows="3" required></textarea>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-{{ $student->is_blacklisted ? 'success' : 'danger' }}">
                            {{ $student->is_blacklisted ? 'Remove from Blacklist' : 'Blacklist Student' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            /* Timeline styles */
            .timeline {
                position: relative;
                padding-left: 1.5rem;
            }

            .timeline:before {
                content: '';
                position: absolute;
                top: 0;
                left: 0.5rem;
                height: 100%;
                width: 2px;
                background-color: #e3e6ec;
            }

            .timeline-item {
                position: relative;
                padding-bottom: 1.5rem;
            }

            .timeline-item:last-child {
                padding-bottom: 0;
            }

            .timeline-item-marker {
                position: absolute;
                left: -1.5rem;
                width: 1rem;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .timeline-item-marker-text {
                font-size: 0.75rem;
                color: #a2acba;
                margin-bottom: 0.25rem;
            }

            .timeline-item-marker-indicator {
                height: 0.75rem;
                width: 0.75rem;
                border-radius: 100%;
                background-color: #0061f2;
            }

            .timeline-item-content {
                padding-left: 1rem;
                padding-bottom: 1rem;
                border-bottom: 1px solid #e3e6ec;
            }

            .timeline-item:last-child .timeline-item-content {
                border-bottom: none;
                padding-bottom: 0;
            }
        </style>
    @endpush
    @push('scripts')
    @endpush
</x-admin-layout>
