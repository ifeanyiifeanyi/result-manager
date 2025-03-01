<x-admin-layout>
    <x-slot name="title">
        {{ __('Questions Management') }}
    </x-slot>

    @push('styles')
        <style>
            .question-card {
                transition: all 0.3s;
                border-left: 4px solid #4e73df;
                margin-bottom: 15px;
            }

            .question-card:hover {
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
                transform: translateY(-2px);
            }

            .header-container {
                background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
                color: white;
                padding: 25px;
                border-radius: 8px;
                margin-bottom: 30px;
            }

            .type-badge {
                font-size: 0.75rem;
                padding: 0.25rem 0.5rem;
            }

            .sortable-handle {
                cursor: grab;
            }

            .sortable-handle:active {
                cursor: grabbing;
            }

            .sortable-ghost {
                opacity: 0.5;
                background: #f8f9fa;
            }
        </style>
    @endpush

    <div class="py-4 container-fluid">
        <div class="header-container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="mb-0 text-white h3">
                        <i class="mr-2 fas fa-question-circle"></i> Application Questions
                    </h1>
                    <p class="mb-0 text-white-50">
                        {{ $activeSession->name }} Academic Session
                    </p>
                </div>
                <div class="col-md-6 text-md-right">
                    <a href="{{ route('admin.questions.create') }}" class="btn btn-light">
                        <i class="fas fa-plus-circle"></i> Add New Questions
                    </a>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="mr-2 fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="mr-2 fas fa-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="shadow-sm card">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="mr-2 fas fa-list-alt"></i> Application Questions ({{ $questions->count() }})
                </h5>
                <form action="{{ route('admin.questions.reorder') }}" method="POST" id="reorder-form">
                    @csrf
                    <input type="hidden" name="order" id="questions-order">
                    <button type="submit" id="save-order" class="btn btn-sm btn-primary" disabled>
                        <i class="fas fa-save"></i> Save Order
                    </button>
                </form>
            </div>
            <div class="card-body">
                @if ($questions->count() > 0)
                    <p class="mb-3 text-muted">
                        <i class="fas fa-info-circle"></i> Drag and drop questions to change their order of appearance
                        on the application form.
                    </p>
                    <div class="list-group" id="sortable-questions">
                        @foreach ($questions as $index => $question)
                            <div class="list-group-item question-card" data-id="{{ $question->id }}">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <i class="fas fa-grip-vertical text-muted sortable-handle"></i>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="mb-1">{{ Str::title($question->title) }}</h5>
                                        <div>
                                            @php
                                                $badgeClass = match ($question->type) {
                                                    'text' => 'bg-primary',
                                                    'textarea' => 'bg-info',
                                                    'radio' => 'bg-success',
                                                    'checkbox' => 'bg-warning',
                                                    'file' => 'bg-secondary',
                                                    default => 'bg-dark',
                                                };

                                                $typeLabel = match ($question->type) {
                                                    'text' => 'Short Answer',
                                                    'textarea' => 'Long Answer',
                                                    'radio' => 'Multiple Choice (Single)',
                                                    'checkbox' => 'Multiple Choice (Multiple)',
                                                    'file' => 'File Upload',
                                                    default => ucfirst($question->type),
                                                };
                                            @endphp
                                            <span
                                                class="badge {{ $badgeClass }} type-badge">{{ $typeLabel }}</span>
                                            @if ($question->is_required)
                                                <span class="badge bg-danger type-badge">Required</span>
                                            @else
                                                <span class="badge bg-light text-dark type-badge">Optional</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        @if (in_array($question->type, ['radio', 'checkbox']) && isset($question->options->options))
                                            <small class="text-muted">Options:</small>
                                            <div>
                                                @foreach ($question->options->options as $option)
                                                    <span
                                                        class="badge bg-light text-dark me-1">{{ $option }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-auto ms-auto">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.questions.edit', $question) }}"
                                                class="btn btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger"
                                                onclick="confirmDelete('{{ route('admin.questions.destroy', $question) }}', '{{ Str::upper($question->title) }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-5 text-center">
                        <div class="mb-3">
                            <i class="fas fa-question-circle fa-4x text-muted"></i>
                        </div>
                        <h4>No Questions Found</h4>
                        <p class="text-muted">
                            You haven't created any questions for this academic session yet.
                        </p>
                        <a href="{{ route('admin.questions.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> Create Your First Question
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="text-white modal-header bg-danger">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle"></i> Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the question: <strong id="question-title"></strong>?</p>
                    <p class="text-danger">
                        <i class="fas fa-exclamation-triangle"></i> This action cannot be undone.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="delete-form" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Question</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
        <script>
            // Set up sortable questions list
            document.addEventListener('DOMContentLoaded', function() {
                const questionsContainer = document.getElementById('sortable-questions');

                if (questionsContainer) {
                    const sortable = new Sortable(questionsContainer, {
                        handle: '.sortable-handle',
                        animation: 150,
                        ghostClass: 'sortable-ghost',
                        onEnd: function() {
                            // Enable save button
                            document.getElementById('save-order').removeAttribute('disabled');

                            // Update order input
                            const questionIds = Array.from(questionsContainer.children)
                                .map(item => item.getAttribute('data-id'));

                            document.getElementById('questions-order').value = JSON.stringify(questionIds);
                        }
                    });
                }
            });

            // Delete confirmation
            function confirmDelete(deleteUrl, questionTitle) {
                const modal = document.getElementById('deleteConfirmModal');
                const bsModal = new bootstrap.Modal(modal);

                document.getElementById('question-title').textContent = questionTitle;
                document.getElementById('delete-form').setAttribute('action', deleteUrl);

                bsModal.show();
            }
        </script>
    @endpush
</x-admin-layout>
