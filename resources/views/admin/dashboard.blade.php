<x-admin-layout>
    <x-slot name="title">
        {{ __('Dashboard') }}
    </x-slot>

    <div class="row g-4">
        <div class="col-xl-3 col-md-6">
            <div class="border-opacity-50 shadow-sm card border-primary">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <img src="{{ asset('admin.png') }}" alt="Total Users" class="img-fluid"
                            style="max-width: 60px;">
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted">Total Users</h6>
                        <h4 class="mb-0">{{ $stats['total_users'] ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="border-opacity-50 shadow-sm card border-success">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <img src="{{ asset('up-arrow.png') }}" alt="Total Applications"
                            class="img-fluid" style="max-width: 60px;">
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted">Total Applications</h6>
                        <h4 class="mb-0">{{ $stats['total'] ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="border-opacity-50 shadow-sm card border-warning">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <img src="{{ asset('wallet.png') }}" alt="Draft Applications"
                            class="img-fluid" style="max-width: 60px;">
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted">Draft Applications</h6>
                        <h4 class="mb-0">{{ $stats['draft'] ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="border-opacity-50 shadow-sm card border-info">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <img src="{{ asset('pending.png') }}"
                            alt="Submitted Applications" class="img-fluid" style="max-width: 60px;">
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted">Submitted Applications</h6>
                        <h4 class="mb-0">{{ $stats['submitted'] ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="border-opacity-50 shadow-sm card border-secondary">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <img src="{{ asset('children.png') }}" alt="Under Review"
                            class="img-fluid" style="max-width: 60px;">
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted">Under Review</h6>
                        <h4 class="mb-0">{{ $stats['under_review'] ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="border-opacity-50 shadow-sm card border-success">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <img src="{{ asset('graduated.png') }}" alt="Approved"
                            class="img-fluid" style="max-width: 60px;">
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted">Approved</h6>
                        <h4 class="mb-0">{{ $stats['approved'] ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="border-opacity-50 shadow-sm card border-danger">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <img src="{{ asset('reject.png') }}" alt="Rejected"
                            class="img-fluid" style="max-width: 60px;">
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted">Rejected</h6>
                        <h4 class="mb-0">{{ $stats['rejected'] ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="border-opacity-50 shadow-sm card border-success">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <img src="{{ asset('calculator.png') }}" alt="Paid Applications"
                            class="img-fluid" style="max-width: 60px;">
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted">Paid Applications</h6>
                        <h4 class="mb-0">{{ $stats['paid'] ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('styles')
    @endpush


    @push('scripts')
    @endpush

</x-admin-layout>
