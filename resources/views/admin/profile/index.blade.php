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

    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
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
