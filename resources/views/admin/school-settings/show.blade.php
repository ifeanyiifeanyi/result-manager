<!-- resources/views/admin/school-settings/show.blade.php -->
<x-admin-layout>
    <x-slot name="title">
        {{ __('School Details') }}
    </x-slot>

    <div class="container-fluid">
        <div class="mb-4 row">
            <div class="col-md-12 d-flex justify-content-between align-items-center">
                <h2 class="mb-0">{{ __('School Details') }}</h2>
                <a href="{{ route('admin.school-settings') }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> {{ __('Edit School Information') }}
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Basic Information Card -->
            <div class="col-md-8">
                <div class="mb-4 card">
                    <div class="text-white card-header bg-primary">
                        <h4 class="mb-0 card-title">{{ __('Basic Information') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <h5 class="mb-1 text-muted">{{ __('School Name') }}</h5>
                                <p class="font-weight-bold fs-5">{{ $school->name ?? 'Not set' }}</p>
                            </div>
                            <div class="mb-3 col-md-6">
                                <h5 class="mb-1 text-muted">{{ __('Email Address') }}</h5>
                                <p>
                                    @if ($school->email)
                                        <a href="mailto:{{ $school->email }}" class="text-decoration-none">
                                            {{ $school->email }}
                                        </a>
                                    @else
                                        Not set
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <h5 class="mb-1 text-muted">{{ __('Phone Number') }}</h5>
                                <p>
                                    @if ($school->phone)
                                        <a href="tel:{{ $school->phone }}" class="text-decoration-none">
                                            {{ $school->phone }}
                                        </a>
                                    @else
                                        Not set
                                    @endif
                                </p>
                            </div>
                            <div class="mb-3 col-md-6">
                                <h5 class="mb-1 text-muted">{{ __('Address') }}</h5>
                                <p>{{ $school->address ?? 'Not set' }}</p>
                            </div>
                        </div>

                        <!-- This should go in the Basic Information card, before the Description -->
                        <div class="mt-4 mb-3 row">
                            <div class="col-md-12">
                                <div class="bg-white card">
                                    <div class="card-header text-dark">
                                        <h5 class="mb-0">
                                            <i class="fas fa-money-bill-wave me-2"></i>{{ __('Admission Fee') }}
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h5 class="mb-1 text-muted">{{ __('Fee Amount') }}</h5>
                                                @if ($school->admission_fee)
                                                    <p class="font-weight-bold fs-4">
                                                        ₦{{ number_format($school->admission_fee, 2) }}</p>
                                                @else
                                                    <p class="text-muted">No admission fee set</p>
                                                @endif
                                            </div>
                                            <div class="col-md-8">
                                                <h5 class="mb-1 text-muted">{{ __('Fee Description') }}</h5>
                                                @if ($school->fee_description)
                                                    <p>{{ $school->fee_description }}</p>
                                                @else
                                                    <p class="text-muted">No description available</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 row">
                            <div class="col-md-12">
                                <h5 class="mb-2 text-muted">{{ __('School Description') }}</h5>
                                <div class="p-3 rounded bg-light">
                                    {!! $school->description ?? '<em>No description available</em>' !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEO Information Card -->
                <div class="mb-4 card">
                    <div class="text-white card-header bg-secondary">
                        <h4 class="mb-0 card-title">{{ __('SEO Information') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h5 class="mb-1 text-muted">{{ __('Meta Title') }}</h5>
                            <p>{{ $school->meta_title ?? 'Not set' }}</p>
                        </div>
                        <div class="mb-3">
                            <h5 class="mb-1 text-muted">{{ __('Meta Description') }}</h5>
                            <p>{{ $school->meta_description ?? 'Not set' }}</p>
                        </div>
                        <div class="mb-3">
                            <h5 class="mb-1 text-muted">{{ __('Meta Keywords') }}</h5>
                            @if ($school->meta_keywords)
                                <div class="flex-wrap gap-1 d-flex">
                                    @foreach (explode(',', $school->meta_keywords) as $keyword)
                                        <span class="badge bg-light text-dark">{{ trim($keyword) }}</span>
                                    @endforeach
                                </div>
                            @else
                                <p>Not set</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Logo & Social Links Card -->
                <div class="mb-4 card">
                    <div class="text-white card-header bg-info">
                        <h4 class="mb-0 card-title">{{ __('School Logo') }}</h4>
                    </div>
                    <div class="text-center card-body">
                        <div class="mb-4">
                            @if (!empty($school->logo))
                                <img src="{{ asset($school->logo) }}" alt="{{ $school->name }}"
                                    class="rounded border img-fluid" style="max-height: 200px;">
                            @else
                                <div class="p-5 rounded border bg-light">
                                    <i class="fas fa-school fa-4x text-muted"></i>
                                    <p class="mt-3 text-muted">No logo uploaded</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Social Media Links Card -->
                <div class="mb-4 card">
                    <div class="text-white card-header bg-success">
                        <h4 class="mb-0 card-title">{{ __('Social Media') }}</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fab fa-facebook fa-lg text-primary me-3"></i>
                                @if ($school->facebook)
                                    <a href="{{ $school->facebook }}" target="_blank"
                                        class="text-decoration-none">Facebook</a>
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fab fa-twitter fa-lg text-info me-3"></i>
                                @if ($school->twitter)
                                    <a href="{{ $school->twitter }}" target="_blank"
                                        class="text-decoration-none">Twitter</a>
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fab fa-instagram fa-lg text-danger me-3"></i>
                                @if ($school->instagram)
                                    <a href="{{ $school->instagram }}" target="_blank"
                                        class="text-decoration-none">Instagram</a>
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fab fa-linkedin fa-lg text-primary me-3"></i>
                                @if ($school->linkedin)
                                    <a href="{{ $school->linkedin }}" target="_blank"
                                        class="text-decoration-none">LinkedIn</a>
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Google Map Card -->
                @if ($school->google_map)
                    <div class="mb-4 card">
                        <div class="text-white card-header bg-dark">
                            <h4 class="mb-0 card-title">{{ __('Location') }}</h4>
                        </div>
                        <div class="p-0 card-body">
                            <div class="ratio ratio-4x3">
                                <iframe src="{{ $school->google_map }}" width="100%" height="300"
                                    style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade" class="rounded-bottom">
                                </iframe>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .card {
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                margin-bottom: 1.5rem;
                border-radius: 0.5rem;
                overflow: hidden;
            }

            .card-header {
                border-bottom: 1px solid rgba(0, 0, 0, 0.125);
                padding: 1rem;
            }

            .text-muted {
                color: #6c757d;
            }

            .bg-light {
                background-color: #f8f9fa;
            }
        </style>
    @endpush

    @push('scripts')
        <!-- Font Awesome for icons -->
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    @endpush
</x-admin-layout>
