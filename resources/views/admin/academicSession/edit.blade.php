<div class="modal fade" id="editSessionModal" tabindex="-1" aria-labelledby="editSessionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editSessionForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editSessionModalLabel">Edit Academic Session</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Alert container for errors -->
                    <div id="editErrorAlert" class="alert alert-danger d-none">
                        <ul id="editErrorList" class="mb-0"></ul>
                    </div>

                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Session Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                        <div class="invalid-feedback" id="edit-name-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_year" class="form-label">Year</label>
                        <input type="date" class="form-control" id="edit_year" name="year"
                            value="{{ date('Y') }}" required>
                        <div class="invalid-feedback" id="edit-year-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                        <div class="invalid-feedback" id="edit-description-error"></div>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="edit_is_active" name="is_active"
                            value="1">
                        <label class="form-check-label" for="edit_is_active">Set as Active Session</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="updateSessionBtn">Update Session</button>
                </div>
            </form>
        </div>
    </div>
</div>
