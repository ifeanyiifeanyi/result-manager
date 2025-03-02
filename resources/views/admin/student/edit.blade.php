<x-admin-layout>
    <x-slot name="title">
        {{ __('Edit Student') }}
    </x-slot>

    <div class="py-4 container-fluid">
        <!-- Page Heading -->
        <div class="mb-4 d-sm-flex align-items-center justify-content-between">
            <h1 class="mb-0 text-gray-800 h3">Edit Student: {{ $student->full_name }}</h1>
            <div>
                <a href="{{ route('admin.students.show', $student) }}" class="btn btn-primary">
                    <i class="fas fa-eye me-1"></i> View Profile
                </a>
                <a href="{{ route('admin.students') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-arrow-left me-1"></i> Back to Students
                </a>
            </div>
        </div>

        <!-- Alert Messages -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Student Form -->
        <div class="mb-4 shadow card">
            <div class="py-3 card-header bg-primary bg-gradient">
                <h6 class="m-0 text-white font-weight-bold">Student Information</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.students.update', $student) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <!-- Personal Information -->
                        <div class="col-md-6">
                            <div class="mb-4 border-4 card h-100 border-start border-primary">
                                <div class="card-header bg-light">
                                    <h6 class="m-0 fw-bold text-primary">Personal Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3 form-group">
                                        <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $student->first_name) }}" required>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $student->last_name) }}" required>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label for="other_names" class="form-label">Other Names</label>
                                        <input type="text" class="form-control" id="other_names" name="other_names" value="{{ old('other_names', $student->other_names) }}">
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                        <select class="form-select" id="gender" name="gender" required>
                                            <option value="">Select Gender</option>
                                            <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ old('gender', $student->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label for="date_of_birth" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth ? $student->date_of_birth->format('Y-m-d') : '') }}" required>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label for="id_number" class="form-label">ID Number</label>
                                        <input type="text" class="form-control" id="id_number" name="id_number" value="{{ old('id_number', $student->id_number) }}">
                                    </div>
                                    <div class="mb-3 form-group">
                                        <div class="form-check form-switch">
                                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $student->is_active) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">Active Account</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="col-md-6">
                            <div class="mb-4 border-4 card h-100 border-start border-success">
                                <div class="card-header bg-light">
                                    <h6 class="m-0 fw-bold text-success">Contact Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3 form-group">
                                        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $student->email) }}" required>
                                        </div>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $student->phone) }}">
                                        </div>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $student->address) }}">
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label for="address_line_2" class="form-label">Address Line 2</label>
                                        <input type="text" class="form-control" id="address_line_2" name="address_line_2" value="{{ old('address_line_2', $student->address_line_2) }}">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3 form-group">
                                                <label for="city" class="form-label">City</label>
                                                <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $student->city) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3 form-group">
                                                <label for="state" class="form-label">State/Province</label>
                                                <input type="text" class="form-control" id="state" name="state" value="{{ old('state', $student->state) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3 form-group">
                                                <label for="postal_code" class="form-label">Postal Code</label>
                                                <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ old('postal_code', $student->postal_code) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3 form-group">
                                                <label for="country" class="form-label">Country</label>
                                                <input type="text" class="form-control" id="country" name="country" value="{{ old('country', $student->country) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Next of Kin Information -->
                    <div class="mt-4 mb-4 border-4 card border-start border-info">
                        <div class="card-header bg-light">
                            <h6 class="m-0 fw-bold text-info">Next of Kin Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3 form-group">
                                        <label for="kin_contact_name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="kin_contact_name" name="kin_contact_name" value="{{ old('kin_contact_name', $student->kin_contact_name) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 form-group">
                                        <label for="kin_contact_phone" class="form-label">Phone Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            <input type="text" class="form-control" id="kin_contact_phone" name="kin_contact_phone" value="{{ old('kin_contact_phone', $student->kin_contact_phone) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3 form-group">
                                        <label for="kin_contact_relationship" class="form-label">Relationship</label>
                                        <select class="form-select" id="kin_contact_relationship" name="kin_contact_relationship">
                                            <option value="">Select Relationship</option>
                                            <option value="Parent" {{ old('kin_contact_relationship', $student->kin_contact_relationship) == 'Parent' ? 'selected' : '' }}>Parent</option>
                                            <option value="Spouse" {{ old('kin_contact_relationship', $student->kin_contact_relationship) == 'Spouse' ? 'selected' : '' }}>Spouse</option>
                                            <option value="Sibling" {{ old('kin_contact_relationship', $student->kin_contact_relationship) == 'Sibling' ? 'selected' : '' }}>Sibling</option>
                                            <option value="Child" {{ old('kin_contact_relationship', $student->kin_contact_relationship) == 'Child' ? 'selected' : '' }}>Child</option>
                                            <option value="Guardian" {{ old('kin_contact_relationship', $student->kin_contact_relationship) == 'Guardian' ? 'selected' : '' }}>Guardian</option>
                                            <option value="Friend" {{ old('kin_contact_relationship', $student->kin_contact_relationship) == 'Friend' ? 'selected' : '' }}>Friend</option>
                                            <option value="Other" {{ old('kin_contact_relationship', $student->kin_contact_relationship) == 'Other' || (!in_array(old('kin_contact_relationship', $student->kin_contact_relationship), ['Parent', 'Spouse', 'Sibling', 'Child', 'Guardian', 'Friend', '']) && old('kin_contact_relationship', $student->kin_contact_relationship) != '') ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 form-group">
                                        <label for="kin_contact_address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="kin_contact_address" name="kin_contact_address" value="{{ old('kin_contact_address', $student->kin_contact_address) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-center form-group">
                        <button type="submit" class="px-5 btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i> Update Student
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>