<x-student-layout>
    <x-slot name="title">
        {{ __('Profile') }}
    </x-slot>

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
                        <div class="mb-5 profile-img-container">
                            <img src="{{ asset($user->photo ?? 'images/default-profile.jpg') }}"
                                alt="{{ $user->full_name }}" id="profile-image" class="rounded-circle img-thumbnail"
                                style="width: 150px; height: 150px; object-fit: cover;">
                        </div>

                        <h5 class="card-title">{{ $user->full_name }}</h5>
                        <p class="text-muted">{{ $user->username }}</p>

                        <div class="mt-3 upload-btn-wrapper">
                            <label for="upload-photo" class="btn btn-primary">
                                    <i class="fas fa-camera me-2"></i> Change Photo

                            </label>
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
                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                                data-bs-target="#passwordModal">
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
                        <div class="mb-5">
                            <h6>Last Login</h6>
                            <p class="mb-1">
                                <i class="fas fa-calendar me-2"></i>
                                {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'N/A' }}
                                <small
                                    class="text-muted">({{ $user->last_login_at ? $user->last_login_at->format('M d, Y h:i A') : 'N/A' }})</small>
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
                            <!-- Add this to your sessions list in the blade file -->
                            @forelse($sessions as $session)
                                <div class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $session['location'] }}</h6>
                                        <small>{{ $session['is_current'] ? 'Current' : '' }}</small>
                                    </div>
                                    <p class="mb-1">{{ $session['ip_address'] }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small>{{ \Carbon\Carbon::parse($session['last_activity'])->diffForHumans() }}</small>
                                        @if (!$session['is_current'])
                                            <form action="{{ route('student.profile.logout_session') }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="session_id"
                                                    value="{{ $session['session_id'] }}">
                                                <button type="submit" class="btn btn-sm btn-danger">Log out</button>
                                            </form>
                                        @else
                                            <span class="badge bg-primary">Current Session</span>
                                        @endif
                                    </div>
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
                                        <div class="mb-5 form-group">
                                            <label for="first_name" class="form-label">First Name *</label>
                                            <input type="text"
                                                class="form-control @error('first_name') is-invalid @enderror"
                                                id="first_name" name="first_name"
                                                value="{{ old('first_name', $user->first_name) }}">
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-5 form-group">
                                            <label for="last_name" class="form-label">Last Name *</label>
                                            <input type="text"
                                                class="form-control @error('last_name') is-invalid @enderror"
                                                id="last_name" name="last_name"
                                                value="{{ old('last_name', $user->last_name) }}">
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-5 form-group">
                                            <label for="other_names" class="form-label">Other Names</label>
                                            <input type="text"
                                                class="form-control @error('other_names') is-invalid @enderror"
                                                id="other_names" name="other_names"
                                                value="{{ old('other_names', $user->other_names) }}">
                                            @error('other_names')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="mb-5 row g-3">
                                    <br>
                                    <div class="col-md-4">
                                        <div class="mb-5 form-group">
                                            <label for="email" class="form-label">Email Address *</label>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                id="email" name="email"
                                                value="{{ old('email', $user->email) }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-5 form-group">
                                            <label for="phone" class="form-label">Phone Number *</label>
                                            <input type="text"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                id="phone" name="phone"
                                                value="{{ old('phone', $user->phone) }}">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-5 form-group">
                                            <label for="id_number" class="form-label">ID Number</label>
                                            <input type="text"
                                                class="form-control @error('id_number') is-invalid @enderror"
                                                id="id_number" name="id_number"
                                                value="{{ old('id_number', $user->id_number) }}">
                                            @error('id_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="mb-5 row g-3">

                                    <div class="col-md-6">
                                        <div class="mb-5 form-group">
                                            <label for="date_of_birth" class="form-label">Date of Birth *</label>
                                            <input type="date"
                                                class="form-control @error('date_of_birth') is-invalid @enderror"
                                                id="date_of_birth" name="date_of_birth"
                                                value="{{ old('date_of_birth', $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '') }}">
                                            @error('date_of_birth')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-5 form-group">
                                            <label for="gender" class="form-label">Gender *</label>
                                            <select class="form-select @error('gender') is-invalid @enderror"
                                                id="gender" name="gender">
                                                <option value="">Select Gender</option>
                                                <option value="male"
                                                    {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male
                                                </option>
                                                <option value="female"
                                                    {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>
                                                    Female</option>
                                                <option value="other"
                                                    {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>
                                                    Other</option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Address Information Section -->
                            <h5 class="pb-2 mt-4 mb-5 border-bottom">Address Information</h5>
                            <div class="mb-4">
                                <br>
                                <div class="mb-5 row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-5 form-group">
                                            <label for="address" class="form-label">Address *</label>
                                            <input type="text"
                                                class="form-control @error('address') is-invalid @enderror"
                                                id="address" name="address"
                                                value="{{ old('address', $user->address) }}">
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-5 form-group">
                                            <label for="address_line_2" class="form-label">Address Line 2</label>
                                            <input type="text"
                                                class="form-control @error('address_line_2') is-invalid @enderror"
                                                id="address_line_2" name="address_line_2"
                                                value="{{ old('address_line_2', $user->address_line_2) }}">
                                            @error('address_line_2')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="mb-5 row g-3">
                                    <div class="col-md-3">
                                        <div class="mb-5 form-group">
                                            <label for="city" class="form-label">City *</label>
                                            <input type="text"
                                                class="form-control @error('city') is-invalid @enderror"
                                                id="city" name="city"
                                                value="{{ old('city', $user->city) }}">
                                            @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-5 form-group">
                                            <label for="state" class="form-label">State/Province *</label>
                                            <input type="text"
                                                class="form-control @error('state') is-invalid @enderror"
                                                id="state" name="state"
                                                value="{{ old('state', $user->state) }}">
                                            @error('state')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-5 form-group">
                                            <label for="postal_code" class="form-label">Postal Code</label>
                                            <input type="text"
                                                class="form-control @error('postal_code') is-invalid @enderror"
                                                id="postal_code" name="postal_code"
                                                value="{{ old('postal_code', $user->postal_code) }}">
                                            @error('postal_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-5 form-group">
                                            <label for="country" class="form-label">Country *</label>
                                            <input type="text"
                                                class="form-control @error('country') is-invalid @enderror"
                                                id="country" name="country"
                                                value="{{ old('country', $user->country) }}">
                                            @error('country')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Next of Kin Information Section -->
                            <h5 class="pb-2 mt-4 mb-5 border-bottom">Next of Kin Information</h5>
                            <div class="mb-4">
                                <br>
                                <div class="mb-5 row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-5 form-group">
                                            <label for="kin_contact_name" class="form-label">Next of Kin Name
                                                *</label>
                                            <input type="text"
                                                class="form-control @error('kin_contact_name') is-invalid @enderror"
                                                id="kin_contact_name" name="kin_contact_name"
                                                value="{{ old('kin_contact_name', $user->kin_contact_name) }}">
                                            @error('kin_contact_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-5 form-group">
                                            <label for="kin_contact_phone" class="form-label">Next of Kin Phone
                                                *</label>
                                            <input type="text"
                                                class="form-control @error('kin_contact_phone') is-invalid @enderror"
                                                id="kin_contact_phone" name="kin_contact_phone"
                                                value="{{ old('kin_contact_phone', $user->kin_contact_phone) }}">
                                            @error('kin_contact_phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
<br>
                                <div class="mb-5 row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-5 form-group">
                                            <label for="kin_contact_relationship" class="form-label">Relationship with
                                                Next of Kin</label>
                                            <input type="text"
                                                class="form-control @error('kin_contact_relationship') is-invalid @enderror"
                                                id="kin_contact_relationship" name="kin_contact_relationship"
                                                value="{{ old('kin_contact_relationship', $user->kin_contact_relationship) }}">
                                            @error('kin_contact_relationship')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4 col-md-6">
                                        <div class="mb-5 form-group">
                                            <label for="kin_contact_address" class="form-label">Next of Kin
                                                Address</label>
                                            <input type="text"
                                                class="form-control @error('kin_contact_address') is-invalid @enderror"
                                                id="kin_contact_address" name="kin_contact_address"
                                                value="{{ old('kin_contact_address', $user->kin_contact_address) }}">
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
        <div class="modal fade" id="cropperModal" tabindex="-1" aria-labelledby="cropperModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cropperModalLabel">Crop and Upload Photo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="img-container">
                                    <img id="image-to-crop" src="{{ asset('images/default-profile.jpg') }}"
                                        class="img-fluid">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="preview-container">
                                    <h6>Preview:</h6>
                                    <div class="preview"
                                        style="width: 150px; height: 150px; overflow: hidden; border-radius: 50%;">
                                    </div>
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
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel"
        aria-hidden="true">
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
                        <div class="mb-5">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password"
                                class="form-control @error('current_password') is-invalid @enderror"
                                id="current_password" name="current_password">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-5">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password">
                            <div class="form-text">Password must be at least 8 characters long.</div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-5">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation">
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


    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
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
    @endpush

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>



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
                            formData.append('_token', document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'));

                            // Show loading state
                            cropAndUploadBtn.disabled = true;
                            cropAndUploadBtn.innerHTML =
                                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Uploading...';

                            // Upload cropped image
                            fetch('{{ route('student.profile.photo') }}', {
                                    method: 'POST',
                                    body: formData
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        // Update profile image
                                        profileImage.src = data.photo + '?v=' + new Date()
                                            .getTime(); // Add timestamp to prevent caching

                                        // Close modal
                                        cropperModal.hide();

                                        // Show success message
                                        const successAlert = document.createElement('div');
                                        successAlert.className =
                                            'alert alert-success alert-dismissible fade show mt-3';
                                        successAlert.role = 'alert';
                                        successAlert.innerHTML = `
                                    Profile photo updated successfully
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                `;
                                        document.querySelector('.profile-img-container').after(
                                            successAlert);

                                        // Auto-dismiss after 3 seconds
                                        setTimeout(() => {
                                            const closeButton = successAlert.querySelector(
                                                '.btn-close');
                                            if (closeButton) closeButton.click();
                                        }, 3000);
                                    } else {
                                        // Show error message
                                        const errorAlert = document.createElement('div');
                                        errorAlert.className =
                                            'alert alert-danger alert-dismissible fade show mt-3';
                                        errorAlert.role = 'alert';
                                        errorAlert.innerHTML = `
                                    ${data.message || 'Error updating profile photo'}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                `;
                                        document.querySelector('.profile-img-container').after(
                                            errorAlert);

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

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Check for password modal errors
                @if ($errors->has('current_password') || $errors->has('password') || $errors->has('password_confirmation'))
                    const passwordModal = new bootstrap.Modal(document.getElementById('passwordModal'));
                    passwordModal.show();
                @endif

                // For photo upload errors, they're handled by the Ajax response already
            });
        </script>


        <script>
            // Location lookup for last login
            const locationElement = document.getElementById('last-login-location');
            const ipElement = document.querySelector('.fas.fa-laptop').nextElementSibling;

            if (locationElement && ipElement) {
                const ipAddress = ipElement.textContent.trim();

                if (ipAddress && ipAddress !== 'N/A') {
                    locationElement.textContent = 'Finding location...';
                    fetch(`https://ipapi.co/${ipAddress.replace('N/A', '')}/json/`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.city && data.country_name) {
                                locationElement.textContent = `${data.city}, ${data.country_name}`;
                            } else if (data.error) {
                                locationElement.textContent = 'Location unavailable';
                                console.error('Error:', data.reason);
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
        </script>
    @endpush
</x-student-layout>
