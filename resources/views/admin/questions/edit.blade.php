<x-admin-layout>
    <x-slot name="title">
        {{ __('Edit Question') }}
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

        .question-type-select:has(option[value="radio"]:checked) ~ .options-container,
        .question-type-select:has(option[value="checkbox"]:checked) ~ .options-container {
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
    </style>
    @endpush

    <div class="py-4 container-fluid">
        <div class="header-container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="mb-0 text-white h3">
                        <i class="mr-2 fas fa-edit"></i> Edit Question
                    </h1>
                    <p class="mb-0 text-white-50">
                        {{ $activeSession->name }} Academic Session
                    </p>
                </div>
                <div class="col-md-6 text-md-right">
                    <a href="{{ route('admin.questions') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left"></i> Back to Questions
                    </a>
                </div>
            </div>
        </div>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="mr-2 fas fa-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="shadow-sm card">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="mr-2 fas fa-question-circle"></i> Edit Question
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.questions.update', $question) }}" id="questionForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="academic_session_id" value="{{ $activeSession->id }}">

                    <div class="question-block">
                        <div class="mb-3 row">
                            <div class="col-md-8">
                                <label class="form-label">Question Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('questions.0.title') is-invalid @enderror"
                                       name="questions[0][title]"
                                       value="{{ old('questions.0.title', $question->title) }}"
                                       placeholder="e.g., What is your educational background?" required>
                                @error('questions.0.title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Question Type <span class="text-danger">*</span></label>
                                <select class="form-select question-type-select @error('questions.0.type') is-invalid @enderror"
                                        name="questions[0][type]"
                                        onchange="toggleOptionsInput(this)" required>
                                    <option value="text" {{ old('questions.0.type', $question->type) == 'text' ? 'selected' : '' }}>Short Answer</option>
                                    <option value="textarea" {{ old('questions.0.type', $question->type) == 'textarea' ? 'selected' : '' }}>Long Answer</option>
                                    <option value="radio" {{ old('questions.0.type', $question->type) == 'radio' ? 'selected' : '' }}>Multiple Choice (Single Selection)</option>
                                    <option value="checkbox" {{ old('questions.0.type', $question->type) == 'checkbox' ? 'selected' : '' }}>Multiple Choice (Multiple Selections)</option>
                                    <option value="file" {{ old('questions.0.type', $question->type) == 'file' ? 'selected' : '' }}>File Upload</option>
                                </select>
                                @error('questions.0.type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row options-container"
                             style="{{ in_array(old('questions.0.type', $question->type), ['radio', 'checkbox']) ? 'display: block;' : '' }}">
                            <div class="col-md-12">
                                <label class="form-label">Options <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control option-input" placeholder="Add an option" id="option-input-0">
                                    <button type="button" class="btn btn-outline-primary" onclick="addOption(0)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                @error('questions.0.options')
                                    <div class="mt-1 text-danger small">{{ $message }}</div>
                                @enderror
                                <div class="mt-2 options-preview" id="options-preview-0">
                                    @if(isset($question->options->options) && is_array($question->options->options))
                                        @foreach($question->options->options as $optionIndex => $option)
                                            <span class="badge bg-primary options-badge">
                                                {{ $option }}
                                                <a href="javascript:void(0)" onclick="removeOption(0, {{$optionIndex}})" class="ml-1 text-white">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </span>
                                        @endforeach
                                    @endif
                                </div>
                                @php
                                    $optionsJson = old('questions.0.options', $question->options ? json_encode($question->options) : '{"options":[]}');
                                @endphp
                                <input type="hidden" name="questions[0][options]" id="options-json-0" value='{{ $optionsJson }}'>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox"
                                           name="questions[0][is_required]" id="required-0" value="1"
                                           {{ old('questions.0.is_required', $question->is_required) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="required-0">Required Question</label>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="questions[0][id]" value="{{ $question->id }}">
                    </div>

                    <div class="mt-4 row">
                        <div class="col-md-12">
                            <a href="{{ route('admin.questions') }}" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Question
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Toggle options input visibility based on question type
        function toggleOptionsInput(selectElem) {
            const questionBlock = selectElem.closest('.question-block');
            const optionsContainer = questionBlock.querySelector('.options-container');

            if (selectElem.value === 'radio' || selectElem.value === 'checkbox') {
                optionsContainer.style.display = 'block';
            } else {
                optionsContainer.style.display = 'none';
            }
        }

        // Add option to multiple choice questions
        function addOption(questionIndex) {
            const inputElem = document.getElementById(`option-input-${questionIndex}`);
            const optionText = inputElem.value.trim();

            if (!optionText) {
                return;
            }

            // Get current options
            const optionsJsonElem = document.getElementById(`options-json-${questionIndex}`);
            let optionsData = JSON.parse(optionsJsonElem.value);

            // Add new option
            if (!optionsData.options) {
                optionsData.options = [];
            }

            optionsData.options.push(optionText);

            // Update options JSON
            optionsJsonElem.value = JSON.stringify(optionsData);

            // Update visual preview
            const previewElem = document.getElementById(`options-preview-${questionIndex}`);
            const optionIndex = optionsData.options.length - 1;

            const optionBadge = document.createElement('span');
            optionBadge.className = 'badge bg-primary options-badge';
            optionBadge.innerHTML = `
                ${optionText}
                <a href="javascript:void(0)" onclick="removeOption(${questionIndex}, ${optionIndex})" class="ml-1 text-white">
                    <i class="fas fa-times"></i>
                </a>
            `;

            previewElem.appendChild(optionBadge);

            // Clear input
            inputElem.value = '';
        }

        // Remove option from multiple choice questions
        function removeOption(questionIndex, optionIndex) {
            // Get current options
            const optionsJsonElem = document.getElementById(`options-json-${questionIndex}`);
            let optionsData = JSON.parse(optionsJsonElem.value);

            // Remove option
            if (optionsData.options && optionsData.options.length > optionIndex) {
                optionsData.options.splice(optionIndex, 1);

                // Update options JSON
                optionsJsonElem.value = JSON.stringify(optionsData);

                // Rebuild visual preview
                const previewElem = document.getElementById(`options-preview-${questionIndex}`);
                previewElem.innerHTML = '';

                optionsData.options.forEach((option, idx) => {
                    const optionBadge = document.createElement('span');
                    optionBadge.className = 'badge bg-primary options-badge';
                    optionBadge.innerHTML = `
                        ${option}
                        <a href="javascript:void(0)" onclick="removeOption(${questionIndex}, ${idx})" class="ml-1 text-white">
                            <i class="fas fa-times"></i>
                        </a>
                    `;

                    previewElem.appendChild(optionBadge);
                });
            }
        }

        // Initialize on document load
        document.addEventListener('DOMContentLoaded', function() {
            // Setup keyboard support for adding options
            const optionInput = document.querySelector('.option-input');
            if (optionInput) {
                optionInput.addEventListener('keypress', function(event) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        addOption(0);
                    }
                });
            }
        });
    </script>
    @endpush
</x-admin-layout>