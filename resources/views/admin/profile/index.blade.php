<x-admin-layout>
    <x-slot name="title">
        {{ __('Profile') }}
    </x-slot>

    <div class="container py-4">
        <div class="row">
            <!-- Profile Summary Card -->
            <div class="mb-4 col-md-4">
                <div class="border-0 shadow-sm card">
                    <div class="py-5 text-center card-body">
                        <div class="mx-auto mb-4 position-relative" style="width: 150px; height: 150px;">
                            <img id="profile-image" src="{{ auth()->user()->photo }}" class="rounded-circle img-thumbnail"
                                style="width: 150px; height: 150px; object-fit: cover;" alt="Profile Photo">
                            <button type="button" class="bottom-0 btn btn-primary btn-sm position-absolute end-0"
                                data-bs-toggle="modal" data-bs-target="#photoModal">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                        <h4>{{ auth()->user()->full_name }}</h4>
                        <p class="text-muted">{{ auth()->user()->role->name }}</p>
                        <div class="d-flex justify-content-center">
                            <span class="badge {{ auth()->user()->is_active ? 'bg-success' : 'bg-danger' }} me-2">
                                {{ auth()->user()->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                    <div class="py-3 card-footer bg-light">
                        <div class="text-center row">
                            <div class="col-6">
                                <div class="fw-bold">Last Login</div>
                                <small>{{ auth()->user()->last_login_at ? auth()->user()->last_login_at->diffForHumans() : 'Never' }}</small>
                            </div>
                            <div class="col-6">
                                <div class="fw-bold">IP Address</div>
                                <small>{{ auth()->user()->last_login_ip ?? 'Unknown' }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Details and Tabs -->
            <div class="col-md-8">
                <div class="border-0 shadow-sm card">
                    <div class="py-3 bg-white card-header">
                        <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="details-tab" data-bs-toggle="tab" href="#details"
                                    role="tab">Profile Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="edit-tab" data-bs-toggle="tab" href="#edit"
                                    role="tab">Edit Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="password-tab" data-bs-toggle="tab" href="#password"
                                    role="tab">Change Password</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="sessions-tab" data-bs-toggle="tab" href="#sessions"
                                    role="tab">Active Sessions</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Profile Details Tab -->
                            <div class="tab-pane fade show active" id="details" role="tabpanel">
                                <h5 class="mb-4 card-title" style="text-decoration: underline">Personal Information</h5>
                                <div class="mb-4 row">
                                    <div class="p-3 mb-3 card col-md-6">
                                        <h6 class="fw-bold">Full Name</h6>
                                        <p>{{ auth()->user()->full_name }}</p>
                                    </div>
                                    <div class="p-3 mb-3 card col-md-6">
                                        <h6 class="fw-bold">Username</h6>
                                        <p>{{ auth()->user()->username }}</p>
                                    </div>
                                    <div class="p-3 mb-3 card col-md-6">
                                        <h6 class="fw-bold">Email</h6>
                                        <p>{{ auth()->user()->email }}</p>
                                    </div>
                                    <div class="p-3 mb-3 card col-md-6">
                                        <h6 class="fw-bold">Phone</h6>
                                        <p>{{ auth()->user()->phone }}</p>
                                    </div>
                                    <div class="p-3 mb-3 card col-md-6">
                                        <h6 class="fw-bold">Date of Birth</h6>
                                        <p>{{ auth()->user()->date_of_birth ? auth()->user()->date_of_birth->format('M d, Y') : 'Not provided' }}
                                        </p>
                                    </div>
                                    <div class="p-3 mb-3 card col-md-6">
                                        <h6 class="fw-bold">Gender</h6>
                                        <p>{{ auth()->user()->gender ?? 'Not provided' }}</p>
                                    </div>
                                </div>

                                <hr>
                                <h5 class="mb-4 card-title" style="text-decoration: underline">Contact & Address</h5>
                                <div class="row">
                                    <div class="p-3 mb-3 card col-md-12">
                                        <h6 class="fw-bold">Address</h6>
                                        <p>
                                            {{ auth()->user()->address ?? 'Not provided' }}
                                            {{ auth()->user()->address_line_2 ? ', ' . auth()->user()->address_line_2 : '' }}
                                        </p>
                                    </div>
                                    <div class="p-3 mb-3 card col-md-6">
                                        <h6 class="fw-bold">City</h6>
                                        <p>{{ auth()->user()->city ?? 'Not provided' }}</p>
                                    </div>
                                    <div class="p-3 mb-3 card col-md-6">
                                        <h6 class="fw-bold">State</h6>
                                        <p>{{ auth()->user()->state ?? 'Not provided' }}</p>
                                    </div>
                                    <div class="p-3 mb-3 card col-md-6">
                                        <h6 class="fw-bold">Postal Code</h6>
                                        <p>{{ auth()->user()->postal_code ?? 'Not provided' }}</p>
                                    </div>
                                    <div class="p-3 mb-3 card col-md-6">
                                        <h6 class="fw-bold">Country</h6>
                                        <p>{{ auth()->user()->country ?? 'Not provided' }}</p>
                                    </div>
                                </div>

                                <hr>
                                <h5 class="mb-4 card-title" style="text-decoration: underline">Emergency Contact</h5>
                                <div class="row">
                                    <div class="p-3 mb-3 card col-md-6">
                                        <h6 class="fw-bold">Contact Name</h6>
                                        <p>{{ auth()->user()->kin_contact_name ?? 'Not provided' }}</p>
                                    </div>
                                    <div class="p-3 mb-3 card col-md-6">
                                        <h6 class="fw-bold">Relationship</h6>
                                        <p>{{ auth()->user()->kin_contact_relationship ?? 'Not provided' }}</p>
                                    </div>
                                    <div class="p-3 mb-3 card col-md-6">
                                        <h6 class="fw-bold">Contact Phone</h6>
                                        <p>{{ auth()->user()->kin_contact_phone ?? 'Not provided' }}</p>
                                    </div>
                                    <div class="p-3 mb-3 card col-md-6">
                                        <h6 class="fw-bold">Contact Address</h6>
                                        <p>{{ auth()->user()->kin_contact_address ?? 'Not provided' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Profile Tab -->
                            <div class="tab-pane fade" id="edit" role="tabpanel">
                                <h5 class="mb-4 card-title">Update Profile Information</h5>
                                <form action="{{ route('admin.profile.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3 row">
                                        <div class="col-md-4">
                                            <label for="first_name" class="form-label">First Name</label>
                                            <input type="text"
                                                class="form-control @error('first_name') is-invalid @enderror"
                                                id="first_name" name="first_name"
                                                value="{{ old('first_name', auth()->user()->first_name) }}" >
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="last_name" class="form-label">Last Name</label>
                                            <input type="text"
                                                class="form-control @error('last_name') is-invalid @enderror"
                                                id="last_name" name="last_name"
                                                value="{{ old('last_name', auth()->user()->last_name) }}" required>
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="other_names" class="form-label">Other Names</label>
                                            <input type="text"
                                                class="form-control @error('other_names') is-invalid @enderror"
                                                id="other_names" name="other_names"
                                                value="{{ old('other_names', auth()->user()->other_names) }}">
                                            @error('other_names')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <div class="col-md-6">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text"
                                                class="form-control @error('username') is-invalid @enderror"
                                                id="username" name="username"
                                                value="{{ old('username', auth()->user()->username) }}" required>
                                            @error('username')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                id="email" name="email"
                                                value="{{ old('email', auth()->user()->email) }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">Phone</label>
                                            <input type="tel"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                id="phone" name="phone"
                                                value="{{ old('phone', auth()->user()->phone) }}" required>
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="id_number" class="form-label">ID Number</label>
                                            <input type="text"
                                                class="form-control @error('id_number') is-invalid @enderror"
                                                id="id_number" name="id_number"
                                                value="{{ old('id_number', auth()->user()->id_number) }}">
                                            @error('id_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <div class="col-md-6">
                                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                                            <input type="date"
                                                class="form-control @error('date_of_birth') is-invalid @enderror"
                                                id="date_of_birth" name="date_of_birth"
                                                value="{{ old('date_of_birth', auth()->user()->date_of_birth?->format('Y-m-d')) }}">
                                            @error('date_of_birth')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="gender" class="form-label">Gender</label>
                                            <select class="form-select @error('gender') is-invalid @enderror"
                                                id="gender" name="gender">
                                                <option value="">Select Gender</option>
                                                <option value="Male"
                                                    {{ old('gender', auth()->user()->gender) === 'Male' ? 'selected' : '' }}>
                                                    Male</option>
                                                <option value="Female"
                                                    {{ old('gender', auth()->user()->gender) === 'Female' ? 'selected' : '' }}>
                                                    Female</option>
                                                <option value="Other"
                                                    {{ old('gender', auth()->user()->gender) === 'Other' ? 'selected' : '' }}>
                                                    Other</option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <hr class="my-4">
                                    <h6 class="mb-3 fw-bold">Address Information</h6>

                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text"
                                            class="form-control @error('address') is-invalid @enderror" id="address"
                                            name="address" value="{{ old('address', auth()->user()->address) }}">
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="address_line_2" class="form-label">Address Line 2</label>
                                        <input type="text"
                                            class="form-control @error('address_line_2') is-invalid @enderror"
                                            id="address_line_2" name="address_line_2"
                                            value="{{ old('address_line_2', auth()->user()->address_line_2) }}">
                                        @error('address_line_2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 row">
                                        <div class="col-md-6">
                                            <label for="city" class="form-label">City</label>
                                            <input type="text"
                                                class="form-control @error('city') is-invalid @enderror"
                                                id="city" name="city"
                                                value="{{ old('city', auth()->user()->city) }}">
                                            @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="state" class="form-label">State/Province</label>
                                            <input type="text"
                                                class="form-control @error('state') is-invalid @enderror"
                                                id="state" name="state"
                                                value="{{ old('state', auth()->user()->state) }}">
                                            @error('state')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <div class="col-md-6">
                                            <label for="postal_code" class="form-label">Postal Code</label>
                                            <input type="text"
                                                class="form-control @error('postal_code') is-invalid @enderror"
                                                id="postal_code" name="postal_code"
                                                value="{{ old('postal_code', auth()->user()->postal_code) }}">
                                            @error('postal_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="country" class="form-label">Country</label>
                                            <input type="text"
                                                class="form-control @error('country') is-invalid @enderror"
                                                id="country" name="country"
                                                value="{{ old('country', auth()->user()->country) }}">
                                            @error('country')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <hr class="my-4">
                                    <h6 class="mb-3 fw-bold">Emergency Contact</h6>

                                    <div class="mb-3 row">
                                        <div class="col-md-6">
                                            <label for="kin_contact_name" class="form-label">Contact Name</label>
                                            <input type="text"
                                                class="form-control @error('kin_contact_name') is-invalid @enderror"
                                                id="kin_contact_name" name="kin_contact_name"
                                                value="{{ old('kin_contact_name', auth()->user()->kin_contact_name) }}">
                                            @error('kin_contact_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="kin_contact_relationship"
                                                class="form-label">Relationship</label>
                                            <input type="text"
                                                class="form-control @error('kin_contact_relationship') is-invalid @enderror"
                                                id="kin_contact_relationship" name="kin_contact_relationship"
                                                value="{{ old('kin_contact_relationship', auth()->user()->kin_contact_relationship) }}">
                                            @error('kin_contact_relationship')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <div class="col-md-6">
                                            <label for="kin_contact_phone" class="form-label">Contact Phone</label>
                                            <input type="tel"
                                                class="form-control @error('kin_contact_phone') is-invalid @enderror"
                                                id="kin_contact_phone" name="kin_contact_phone"
                                                value="{{ old('kin_contact_phone', auth()->user()->kin_contact_phone) }}">
                                            @error('kin_contact_phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="kin_contact_address" class="form-label">Contact
                                                Address</label>
                                            <input type="text"
                                                class="form-control @error('kin_contact_address') is-invalid @enderror"
                                                id="kin_contact_address" name="kin_contact_address"
                                                value="{{ old('kin_contact_address', auth()->user()->kin_contact_address) }}">
                                            @error('kin_contact_address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="gap-2 d-grid d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-primary">Update Profile</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Change Password Tab -->
                            <div class="tab-pane fade" id="password" role="tabpanel">
                                <h5 class="mb-4 card-title">Change Password</h5>
                                <form action="{{ route('admin.profile.update-password') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Current Password</label>
                                        <input type="password"
                                            class="form-control @error('current_password') is-invalid @enderror"
                                            id="current_password" name="current_password" required>
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">New Password</label>
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            id="password" name="password" required>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Confirm New
                                            Password</label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" required>
                                    </div>

                                    <div class="gap-2 d-grid d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-primary">Update Password</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Active Sessions Tab -->
                            <div class="tab-pane fade" id="sessions" role="tabpanel">
                                <div class="mb-4 d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0 card-title">Active Sessions</h5>
                                    <form action="{{ route('admin.profile.logout-all') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout All Devices
                                        </button>
                                    </form>
                                </div>

                                @if (count($sessions ?? []) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Device / Browser</th>
                                                    <th>IP Address</th>
                                                    <th>Last Activity</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($sessions as $session)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <i
                                                                    class="fas {{ $session->is_current ? 'fa-desktop text-success' : 'fa-mobile-alt text-muted' }} fa-lg me-3"></i>
                                                                <div>
                                                                    <div>{{ $session->agent_name }}</div>
                                                                    <small class="text-muted">{{ $session->platform }}
                                                                        {{ $session->is_current ? '(Current device)' : '' }}</small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{{ $session->ip_address }}</td>
                                                        <td>{{ $session->last_active }}</td>
                                                        <td>
                                                            @if (!$session->is_current)
                                                                <form
                                                                    action="{{ route('admin.profile.logout-session', $session->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-outline-danger">
                                                                        Logout
                                                                    </button>
                                                                </form>
                                                            @else
                                                                <span class="badge bg-primary">Current Session</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i> No active sessions found other than
                                        your current session.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Photo Upload Modal -->
    <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="photoModalLabel">Update Profile Photo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="img-container">
                                <img id="image" src="{{ auth()->user()->photo }}" class="img-fluid"
                                    alt="Your image to crop">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3 preview-container">
                                <h6>Preview:</h6>
                                <div class="mx-auto preview rounded-circle"
                                    style="width: 150px; height: 150px; overflow: hidden;"></div>
                            </div>
                            <div class="gap-2 d-grid">
                                <input type="file" class="form-control" id="inputImage" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('admin.profile.delete-photo') }}" method="POST" class="me-auto">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger"
                            {{ empty(auth()->user()->photo) ? 'disabled' : '' }}>
                            <i class="fas fa-trash me-2"></i> Remove Photo
                        </button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.profile.update-photo') }}" method="POST" id="cropForm">
                        @csrf
                        <input type="hidden" name="cropped_data" id="cropped_data">
                        <button type="submit" class="btn btn-primary" id="crop-btn" disabled>
                            <i class="fas fa-save me-2"></i> Save Photo
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

   

    <div class="container py-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (count($missingFields) > 0)
            <div class="mb-4 alert alert-warning alert-missing-details">
                <h5><i class="fas fa-exclamation-triangle me-2"></i> Complete Your Profile</h5>
                <p>Please update the following information to complete your profile:</p>
                <ul class="mb-0">
                    @foreach ($missingFields as $field => $label)
                        <li>{{ $label }}</li>
                    @endforeach
                </ul>
                <div class="mt-3">
                    <a href="#personal-info-section" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit me-1"></i> Update Now
                    </a>
                </div>
            </div>
        @endif

        <div class="row g-4">
            <!-- Left Column -->
            <div class="col-md-4">
                <!-- Profile Card -->
                <div class="mb-4 shadow-sm card">
                    <div class="text-center card-body">
                        <div class="mb-3 profile-img-container">
                            <img src="{{ asset($user->photo ?? 'images/default-profile.jpg') }}" alt="{{ $user->full_name }}" id="profile-image" class="rounded-circle img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>

                        <h5 class="card-title">{{ $user->full_name }}</h5>
                        <p class="text-muted">{{ $user->username }}</p>

                        <div class="mt-3 upload-btn-wrapper">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-camera me-2"></i> Change Photo
                            </button>
                            <input type="file" id="upload-photo" accept="image/*" />
                        </div>
                    </div>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-envelope me-2"></i> Email</span>
                            <span>{{ $user->email }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-phone me-2"></i> Phone</span>
                            <span>{{ $user->phone ?? 'Not set' }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-id-card me-2"></i> ID Number</span>
                            <span>{{ $user->id_number ?? 'Not set' }}</span>
                        </div>
                        <div class="list-group-item">
                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#passwordModal">
                                <i class="fas fa-lock me-2"></i> Change Password
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Last Login Information -->
                <div class="shadow-sm card">
                    <div class="bg-white card-header">
                        <h5 class="mb-0 card-title">Login Activity</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6>Last Login</h6>
                            <p class="mb-1">
                                <i class="fas fa-calendar me-2"></i>
                                {{ $user->last_login_at ? $user->last_login_at->format('M d, Y h:i A') : 'N/A' }}
                            </p>
                            <p class="mb-1">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                <span id="last-login-location">Loading location...</span>
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-laptop me-2"></i>
                                {{ $user->last_login_ip ?? 'N/A' }}
                            </p>
                        </div>

                        <h6>Active Sessions</h6>
                        <div class="list-group">
                            @forelse($sessions as $session)
                                <div class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $session['location'] }}</h6>
                                        <small>{{ $session['is_current'] ? 'Current' : '' }}</small>
                                    </div>
                                    <p class="mb-1">{{ $session['ip_address'] }}</p>
                                    <small>{{ $session['last_activity'] }}</small>
                                </div>
                            @empty
                                <div class="list-group-item">No active sessions found</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-8">
                <div class="shadow-sm card">
                    <div class="bg-white card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 card-title" id="personal-info-section">Personal Information</h5>
                        <span class="text-muted small">* Required fields</span>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('student.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Personal Information Section -->
                            <div class="mb-4">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="mb-3 form-group">
                                            <label for="first_name" class="form-label">First Name *</label>
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}">
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3 form-group">
                                            <label for="last_name" class="form-label">Last Name *</label>
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}">
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3 form-group">
                                            <label for="other_names" class="form-label">Other Names</label>
                                            <input type="text" class="form-control @error('other_names') is-invalid @enderror" id="other_names" name="other_names" value="{{ old('other_names', $user->other_names) }}">
                                            @error('other_names')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 row g-3">
                                    <div class="col-md-4">
                                        <div class="mb-3 form-group">
                                            <label for="email" class="form-label">Email Address *</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3 form-group">
                                            <label for="phone" class="form-label">Phone Number *</label>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3 form-group">
                                            <label for="id_number" class="form-label">ID Number</label>
                                            <input type="text" class="form-control @error('id_number') is-invalid @enderror" id="id_number" name="id_number" value="{{ old('id_number', $user->id_number) }}">
                                            @error('id_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-3 form-group">
                                            <label for="date_of_birth" class="form-label">Date of Birth *</label>
                                            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '') }}">
                                            @error('date_of_birth')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3 form-group">
                                            <label for="gender" class="form-label">Gender *</label>
                                            <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                                <option value="">Select Gender</option>
                                                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                                <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Address Information Section -->
                            <h5 class="pb-2 mt-4 mb-3 border-bottom">Address Information</h5>
                            <div class="mb-4">
                                <div class="mb-3 row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-3 form-group">
                                            <label for="address" class="form-label">Address *</label>
                                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $user->address) }}">
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3 form-group">
                                            <label for="address_line_2" class="form-label">Address Line 2</label>
                                            <input type="text" class="form-control @error('address_line_2') is-invalid @enderror" id="address_line_2" name="address_line_2" value="{{ old('address_line_2', $user->address_line_2) }}">
                                            @error('address_line_2')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 row g-3">
                                    <div class="col-md-3">
                                        <div class="mb-3 form-group">
                                            <label for="city" class="form-label">City *</label>
                                            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city', $user->city) }}">
                                            @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3 form-group">
                                            <label for="state" class="form-label">State/Province *</label>
                                            <input type="text" class="form-control @error('state') is-invalid @enderror" id="state" name="state" value="{{ old('state', $user->state) }}">
                                            @error('state')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3 form-group">
                                            <label for="postal_code" class="form-label">Postal Code</label>
                                            <input type="text" class="form-control @error('postal_code') is-invalid @enderror" id="postal_code" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}">
                                            @error('postal_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3 form-group">
                                            <label for="country" class="form-label">Country *</label>
                                            <input type="text" class="form-control @error('country') is-invalid @enderror" id="country" name="country" value="{{ old('country', $user->country) }}">
                                            @error('country')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Next of Kin Information Section -->
                            <h5 class="pb-2 mt-4 mb-3 border-bottom">Next of Kin Information</h5>
                            <div class="mb-4">
                                <div class="mb-3 row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-3 form-group">
                                            <label for="kin_contact_name" class="form-label">Next of Kin Name *</label>
                                            <input type="text" class="form-control @error('kin_contact_name') is-invalid @enderror" id="kin_contact_name" name="kin_contact_name" value="{{ old('kin_contact_name', $user->kin_contact_name) }}">
                                            @error('kin_contact_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3 form-group">
                                            <label for="kin_contact_phone" class="form-label">Next of Kin Phone *</label>
                                            <input type="text" class="form-control @error('kin_contact_phone') is-invalid @enderror" id="kin_contact_phone" name="kin_contact_phone" value="{{ old('kin_contact_phone', $user->kin_contact_phone) }}">
                                            @error('kin_contact_phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-3 form-group">
                                            <label for="kin_contact_relationship" class="form-label">Relationship with Next of Kin</label>
                                            <input type="text" class="form-control @error('kin_contact_relationship') is-invalid @enderror" id="kin_contact_relationship" name="kin_contact_relationship" value="{{ old('kin_contact_relationship', $user->kin_contact_relationship) }}">
                                            @error('kin_contact_relationship')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3 form-group">
                                            <label for="kin_contact_address" class="form-label">Next of Kin Address</label>
                                            <input type="text" class="form-control @error('kin_contact_address') is-invalid @enderror" id="kin_contact_address" name="kin_contact_address" value="{{ old('kin_contact_address', $user->kin_contact_address) }}">
                                            @error('kin_contact_address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 d-grid">
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Image Cropper Modal -->
        <div class="modal fade" id="cropperModal" tabindex="-1" aria-labelledby="cropperModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cropperModalLabel">Crop and Upload Photo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="img-container">
                                    <img id="image-to-crop" src="{{ asset('images/default-profile.jpg') }}" class="img-fluid">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="preview-container">
                                    <h6>Preview:</h6>
                                    <div class="preview" style="width: 150px; height: 150px; overflow: hidden; border-radius: 50%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="crop-and-upload">Upload Photo</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Password Change Modal -->
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('student.profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            <div class="form-text">Password must be at least 8 characters long.</div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @push('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <style>
        .upload-btn-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }
        .upload-btn-wrapper input[type=file] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        .img-container {
            max-height: 400px;
            margin-bottom: 20px;
        }
        .img-container img {
            max-width: 100%;
        }
        .preview {
            margin-top: 10px;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let cropper;
            let uploadedImageURL;
            const uploadButton = document.getElementById('upload-photo');
            const profileImage = document.getElementById('profile-image');
            const cropperModal = new bootstrap.Modal(document.getElementById('cropperModal'));
            const imageToCrop = document.getElementById('image-to-crop');
            const cropAndUploadBtn = document.getElementById('crop-and-upload');

            // Handle file selection
            if (uploadButton) {
                uploadButton.addEventListener('change', function(e) {
                    const file = e.target.files[0];

                    if (!file) return;

                    // Check if file is an image
                    if (!/^image\/\w+/.test(file.type)) {
                        alert('Please upload an image file!');
                        return;
                    }

                    // Clear previous file
                    if (uploadedImageURL) {
                        URL.revokeObjectURL(uploadedImageURL);
                    }

                    // Create URL for the file
                    uploadedImageURL = URL.createObjectURL(file);

                    // Set the image source
                    imageToCrop.src = uploadedImageURL;

                    // Reset the file input
                    uploadButton.value = '';

                    // Initialize cropper after image loads
                    imageToCrop.onload = function() {
                        // Destroy previous cropper if exists
                        if (cropper) {
                            cropper.destroy();
                        }

                        // Initialize new cropper
                        cropper = new Cropper(imageToCrop, {
                            aspectRatio: 1,
                            viewMode: 1,
                            preview: '.preview',
                            minContainerWidth: 300,
                            minContainerHeight: 300
                        });

                        // Show modal
                        cropperModal.show();
                    };
                });
            }

            // Handle crop and upload
            if (cropAndUploadBtn) {
                cropAndUploadBtn.addEventListener('click', function() {
                    if (!cropper) return;

                    // Get cropped canvas
                    const canvas = cropper.getCroppedCanvas({
                        width: 300,
                        height: 300
                    });

                    if (!canvas) return;

                    // Convert canvas to blob
                    canvas.toBlob(function(blob) {
                        const formData = new FormData();
                        formData.append('photo', blob, 'profile.jpg');
                        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                        // Show loading state
                        cropAndUploadBtn.disabled = true;
                        cropAndUploadBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Uploading...';

                        // Upload cropped image
                        fetch('{{ route("student.profile.photo") }}', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update profile image
                                profileImage.src = data.photo + '?v=' + new Date().getTime(); // Add timestamp to prevent caching

                                // Close modal
                                cropperModal.hide();

                                // Show success message
                                const successAlert = document.createElement('div');
                                successAlert.className = 'alert alert-success alert-dismissible fade show mt-3';
                                successAlert.role = 'alert';
                                successAlert.innerHTML = `
                                    Profile photo updated successfully
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                `;
                                document.querySelector('.profile-img-container').after(successAlert);

                                // Auto-dismiss after 3 seconds
                                setTimeout(() => {
                                    const closeButton = successAlert.querySelector('.btn-close');
                                    if (closeButton) closeButton.click();
                                }, 3000);
                            } else {
                                // Show error message
                                const errorAlert = document.createElement('div');
                                errorAlert.className = 'alert alert-danger alert-dismissible fade show mt-3';
                                errorAlert.role = 'alert';
                                errorAlert.innerHTML = `
                                    ${data.message || 'Error updating profile photo'}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                `;
                                document.querySelector('.profile-img-container').after(errorAlert);

                                // Close modal
                                cropperModal.hide();
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Reset button state
                            cropAndUploadBtn.disabled = false;
                            cropAndUploadBtn.innerHTML = 'Upload Photo';
                        })
                        .finally(() => {
                            // Reset button state
                            cropAndUploadBtn.disabled = false;
                            cropAndUploadBtn.innerHTML = 'Upload Photo';
                        });
                    }, 'image/jpeg', 0.9);
                });
            }

            // Location lookup for last login
            const locationElement = document.getElementById('last-login-location');
            const ipElement = document.querySelector('.fas.fa-laptop').nextElementSibling;

            if (locationElement && ipElement) {
                const ipAddress = ipElement.textContent.trim();

                if (ipAddress && ipAddress !== 'N/A') {
                    fetch(`https://ipapi.co/${ipAddress.replace('N/A', '')}/json/`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.city && data.country_name) {
                                locationElement.textContent = `${data.city}, ${data.country_name}`;
                            } else {
                                locationElement.textContent = 'Location unavailable';
                            }
                        })
                        .catch(error => {
                            locationElement.textContent = 'Location unavailable';
                            console.error('Error:', error);
                        });
                } else {
                    locationElement.textContent = 'Location unavailable';
                }
            }
        });
    </script>
    @endpush
</x-student-layout>
    @endpush
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
        <script>
            // document.addEventListener('DOMContentLoaded', function() {
            //     var image = document.getElementById('image');
            //     var inputImage = document.getElementById('inputImage');
            //     var cropBtn = document.getElementById('crop-btn');
            //     var croppedData = document.getElementById('cropped_data');
            //     var cropper;

            //     // Initialize cropper when image is loaded
            //     function initCropper() {
            //         if (cropper) {
            //             cropper.destroy();
            //         }

            //         cropper = new Cropper(image, {
            //             aspectRatio: 1,
            //             viewMode: 1,
            //             preview: '.preview',
            //             crop: function(event) {
            //                 cropBtn.disabled = false;
            //                 croppedData.value = JSON.stringify({
            //                     x: Math.round(event.detail.x),
            //                     y: Math.round(event.detail.y),
            //                     width: Math.round(event.detail.width),
            //                     height: Math.round(event.detail.height)
            //                 });
            //             }
            //         });
            //     }

            //     // Initialize the cropper when the modal is shown
            //     $('#photoModal').on('shown.bs.modal', function() {
            //         initCropper();
            //     });

            //     // Destroy the cropper when the modal is hidden
            //     $('#photoModal').on('hidden.bs.modal', function() {
            //         if (cropper) {
            //             cropper.destroy();
            //             cropper = null;
            //         }
            //     });

            //     // Handle image upload
            //     inputImage.addEventListener('change', function(e) {
            //         var files = e.target.files;
            //         var done = function(url) {
            //             inputImage.value = '';
            //             image.src = url;
            //             if (cropper) {
            //                 cropper.destroy();
            //             }
            //             initCropper();
            //         };

            //         if (files && files.length > 0) {
            //             var file = files[0];
            //             if (URL) {
            //                 done(URL.createObjectURL(file));
            //             } else if (FileReader) {
            //                 var reader = new FileReader();
            //                 reader.onload = function(e) {
            //                     done(reader.result);
            //                 };
            //                 reader.readAsDataURL(file);
            //             }
            //         }
            //     });
            // });

            document.addEventListener('DOMContentLoaded', function() {
                var image = document.getElementById('image');
                var inputImage = document.getElementById('inputImage');
                var cropBtn = document.getElementById('crop-btn');
                var croppedData = document.getElementById('cropped_data');
                var cropForm = document.getElementById('cropForm');
                var cropper;

                // Initialize cropper when image is loaded
                function initCropper() {
                    if (cropper) {
                        cropper.destroy();
                    }

                    cropper = new Cropper(image, {
                        aspectRatio: 1,
                        viewMode: 1,
                        preview: '.preview',
                        crop: function(event) {
                            cropBtn.disabled = false;
                            croppedData.value = JSON.stringify({
                                x: Math.round(event.detail.x),
                                y: Math.round(event.detail.y),
                                width: Math.round(event.detail.width),
                                height: Math.round(event.detail.height)
                            });
                        }
                    });
                }

                // Initialize the cropper when the modal is shown
                $('#photoModal').on('shown.bs.modal', function() {
                    initCropper();
                });

                // Destroy the cropper when the modal is hidden
                $('#photoModal').on('hidden.bs.modal', function() {
                    if (cropper) {
                        cropper.destroy();
                        cropper = null;
                    }
                });

                // Handle image upload
                inputImage.addEventListener('change', function(e) {
                    var files = e.target.files;
                    var done = function(url) {
                        inputImage.value = '';
                        image.src = url;
                        if (cropper) {
                            cropper.destroy();
                        }
                        initCropper();
                    };

                    if (files && files.length > 0) {
                        var file = files[0];
                        if (URL) {
                            done(URL.createObjectURL(file));
                        } else if (FileReader) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                done(reader.result);
                            };
                            reader.readAsDataURL(file);
                        }
                    }
                });

                // Handle form submission
                cropForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Create a hidden input for the image data
                    var imageInput = document.createElement('input');
                    imageInput.type = 'hidden';
                    imageInput.name = 'image_data';

                    // Get the canvas data from cropper
                    if (cropper) {
                        // Get the cropped canvas and convert to data URL
                        var canvas = cropper.getCroppedCanvas({
                            width: 300,
                            height: 300
                        });

                        if (canvas) {
                            imageInput.value = canvas.toDataURL('image/jpeg');
                            cropForm.appendChild(imageInput);
                            cropForm.submit();
                        }
                    }
                });
            });
        </script>

        <script>
            // Add this to your existing scripts section
            document.addEventListener('DOMContentLoaded', function() {
                // Get the tab parameter from URL
                const urlParams = new URLSearchParams(window.location.search);
                const tabParam = urlParams.get('tab');

                // If a tab parameter exists, activate that tab
                if (tabParam) {
                    const tabEl = document.querySelector(`#${tabParam}-tab`);
                    if (tabEl) {
                        const tab = new bootstrap.Tab(tabEl);
                        tab.show();
                    }
                }

                // Or check if there are any validation errors and show appropriate tab
                const hasEditErrors = document.querySelectorAll('#edit .is-invalid').length > 0;
                const hasPasswordErrors = document.querySelectorAll('#password .is-invalid').length > 0;

                if (hasEditErrors) {
                    const editTabEl = document.querySelector('#edit-tab');
                    const editTab = new bootstrap.Tab(editTabEl);
                    editTab.show();
                } else if (hasPasswordErrors) {
                    const passwordTabEl = document.querySelector('#password-tab');
                    const passwordTab = new bootstrap.Tab(passwordTabEl);
                    passwordTab.show();
                }
            });
        </script>
    @endpush
</x-admin-layout>
