<x-admin-layout>
    <x-slot name="title">
        {{ __('School Settings') }}
    </x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('School Information') }}</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.school-settings.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4 row">
                                <div class="col-md-12">
                                    <h5>Basic Information</h5>
                                    <hr>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">School Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $school->name ?? '') }}"
                                        required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">Email Address <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $school->email ?? '') }}"
                                        required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="phone" class="form-label">Phone Number <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone', $school->phone ?? '') }}"
                                        required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        id="address" name="address"
                                        value="{{ old('address', $school->address ?? '') }}">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-12">
                                    <label for="description" class="form-label">School Description</label>
                                    <textarea class="form-control ckeditor @error('description') is-invalid @enderror" id="description" name="description"
                                        rows="4">{{ old('description', $school->description ?? '') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- This should go inside the Basic Information section, after the Description field -->
                                <div class="mb-4 row">
                                    <div class="col-md-12">
                                        <h5>Admission Fee</h5>
                                        <hr>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="admission_fee" class="form-label">Admission Fee Amount</label>
                                        <div class="input-group">
                                            <span class="input-group-text">₦</span>
                                            <input type="number" step="0.01" min="0"
                                                class="form-control @error('admission_fee') is-invalid @enderror"
                                                id="admission_fee" name="admission_fee"
                                                value="{{ old('admission_fee', $school->admission_fee ?? '') }}">
                                            @error('admission_fee')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <small class="text-muted">Enter the base admission fee amount for student
                                            enrollment</small>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="fee_description" class="form-label">Fee Description</label>
                                        <textarea class="form-control @error('fee_description') is-invalid @enderror" id="fee_description"
                                            name="fee_description" rows="3">{{ old('fee_description', $school->fee_description ?? '') }}</textarea>
                                        @error('fee_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Provide details about what the admission fee
                                            covers</small>
                                    </div>
                                </div>

                                <div class="mb-3 col-md-12">
                                    <label class="form-label">School Logo</label>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="text-center">
                                                <!-- Clickable logo container -->
                                                <div class="p-3 rounded border cursor-pointer"
                                                    style="height: 150px; width: 150px; display: flex; align-items: center; justify-content: center; overflow: hidden; cursor: pointer;"
                                                    onclick="document.getElementById('logo').click()">

                                                    @if (!empty($school->logo))
                                                        <img id="logo-preview" src="{{ asset($school->logo) }}"
                                                            alt="School Logo" class="img-fluid"
                                                            style="max-height: 100%; max-width: 100%;">
                                                    @else
                                                        <img id="logo-preview" src="{{ asset('no-img.png') }}"
                                                            alt="No Logo" class="img-fluid"
                                                            style="max-height: 100%; max-width: 100%; opacity: 0.3;">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <!-- Hidden file input -->
                                                <input type="file"
                                                    class="d-none @error('logo') is-invalid @enderror" id="logo"
                                                    name="logo" accept="image/*" onchange="previewImage(this)">
                                                <small class="text-muted">Recommended size: 200x200px. Max file size:
                                                    2MB</small>
                                                @error('logo')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                                <p class="mt-2 text-muted">Click on the image to select a new logo</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <div class="col-md-12">
                                    <h5>Social Media Links</h5>
                                    <hr>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="facebook" class="form-label">Facebook</label>
                                    <input type="url" class="form-control @error('facebook') is-invalid @enderror"
                                        id="facebook" name="facebook"
                                        value="{{ old('facebook', $school->facebook ?? '') }}">
                                    @error('facebook')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="twitter" class="form-label">Twitter</label>
                                    <input type="url" class="form-control @error('twitter') is-invalid @enderror"
                                        id="twitter" name="twitter"
                                        value="{{ old('twitter', $school->twitter ?? '') }}">
                                    @error('twitter')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="instagram" class="form-label">Instagram</label>
                                    <input type="url"
                                        class="form-control @error('instagram') is-invalid @enderror" id="instagram"
                                        name="instagram" value="{{ old('instagram', $school->instagram ?? '') }}">
                                    @error('instagram')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="linkedin" class="form-label">LinkedIn</label>
                                    <input type="url"
                                        class="form-control @error('linkedin') is-invalid @enderror" id="linkedin"
                                        name="linkedin" value="{{ old('linkedin', $school->linkedin ?? '') }}">
                                    @error('linkedin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-12">
                                    <label for="google_map" class="form-label">Google Map Embed URL</label>
                                    <input type="url"
                                        class="form-control @error('google_map') is-invalid @enderror"
                                        id="google_map" name="google_map"
                                        value="{{ old('google_map', $school->google_map ?? '') }}">
                                    <small class="form-text text-muted">Enter the embed URL from Google Maps</small>
                                    @error('google_map')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <div class="col-md-12">
                                    <h5>SEO Information</h5>
                                    <hr>
                                </div>

                                <div class="mb-3 col-md-12">
                                    <label for="meta_title" class="form-label">Meta Title</label>
                                    <input type="text"
                                        class="form-control @error('meta_title') is-invalid @enderror"
                                        id="meta_title" name="meta_title"
                                        value="{{ old('meta_title', $school->meta_title ?? '') }}">
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-12">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description"
                                        name="meta_description" rows="3">{{ old('meta_description', $school->meta_description ?? '') }}</textarea>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-12">
                                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                    <textarea class="form-control @error('meta_keywords') is-invalid @enderror" id="meta_keywords" name="meta_keywords"
                                        rows="2">{{ old('meta_keywords', $school->meta_keywords ?? '') }}</textarea>
                                    <small class="form-text text-muted">Separate keywords with commas</small>
                                    @error('meta_keywords')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .card {
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                margin-bottom: 1.5rem;
            }

            .card-header {
                background-color: #f8f9fa;
                border-bottom: 1px solid rgba(0, 0, 0, 0.125);
            }

            .ck-editor__editable {
                min-height: 200px;
            }

            /* Style for the clickable image container */
            .cursor-pointer {
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .cursor-pointer:hover {
                border-color: #007bff;
                box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
            }
        </style>
    @endpush

    @push('scripts')
        <!-- CKEditor CDN -->
        <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

        <script>
            // Preview image functionality
            function previewImage(input) {
                const preview = document.getElementById('logo-preview');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.opacity = 1;
                    }

                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.src = "{{ !empty($school->logo) ? asset($school->logo) : asset('images/no-image.png') }}";
                    preview.style.opacity = "{{ !empty($school->logo) ? '1' : '0.3' }}";
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                // Initialize CKEditor on the description field
                ClassicEditor
                    .create(document.querySelector('#description'), {
                        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList',
                            'blockQuote', 'insertTable', 'undo', 'redo'
                        ],
                        heading: {
                            options: [{
                                    model: 'paragraph',
                                    title: 'Paragraph',
                                    class: 'ck-heading_paragraph'
                                },
                                {
                                    model: 'heading1',
                                    view: 'h1',
                                    title: 'Heading 1',
                                    class: 'ck-heading_heading1'
                                },
                                {
                                    model: 'heading2',
                                    view: 'h2',
                                    title: 'Heading 2',
                                    class: 'ck-heading_heading2'
                                },
                                {
                                    model: 'heading3',
                                    view: 'h3',
                                    title: 'Heading 3',
                                    class: 'ck-heading_heading3'
                                }
                            ]
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            });
        </script>
    @endpush
</x-admin-layout>
