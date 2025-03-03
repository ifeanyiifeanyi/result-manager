<x-admin-layout>
    <x-slot name="title">
        {{ __('Analytics') }}
    </x-slot>


    <div class="container">
        <h1 class="mb-4">Site Analytics Dashboard</h1>
        <div class="row">
            <div class="mb-4 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Total Page Views: {{ $totalPageViews }}</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="visitsChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="mb-4 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Most Visited Pages</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>URL</th>
                                    <th>Views</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($popularPages as $page)
                                    <tr>
                                        <td>{{ $page->url }}</td>
                                        <td>{{ $page->views }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="mb-4 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Visitors by Country</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Country</th>
                                    <th>Visitors</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($countries as $country)
                                    <tr>
                                        <td>{{ $country->country ?: 'Unknown' }}</td>
                                        <td>{{ $country->total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="mb-4 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Browsers</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="browsersChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="mb-4 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Device Types</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="devicesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const visitsCtx = document.getElementById('visitsChart').getContext('2d');
            new Chart(visitsCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($dailyVisits->pluck('date')) !!},
                    datasets: [{
                        label: 'Daily Visits',
                        data: {!! json_encode($dailyVisits->pluck('views')) !!},
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            const browsersCtx = document.getElementById('browsersChart').getContext('2d');
            new Chart(browsersCtx, {
                type: 'pie',
                data: {
                    labels: {!! json_encode($browsers->pluck('browser')) !!},
                    datasets: [{
                        data: {!! json_encode($browsers->pluck('total')) !!},
                        backgroundColor: [
                            '#FF6384',
                            '#36A2EB',
                            '#FFCE56',
                            '#4BC0C0',
                            '#9966FF',
                            '#FF9F40'
                        ]
                    }]
                }
            });
            const devicesCtx = document.getElementById('devicesChart').getContext('2d');
            new Chart(devicesCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($devices->pluck('device_type')) !!},
                    datasets: [{
                        data: {!! json_encode($devices->pluck('total')) !!},
                        backgroundColor: [
                            '#FF6384',
                            '#36A2EB',
                            '#FFCE56'
                        ]
                    }]
                }
            });
        </script>
    @endpush
</x-admin-layout>
