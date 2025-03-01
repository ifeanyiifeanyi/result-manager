<div class="modal fade" id="createSessionModal" tabindex="-1" aria-labelledby="createSessionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="createSessionForm" action="{{ route('admin.academic-sessions.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createSessionModalLabel">Create New Academic Session</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Alert container for errors -->
                    <div id="createErrorAlert" class="alert alert-danger d-none">
                        <ul id="createErrorList" class="mb-0"></ul>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Session Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                        <div class="invalid-feedback" id="name-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Year</label>
                        <input type="date" class="form-control" id="year" name="year"
                            value="{{ date('Y') }}" required>
                        <div class="invalid-feedback" id="year-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        <div class="invalid-feedback" id="description-error"></div>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1">
                        <label class="form-check-label" for="is_active">Set as Active Session</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="createSessionBtn">Create Session</button>
                </div>
            </form>
        </div>
    </div>
</div>
