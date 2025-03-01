<x-admin-layout>
    <x-slot name="title">
        {{ __('Academic Sessions') }}
    </x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Academic Sessions</h4>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#createSessionModal">
                            <i class="fas fa-plus"></i> Add New Session
                        </button>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="datatable-responsive">
                                <thead>
                                    <tr>
                                        <th>sn</th>
                                        <th>Name</th>
                                        <th>Year</th>
                                        <th>Status</th>
                                        <th>Description</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sessions as $session)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $session->name }}</td>
                                            <td>{{ $session->year->format('Y') }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $session->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $session->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>{{ Str::limit($session->description, 50) }}</td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-info view-session"
                                                        data-bs-toggle="modal" data-bs-target="#viewSessionModal"
                                                        data-id="{{ $session->id }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-warning edit-session"
                                                        data-bs-toggle="modal" data-bs-target="#editSessionModal"
                                                        data-id="{{ $session->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    <form
                                                        action="{{ route('admin.academic-sessions.toggle-active', $session) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="btn btn-sm {{ $session->is_active ? 'btn-secondary' : 'btn-success' }}"
                                                            {{ $session->is_active ? 'title=Deactivate' : 'title=Activate' }}>
                                                            <i
                                                                class="fas {{ $session->is_active ? 'fa-power-off' : 'fa-check' }}"></i>
                                                        </button>
                                                    </form>

                                                    <button type="button" class="btn btn-sm btn-danger delete-session"
                                                        data-bs-toggle="modal" data-bs-target="#deleteSessionModal"
                                                        data-id="{{ $session->id }}"
                                                        data-name="{{ $session->name }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No academic sessions found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Session Modal -->
   @include('admin.academicSession.create')

    <!-- Edit Session Modal -->
   @include('admin.academicSession.edit')

    <!-- View Session Modal -->
   @include('admin.academicSession.show')

    <!-- Delete Confirmation Modal -->
   @include('admin.academicSession.delete')

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Reset form and clear errors when modal is closed
                $('#createSessionModal').on('hidden.bs.modal', function() {
                    document.getElementById('createSessionForm').reset();
                    clearValidationErrors('createSessionForm');
                    document.getElementById('createErrorAlert').classList.add('d-none');
                    document.getElementById('createErrorList').innerHTML = '';
                });

                $('#editSessionModal').on('hidden.bs.modal', function() {
                    clearValidationErrors('editSessionForm');
                    document.getElementById('editErrorAlert').classList.add('d-none');
                    document.getElementById('editErrorList').innerHTML = '';
                });

                // Helper function to clear validation errors
                function clearValidationErrors(formId) {
                    const form = document.getElementById(formId);
                    const inputs = form.querySelectorAll('input, textarea, select');

                    inputs.forEach(input => {
                        input.classList.remove('is-invalid');
                        const feedbackElement = document.getElementById(input.id + '-error');
                        if (feedbackElement) {
                            feedbackElement.textContent = '';
                        }
                    });
                }

                // Helper function to show validation errors
                function showValidationErrors(formPrefix, errors) {
                    for (const field in errors) {
                        const input = document.getElementById(formPrefix === 'edit_' ? 'edit_' + field : field);
                        if (input) {
                            input.classList.add('is-invalid');
                            const feedbackElement = document.getElementById(formPrefix === 'edit_' ? 'edit-' +
                                field +
                                '-error' : field + '-error');
                            if (feedbackElement) {
                                feedbackElement.textContent = errors[field][0];
                            }
                        }

                        // Add to error list as well
                        const errorListId = formPrefix === 'edit_' ? 'editErrorList' : 'createErrorList';
                        const errorList = document.getElementById(errorListId);
                        const errorItem = document.createElement('li');
                        errorItem.textContent = errors[field][0];
                        errorList.appendChild(errorItem);
                    }

                    // Show the alert
                    const alertId = formPrefix === 'edit_' ? 'editErrorAlert' : 'createErrorAlert';
                    document.getElementById(alertId).classList.remove('d-none');
                }

                // Create Session Form Submit
                document.getElementById('createSessionForm').addEventListener('submit', function(e) {
                    e.preventDefault();

                    const form = this;
                    const formData = new FormData(form);
                    const submitBtn = document.getElementById('createSessionBtn');

                    // Clear previous errors
                    clearValidationErrors('createSessionForm');
                    document.getElementById('createErrorAlert').classList.add('d-none');
                    document.getElementById('createErrorList').innerHTML = '';

                    // Disable submit button to prevent double submission
                    submitBtn.disabled = true;
                    submitBtn.innerHTML =
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Creating...'
                    ;

                    // Send AJAX request
                    fetch(form.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        })
                        .then(response => response.json().then(data => ({
                            status: response.status,
                            body: data
                        })))
                        .then(({
                            status,
                            body
                        }) => {
                            // Re-enable submit button
                            submitBtn.disabled = false;
                            submitBtn.textContent = 'Create Session';

                            if (status === 422) {
                                // Validation error
                                showValidationErrors('', body.errors);
                            } else if (status === 200 || status === 201) {
                                // Success
                                $('#createSessionModal').modal('hide');

                                // Refresh the page to show the new record
                                window.location.reload();
                            } else {
                                // Other error
                                document.getElementById('createErrorAlert').classList.remove('d-none');
                                const errorList = document.getElementById('createErrorList');
                                errorList.innerHTML = '<li>An error occurred. Please try again.</li>';
                            }
                        })
                        .catch(error => {
                            // Re-enable submit button
                            submitBtn.disabled = false;
                            submitBtn.textContent = 'Create Session';

                            // Show error
                            document.getElementById('createErrorAlert').classList.remove('d-none');
                            const errorList = document.getElementById('createErrorList');
                            errorList.innerHTML = '<li>An error occurred. Please try again.</li>';
                            console.error('Error:', error);
                        });
                });

                // Edit Session Form Submit
                document.getElementById('editSessionForm').addEventListener('submit', function(e) {
                    e.preventDefault();

                    const form = this;
                    const formData = new FormData(form);
                    const submitBtn = document.getElementById('updateSessionBtn');

                    // Clear previous errors
                    clearValidationErrors('editSessionForm');
                    document.getElementById('editErrorAlert').classList.add('d-none');
                    document.getElementById('editErrorList').innerHTML = '';

                    // Disable submit button to prevent double submission
                    submitBtn.disabled = true;
                    submitBtn.innerHTML =
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...'
                    ;

                    // Need to append the _method field for PUT requests
                    formData.append('_method', 'PUT');

                    // Send AJAX request
                    fetch(form.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        })
                        .then(response => response.json().then(data => ({
                            status: response.status,
                            body: data
                        })))
                        .then(({
                            status,
                            body
                        }) => {
                            // Re-enable submit button
                            submitBtn.disabled = false;
                            submitBtn.textContent = 'Update Session';

                            if (status === 422) {
                                // Validation error
                                showValidationErrors('edit_', body.errors);
                            } else if (status === 200 || status === 201) {
                                // Success
                                $('#editSessionModal').modal('hide');

                                // Refresh the page to show the updated record
                                window.location.reload();
                            } else {
                                // Other error
                                document.getElementById('editErrorAlert').classList.remove('d-none');
                                const errorList = document.getElementById('editErrorList');
                                errorList.innerHTML = '<li>An error occurred. Please try again.</li>';
                            }
                        })
                        .catch(error => {
                            // Re-enable submit button
                            submitBtn.disabled = false;
                            submitBtn.textContent = 'Update Session';

                            // Show error
                            document.getElementById('editErrorAlert').classList.remove('d-none');
                            const errorList = document.getElementById('editErrorList');
                            errorList.innerHTML = '<li>An error occurred. Please try again.</li>';
                            console.error('Error:', error);
                        });
                });

                // View Session Modal
                document.querySelectorAll('.view-session').forEach(button => {
                    button.addEventListener('click', function() {
                        const sessionId = this.getAttribute('data-id');

                        fetch(`{{ url('admin/academic-sessions') }}/${sessionId}`)
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('view_name').textContent = data.name;
                                document.getElementById('view_year').textContent = new Date(data
                                    .year).getFullYear();
                                document.getElementById('view_status').textContent = data
                                    .is_active ? 'Active' : 'Inactive';
                                document.getElementById('view_description').textContent = data
                                    .description || 'No description provided';
                                document.getElementById('view_created_at').textContent =
                                    new Date(
                                        data.created_at).toLocaleDateString();
                                document.getElementById('view_updated_at').textContent =
                                    new Date(
                                        data.updated_at).toLocaleDateString();
                            })
                            .catch(error => {
                                console.error('Error fetching session details:', error);
                            });
                    });
                });

                // Edit Session Modal
                document.querySelectorAll('.edit-session').forEach(button => {
                    button.addEventListener('click', function() {
                        const sessionId = this.getAttribute('data-id');
                        const form = document.getElementById('editSessionForm');

                        form.action = `{{ url('admin/academic-sessions') }}/${sessionId}`;

                        fetch(`{{ url('admin/academic-sessions') }}/${sessionId}`)
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('edit_name').value = data.name;
                                document.getElementById('edit_year').value = new Date(data.year)
                                    .getFullYear();
                                document.getElementById('edit_description').value = data
                                    .description || '';
                                document.getElementById('edit_is_active').checked = data
                                    .is_active;
                            })
                            .catch(error => {
                                console.error('Error fetching session details:', error);
                            });
                    });
                });

                // Delete Session Modal
                document.querySelectorAll('.delete-session').forEach(button => {
                    button.addEventListener('click', function() {
                        const sessionId = this.getAttribute('data-id');
                        const sessionName = this.getAttribute('data-name');

                        document.getElementById('delete_session_name').textContent = sessionName;
                        document.getElementById('deleteSessionForm').action =
                            `{{ url('admin/academic-sessions') }}/${sessionId}`;
                    });
                });
            });
        </script>
    @endpush

</x-admin-layout>
