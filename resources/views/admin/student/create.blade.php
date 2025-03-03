<x-admin-layout>
    <x-slot name="title">
        {{ __('Create Student') }}
    </x-slot>

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="mb-4 d-sm-flex align-items-center justify-content-between">
            <h1 class="mb-0 text-gray-800 h3">Create New Student</h1>
            <a href="{{ route('admin.students') }}" class="btn btn-secondary">
                <i class="mr-1 fas fa-arrow-left"></i> Back to Students
            </a>
        </div>

        <!-- Alert Messages -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Student Form -->
        <div class="mb-4 shadow card">
            <div class="py-3 card-header">
                <h6 class="m-0 font-weight-bold text-primary">Student Information</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.students.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- Personal Information -->
                        <div class="col-md-6">
                            <div class="mb-4 card">
                                <div class="card-header">
                                    <h6 class="m-0 font-weight-bold text-primary">Personal Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="first_name">First Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="other_names">Other Names</label>
                                        <input type="text" class="form-control" id="other_names" name="other_names" value="{{ old('other_names') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="gender">Gender <span class="text-danger">*</span></label>
                                        <select class="form-control" id="gender" name="gender" required>
                                            <option value="">Select Gender</option>
                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="date_of_birth">Date of Birth <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="id_number">ID Number</label>
                                        <input type="text" class="form-control" id="id_number" name="id_number" value="{{ old('id_number') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="col-md-6">
                            <div class="mb-4 card">
                                <div class="card-header">
                                    <h6 class="m-0 font-weight-bold text-primary">Contact Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="email">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone Number</label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="address_line_2">Address Line 2</label>
                                        <input type="text" class="form-control" id="address_line_2" name="address_line_2" value="{{ old('address_line_2') }}">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="city">City</label>
                                                <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="state">State/Province</label>
                                                <input type="text" class="form-control" id="state" name="state" value="{{ old('state') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="postal_code">Postal Code</label>
                                                <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ old('postal_code') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="country">Country</label>
                                                <input type="text" class="form-control" id="country" name="country" value="{{ old('country') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 alert alert-info">
                        <i class="mr-1 fas fa-info-circle"></i> A random password will be generated and sent to the student's email address.
                    </div>

                    <div class="text-center form-group">
                        <button type="submit" class="px-5 btn btn-primary btn-lg">
                            <i class="mr-2 fas fa-save"></i> Create Student
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>