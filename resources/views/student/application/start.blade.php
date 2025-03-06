<x-student-layout>
    <x-slot name="title">
        {{ __('Start Your Application') }}
    </x-slot>

    <div class="container-fluid">
        {{-- Profile Completion Alert --}}
        @if (count($missingFields) > 0)
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-3 fa-2x"></i>
                    <div>
                        <h4 class="alert-heading">{{ __('Profile Incomplete') }}</h4>
                        <p class="mb-2">{{ __('Please update the following information to complete your profile:') }}
                        </p>
                        <ul class="mb-0 ps-3">
                            @foreach ($missingFields as $field => $label)
                                <li>{{ $label }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('student.profile.show') }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-user-edit me-1"></i> {{ __('Update Profile') }}
                    </a>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @else

        {{-- Application Form Container --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="text-white card-header bg-primary">
                        <h3 class="mb-0 card-title">
                            <i class="fas fa-file-alt me-2"></i>
                            {{ __('Application for :session', ['session' => $activeSession->name]) }}
                        </h3>
                    </div>

                    <div class="card-body">
                        @if ($application)
                            <div class="alert alert-info">
                                <h5>{{ __('Existing Application') }}</h5>
                                <p>{{ __('You have already applied for this academic session.') }}</p>
                                <div class="mt-3">
                                    <a href="{{ route('student.application.status') }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye me-1"></i> {{ __('View Status') }}
                                    </a>
                                </div>
                            </div>
                        @else
                            <form action="{{ route('student.application.submit') }}" method="POST"
                                id="applicationForm" enctype="multipart/form-data">
                                @csrf
                                {{-- Application Questions --}}
                                @foreach ($questions as $index => $question)
                                    <div class="mb-5 question-container" data-question-id="{{ $question->id }}">
                                        <!-- Increased from mb-4 to mb-5 -->
                                        <label class="mb-3 form-label fw-bold">
                                            <!-- Added mb-3 for spacing below label -->
                                            {{ $index + 1 }}. {{ $question->title }}
                                            @if ($question->is_required)
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>

                                        @switch($question->type)
                                            {{-- text input  --}}
                                            @case('text')
                                                <input type="text"
                                                    class="form-control @error("answers.{$question->id}") is-invalid @enderror"
                                                    name="answers[{{ $question->id }}]"
                                                    {{ $question->is_required ? 'required' : '' }}>
                                                @error("answers.{$question->id}")
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <hr>
                                            @break

                                            {{-- textarea  --}}
                                            @case('textarea')
                                                <textarea class="form-control @error("answers.{$question->id}") is-invalid @enderror"
                                                    name="answers[{{ $question->id }}]" rows="4" {{ $question->is_required ? 'required' : '' }}></textarea>
                                                @error("answers.{$question->id}")
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <hr>
                                            @break

                                            {{-- radio input  --}}
                                            @case('radio')
                                                @php
                                                    $decodedOptions = is_string($question->options)
                                                        ? json_decode($question->options, true)
                                                        : $question->options;
                                                    $options =
                                                        isset($decodedOptions['options']) &&
                                                        is_array($decodedOptions['options'])
                                                            ? $decodedOptions['options']
                                                            : [];
                                                @endphp
                                                <div class="gap-3 d-flex flex-column">
                                                    <small class="text-muted">single choice selection allowed !!</small>

                                                    @foreach ($options as $option)
                                                        <div class="form-check">
                                                            <input type="radio"
                                                                class="form-check-input @error("answers.{$question->id}") is-invalid @enderror"
                                                                name="answers[{{ $question->id }}]"
                                                                id="radio_{{ $question->id }}_{{ $loop->index }}"
                                                                value="{{ $option }}"
                                                                {{ $question->is_required ? 'required' : '' }}>
                                                            <label class="form-check-label"
                                                                for="radio_{{ $question->id }}_{{ $loop->index }}">
                                                                {{ Str::title($option) }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @error("answers.{$question->id}")
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                                <hr>
                                            @break

                                            {{-- checkbox input  --}}
                                            @case('checkbox')
                                                @php
                                                    $decodedOptions = is_string($question->options)
                                                        ? json_decode($question->options, true)
                                                        : $question->options;
                                                    $options =
                                                        isset($decodedOptions['options']) &&
                                                        is_array($decodedOptions['options'])
                                                            ? $decodedOptions['options']
                                                            : [];
                                                @endphp
                                                <div class="gap-3 d-flex flex-column">
                                                    <small class="text-muted">multiple choices selection allowed !!</small>

                                                    @foreach ($options as $option)
                                                        <div class="form-check">
                                                            <input type="checkbox"
                                                                class="form-check-input @error("answers.{$question->id}") is-invalid @enderror"
                                                                name="answers[{{ $question->id }}][]"
                                                                id="check_{{ $question->id }}_{{ $loop->index }}"
                                                                value="{{ $option }}"
                                                                {{ $question->is_required && $loop->first ? 'required' : '' }}>

                                                            <label class="form-check-label"
                                                                for="check_{{ $question->id }}_{{ $loop->index }}">
                                                                {{ Str::title($option) }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @error("answers.{$question->id}")
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                                <hr>
                                            @break

                                            {{-- file input  --}}
                                            @case('file')
                                                <input type="file"
                                                    class="form-control @error("answers.{$question->id}") is-invalid @enderror"
                                                    name="answers[{{ $question->id }}]"
                                                    {{ $question->is_required ? 'required' : '' }}>
                                                @error("answers.{$question->id}")
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <hr>
                                            @break

                                            {{-- select tag --}}
                                            @case('options')
                                                @php
                                                    $decodedOptions = is_string($question->options)
                                                        ? json_decode($question->options, true)
                                                        : $question->options;
                                                    $options =
                                                        isset($decodedOptions['options']) &&
                                                        is_array($decodedOptions['options'])
                                                            ? $decodedOptions['options']
                                                            : [];
                                                @endphp
                                                <select
                                                    class="form-select @error("answers.{$question->id}") is-invalid @enderror"
                                                    name="answers[{{ $question->id }}]"
                                                    {{ $question->is_required ? 'required' : '' }}>
                                                    <option value="">{{ __('Select an option') }}</option>
                                                    @foreach ($options as $option)
                                                        <option value="{{ $option }}">{{ ucfirst($option) }}</option>
                                                    @endforeach
                                                </select>
                                                @error("answers.{$question->id}")
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <hr>
                                            @break
                                        @endswitch
                                    </div>
                                @endforeach

                                <div class="mt-5"> <!-- Increased from mt-4 to mt-5 -->
                                    <button type="submit" class="btn btn-primary w-100"
                                        @if (count($missingFields) > 0) disabled @endif>
                                        {{ __('Submit Application') }}
                                    </button>
                                    @if (count($missingFields) > 0)
                                        <p class="mt-3 text-center text-muted"> <!-- Increased from mt-2 to mt-3 -->
                                            {{ __('Complete your profile to enable application') }}
                                        </p>
                                    @endif
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    @push('styles')
        <style>
            .question-container {
                margin-bottom: 2.5rem;
                /* Overrides mb-5 if needed */
            }

            .form-check {
                margin-bottom: 0.75rem;
                /* Fine-tunes spacing between radio/checkbox options */
            }

            .form-label {
                margin-bottom: 1rem;
                /* Overrides mb-3 if needed */
            }
        </style>
    @endpush

    @push('scripts')
    @endpush
</x-student-layout>

