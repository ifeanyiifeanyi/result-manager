<x-admin-layout>
    <x-slot name="title">
        {{ __('Questions Settings') }}
    </x-slot>

    @push('styles')
        <style>
            .question-block {
                background-color: #f8f9fa;
                border-radius: 8px;
                padding: 20px;
                margin-bottom: 20px;
                border-left: 4px solid #4e73df;
                box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            }

            .options-container {
                display: none;
            }

            .question-type-select:has(option[value="radio"]:checked)~.options-container,
            .question-type-select:has(option[value="checkbox"]:checked)~.options-container {
                display: block;
            }

            .options-badge {
                margin: 5px;
                display: inline-block;
            }

            .header-container {
                background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
                color: white;
                padding: 25px;
                border-radius: 8px;
                margin-bottom: 30px;
            }

            .action-btn {
                transition: all 0.3s;
            }

            .action-btn:hover {
                transform: translateY(-2px);
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
                    <span class="p-2 badge bg-light text-dark">
                        <i class="far fa-calendar-alt"></i>
                        Session Year: {{ $activeSession->year->format('Y') }}
                    </span>
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
                    <i class="mr-2 fas fa-list-alt"></i> Manage Application Questions
                </h5>
                <span class="text-muted small">
                    Configure questions applicants will answer
                </span>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.questions.storeBulk') }}" id="questionsForm">
                    @csrf
                    <input type="hidden" name="academic_session_id" value="{{ $activeSession->id }}">

                    <div id="question-fields">
                        @if (isset($questions) && count($questions) > 0)
                            @foreach ($questions as $index => $question)
                                <div class="question-block" id="question-block-{{ $index }}">
                                    <div class="mb-3 row">
                                        <div class="col-md-12 d-flex justify-content-between align-items-start">
                                            <h5 class="mb-0 card-title">Question #{{ $index + 1 }}</h5>
                                            <button type="button" class="btn btn-sm btn-outline-danger action-btn"
                                                onclick="removeQuestion({{ $index }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <div class="col-md-8">
                                            <label class="form-label">Question Title <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                name="questions[{{ $index }}][title]"
                                                value="{{ $question->title }}"
                                                placeholder="e.g., What is your educational background?" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Question Type <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select question-type-select"
                                                name="questions[{{ $index }}][type]"
                                                onchange="toggleOptionsInput(this)" required>
                                                <option value="text"
                                                    {{ $question->type == 'text' ? 'selected' : '' }}>Short Answer
                                                </option>
                                                <option value="textarea"
                                                    {{ $question->type == 'textarea' ? 'selected' : '' }}>Long Answer
                                                </option>
                                                <option value="radio"
                                                    {{ $question->type == 'radio' ? 'selected' : '' }}>Multiple Choice
                                                    (Single Selection)
                                                </option>
                                                <option value="checkbox"
                                                    {{ $question->type == 'checkbox' ? 'selected' : '' }}>Multiple
                                                    Choice (Multiple Selections)</option>
                                                <option value="file"
                                                    {{ $question->type == 'file' ? 'selected' : '' }}>File Upload
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 row options-container"
                                        style="{{ in_array($question->type, ['radio', 'checkbox']) ? 'display: block;' : '' }}">
                                        <div class="col-md-12">
                                            <label class="form-label">Options <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control option-input"
                                                    placeholder="Add an option" id="option-input-{{ $index }}">
                                                <button type="button" class="btn btn-outline-primary"
                                                    onclick="addOption({{ $index }})">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                            <div class="mt-2 options-preview" id="options-preview-{{ $index }}">
                                                @if (isset($question->options) && is_array($question->options))
                                                    @foreach ($question->options->options as $optionIndex => $option)
                                                        <span class="badge bg-primary options-badge">
                                                            {{ $option }}
                                                            <a href="javascript:void(0)"
                                                                onclick="removeOption({{ $index }}, {{ $optionIndex }})"
                                                                class="ml-1 text-white">
                                                                <i class="fas fa-times"></i>
                                                            </a>
                                                        </span>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <input type="hidden" name="questions[{{ $index }}][options]"
                                                id="options-json-{{ $index }}"
                                                value='{{ $question->options ?? "{\"options\":[]}" }}'>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                    name="questions[{{ $index }}][is_required]"
                                                    id="required-{{ $index }}" value="1"
                                                    {{ $question->is_required ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="required-{{ $index }}">Required Question</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="question-block" id="question-block-0">
                                <div class="mb-3 row">
                                    <div class="col-md-12 d-flex justify-content-between align-items-start">
                                        <h5 class="mb-0 card-title">Question #1</h5>
                                        <button type="button" class="btn btn-sm btn-outline-danger action-btn"
                                            onclick="removeQuestion(0)" disabled>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <div class="col-md-8">
                                        <label class="form-label">Question Title <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="questions[0][title]"
                                            placeholder="e.g., What is your educational background?" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Question Type <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select question-type-select" name="questions[0][type]"
                                            onchange="toggleOptionsInput(this)" required>
                                            <option value="text">Short Answer</option>
                                            <option value="textarea">Long Answer</option>
                                            <option value="radio">Multiple Choice (Single Selection)</option>
                                            <option value="checkbox">Multiple Choice (Multiple Selections)</option>
                                            <option value="file">File Upload</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row options-container">
                                    <div class="col-md-12">
                                        <label class="form-label">Options <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control option-input"
                                                placeholder="Add an option" id="option-input-0">
                                            <button type="button" class="btn btn-outline-primary"
                                                onclick="addOption(0)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <div class="mt-2 options-preview" id="options-preview-0"></div>
                                        <input type="hidden" name="questions[0][options]" id="options-json-0"
                                            value='{"options":[]}'>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"
                                                name="questions[0][is_required]" id="required-0" value="1"
                                                checked>
                                            <label class="form-check-label" for="required-0">Required Question</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="mt-4 row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-outline-primary action-btn me-2"
                                onclick="addQuestion()">
                                <i class="fas fa-plus-circle me-1"></i> Add Another Question
                            </button>
                            <button type="submit" class="btn btn-primary action-btn">
                                <i class="fas fa-save me-1"></i> Save All Questions
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Track question count for dynamic additions
            let questionCount = {{ isset($questions) ? count($questions) : 1 }};

            // Add a new question block
            function addQuestion() {
                const index = questionCount;
                const block = `
                <div class="question-block" id="question-block-${index}">
                    <div class="mb-3 row">
                        <div class="col-md-12 d-flex justify-content-between align-items-start">
                            <h5 class="mb-0 card-title">Question #${index + 1}</h5>
                            <button type="button" class="btn btn-sm btn-outline-danger action-btn" onclick="removeQuestion(${index})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-8">
                            <label class="form-label">Question Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="questions[${index}][title]" placeholder="e.g., What is your educational background?" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Question Type <span class="text-danger">*</span></label>
                            <select class="form-select question-type-select" name="questions[${index}][type]" onchange="toggleOptionsInput(this)" required>
                                <option value="text">Short Answer</option>
                                <option value="textarea">Long Answer</option>
                                <option value="radio">Multiple Choice (Single Selection)</option>
                                <option value="checkbox">Multiple Choice (Multiple Selections)</option>
                                <option value="file">File Upload</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row options-container">
                        <div class="col-md-12">
                            <label class="form-label">Options <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control option-input" placeholder="Add an option" id="option-input-${index}">
                                <button type="button" class="btn btn-outline-primary" onclick="addOption(${index})">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="mt-2 options-preview" id="options-preview-${index}"></div>
                            <input type="hidden" name="questions[${index}][options]" id="options-json-${index}" value='{"options":[]}'>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="questions[${index}][is_required]" id="required-${index}" value="1" checked>
                                <label class="form-check-label" for="required-${index}">Required Question</label>
                            </div>
                        </div>
                    </div>
                </div>
            `;

                document.getElementById('question-fields').insertAdjacentHTML('beforeend', block);
                questionCount++;

                // Enable delete button on first question if we have more than one question
                if (questionCount > 1) {
                    const firstDeleteBtn = document.querySelector('#question-block-0 .btn-outline-danger');
                    if (firstDeleteBtn && firstDeleteBtn.hasAttribute('disabled')) {
                        firstDeleteBtn.removeAttribute('disabled');
                    }
                }
            }

            // Remove a question block
            function removeQuestion(index) {
                // Don't allow removal of the last question
                if (questionCount <= 1) {
                    return;
                }

                const questionBlock = document.getElementById(`question-block-${index}`);
                if (questionBlock) {
                    questionBlock.remove();
                    questionCount--;

                    // Disable delete button on first question if only one remains
                    if (questionCount === 1) {
                        const remainingDeleteBtn = document.querySelector('.question-block .btn-outline-danger');
                        if (remainingDeleteBtn) {
                            remainingDeleteBtn.setAttribute('disabled', 'disabled');
                        }
                    }

                    // Renumber the remaining questions
                    const blocks = document.querySelectorAll('.question-block');
                    blocks.forEach((block, idx) => {
                        const headerElem = block.querySelector('h5');
                        if (headerElem) {
                            headerElem.textContent = `Question #${idx + 1}`;
                        }
                    });
                }
            }

            // Toggle options input visibility based on question type
            function toggleOptionsInput(selectElem) {
                const questionBlock = selectElem.closest('.question-block');
                const optionsContainer = questionBlock.querySelector('.options-container');
                optionsContainer.style.display = (selectElem.value === 'radio' || selectElem.value === 'checkbox') ? 'block' :
                    'none';
            }

            // Add option to multiple choice questions
            function addOption(questionIndex) {
                const inputElem = document.getElementById(`option-input-${questionIndex}`);
                const optionText = inputElem.value.trim();

                if (!optionText) return;

                const optionsJsonElem = document.getElementById(`options-json-${questionIndex}`);
                const previewElem = document.getElementById(`options-preview-${questionIndex}`);

                // Parse existing options or initialize
                let optionsData = optionsJsonElem.value ? JSON.parse(optionsJsonElem.value) : {
                    options: []
                };
                if (!optionsData.options) optionsData.options = [];

                // Add new option
                optionsData.options.push(optionText);
                optionsJsonElem.value = JSON.stringify(optionsData);

                // Create and append new badge to preview
                const optionIndex = optionsData.options.length - 1;
                const optionBadge = `
                    <span class="badge bg-primary options-badge">
                        ${optionText}
                        <a href="javascript:void(0)" onclick="removeOption(${questionIndex}, ${optionIndex})" class="ml-1 text-white">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                `;
                previewElem.insertAdjacentHTML('beforeend', optionBadge);

                // Clear input
                inputElem.value = '';
            }

            // Remove option from multiple choice questions
            function removeOption(questionIndex, optionIndex) {
                const optionsJsonElem = document.getElementById(`options-json-${questionIndex}`);
                const previewElem = document.getElementById(`options-preview-${questionIndex}`);

                let optionsData = JSON.parse(optionsJsonElem.value || '{"options":[]}');
                if (optionsData.options && optionIndex >= 0 && optionIndex < optionsData.options.length) {
                    optionsData.options.splice(optionIndex, 1);
                    optionsJsonElem.value = JSON.stringify(optionsData);

                    // Rebuild preview
                    previewElem.innerHTML = '';
                    optionsData.options.forEach((option, idx) => {
                        previewElem.insertAdjacentHTML('beforeend', `
                            <span class="badge bg-primary options-badge">
                                ${option}
                                <a href="javascript:void(0)" onclick="removeOption(${questionIndex}, ${idx})" class="ml-1 text-white">
                                    <i class="fas fa-times"></i>
                                </a>
                            </span>
                        `);
                    });
                }
            }


            // Initialize option containers visibility
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize visibility of option containers
                document.querySelectorAll('.question-type-select').forEach(select => toggleOptionsInput(select));

                // Add event listeners for all option inputs
                document.querySelectorAll('.question-block').forEach(block => {
                    const index = block.id.split('-')[2];
                    const addBtn = block.querySelector('.btn-outline-primary');
                    const input = block.querySelector('.option-input');

                    // Button click
                    addBtn?.addEventListener('click', () => addOption(index));

                    // Enter key press
                    input?.addEventListener('keypress', (e) => {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            addOption(index);
                        }
                    });
                });

                // Ensure dynamic blocks get listeners too
                document.getElementById('question-fields').addEventListener('click', (e) => {
                    const addBtn = e.target.closest('.btn-outline-primary');
                    if (addBtn) {
                        const index = addBtn.closest('.question-block').id.split('-')[2];
                        addOption(index);
                    }
                });
            });
        </script>
    @endpush
</x-admin-layout>
