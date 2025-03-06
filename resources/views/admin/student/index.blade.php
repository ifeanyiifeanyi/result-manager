<x-admin-layout>
    <x-slot name="title">
        {{ __('Students') }}
    </x-slot>

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="mb-4 d-sm-flex align-items-center justify-content-between">
            <h1 class="mb-0 text-gray-800 h3">Students</h1>
            <a href="{{ route('admin.students.create') }}" class="btn btn-primary">
                <i class="mr-1 fas fa-plus-circle"></i> Add New Student
            </a>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Filter and Search -->
        <div class="mb-4 shadow card">
            <div class="py-3 card-header">
                <h6 class="m-0 font-weight-bold text-primary">Filter Options</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.students') }}" method="GET" class="form-inline">
                    <div class="mr-3 mb-2 form-group">
                        <label for="status" class="mr-2">Status:</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">All Students</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                            </option>
                            <option value="blacklisted" {{ request('status') == 'blacklisted' ? 'selected' : '' }}>
                                Blacklisted</option>
                        </select>
                    </div>
                    <div class="mr-3 mb-2 form-group">
                        <label for="search" class="sr-only">Search</label>
                        <input type="text" class="form-control" id="search" name="search"
                            placeholder="Search by name, email, ID..." value="{{ request('search') }}">
                    </div>
                    <button type="submit" class="mb-2 btn btn-primary">Filter</button>
                    <a href="{{ route('admin.students') }}" class="mb-2 ml-2 btn btn-secondary">Reset</a>
                </form>
            </div>
        </div>

        <!-- Students Table -->
        <div class="mb-4 shadow card">
            <div class="py-3 card-header">
                <h6 class="m-0 font-weight-bold text-primary">Student List</h6>
            </div>


            <div class="card-body">
                <table id="datatable-buttons"class="table table-striped table-bordered dt-responsive w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>ID Number</th>
                            <th>Username</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($students as $student)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $student->photo }}" class="mr-2 rounded-circle" width="40"
                                            height="40" alt="{{ $student->full_name }}">
                                        <span class="text-muted">{{ Str::title($student->full_name) }}</span>
                                    </div>
                                </td>
                                <td>
                                    <a href="mailto:{{ $student->email }}" class="email-text">
                                        {{ $student->email }}
                                    </a>
                                </td>
                                <td>{{ $student->id_number ?? 'N/A' }}</td>
                                <td>{{ $student->username }}</td>
                                <td>
                                    @if ($student->is_blacklisted)
                                        <span class="badge bg-danger">Blacklisted</span>
                                    @elseif ($student->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-warning">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.students.show', $student) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.students.edit', $student) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <div class="dropdown d-inline">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                id="dropdownMenuButton{{ $student->id }}" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-cog"></i>
                                            </button>
                                            <div class="dropdown-menu"
                                                aria-labelledby="dropdownMenuButton{{ $student->id }}">
                                                <form action="{{ route('admin.students.toggle-active', $student) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="dropdown-item">
                                                        @if ($student->is_active)
                                                            <i class="fas fa-user-times text-warning"></i>
                                                            Deactivate
                                                        @else
                                                            <i class="fas fa-user-check text-success"></i> Activate
                                                        @endif
                                                    </button>
                                                </form>
                                                <button type="button" class="dropdown-item" data-toggle="modal"
                                                    data-target="#blacklistModal{{ $student->id }}">
                                                    @if ($student->is_blacklisted)
                                                        <i class="fas fa-user-check text-success"></i> Remove from
                                                        Blacklist
                                                    @else
                                                        <i class="fas fa-ban text-danger"></i> Blacklist
                                                    @endif
                                                </button>
                                                <form action="{{ route('admin.students.reset-password', $student) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="dropdown-item"
                                                        onclick="return confirm('Are you sure you want to reset this student\'s password?')">
                                                        <i class="fas fa-key text-warning"></i> Reset Password
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Blacklist Modal -->
                                    <div class="modal fade" id="blacklistModal{{ $student->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="blacklistModalLabel{{ $student->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="blacklistModalLabel{{ $student->id }}">
                                                        @if ($student->is_blacklisted)
                                                            Remove from Blacklist
                                                        @else
                                                            Blacklist Student
                                                        @endif
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form
                                                    action="{{ route('admin.students.toggle-blacklist', $student) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-body">
                                                        @if ($student->is_blacklisted)
                                                            <p>Are you sure you want to remove
                                                                {{ $student->full_name }} from the blacklist?</p>
                                                            <p>Current reason: {{ $student->blacklist_reason }}</p>
                                                        @else
                                                            <p>Are you sure you want to blacklist
                                                                {{ $student->full_name }}?</p>
                                                            <div class="form-group">
                                                                <label for="blacklist_reason">Reason for
                                                                    Blacklisting:</label>
                                                                <textarea class="form-control" id="blacklist_reason" name="blacklist_reason" rows="3" required></textarea>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger">Confirm</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No students found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            {{-- <div class="d-flex justify-content-end">
                {{ $students->links() }}
            </div> --}}
        </div>
    </div>

    @push('styles')
        {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> --}}
        <style>
            .email-text {
                color: #4e73df; /* Blue color */
                font-weight: 500;
                text-decoration: underline; /* Optional */
            }
            .blacklisted {
                color: #5e0c0c;
            }
        </style>

    @endpush

    @push('scripts')


        <script>
            $(document).ready(function() {
                // Auto-submit form when status changes
                $('#status').change(function() {
                    $(this).closest('form').submit();
                });
            });
        </script>
    @endpush
</x-admin-layout>
