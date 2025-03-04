<x-student-layout>
    <x-slot name="title">
        {{ __('Dashboard') }}
    </x-slot>
    <div class="row gy-4">
        <div class="col-lg-9">
            <!-- Grettings Box Start -->
            <div class="overflow-hidden flex-wrap gap-16 grettings-box position-relative rounded-16 bg-main-600 z-1">
                <img src="/studentsrc/assets/images/bg/grettings-pattern.png" alt=""
                    class="position-absolute inset-block-start-0 inset-inline-start-0 z-n1 w-100 h-100 opacity-6">
                <div class="row gy-4">
                    <div class="col-sm-7">
                        <div class="grettings-box__content py-xl-4">
                            <h2 class="mb-0 text-white">Hello, {{ Str::title($user->first_name) }}!</h2>
                            <p class="mt-4 text-white text-15 fw-light">Your journey to higher education begins today!</p>
                            <p class="mt-24 text-lg text-white fw-light">Start preparing your application, set your goals, and take the first step towards your future.</p>
                            @if($user->applications->isEmpty())
                                <a href="{{ route('student.application.start') }}" class="mt-4 btn btn-info">Start Application <i class="fas fa-arrow-right"></i> </a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            <!-- Grettings Box End -->


            @if (count($missingFields) > 0)
                <div class="mt-4 mb-4 alert alert-warning alert-missing-details">
                    <h5><i class="fas fa-exclamation-triangle me-2"></i> Complete Your Profile</h5>
                    <p>Please update the following information to complete your profile:</p>
                    <ul class="mb-0">
                        @foreach ($missingFields as $field => $label)
                            <li>{{ $label }}</li>
                        @endforeach
                    </ul>
                    <div class="mt-3">
                        <a href="{{ route('student.profile.show') }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit me-1"></i> Update Now
                        </a>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-lg-3">

            <!-- Calendar Start -->
            <div class="card">
                <div class="card-body">
                    <div class="calendar">
                        <div class="calendar__header">
                            <button type="button" class="calendar__arrow left"><i
                                    class="ph ph-caret-left"></i></button>
                            <p class="mb-0 display h6">""</p>
                            <button type="button" class="calendar__arrow right"><i
                                    class="ph ph-caret-right"></i></button>
                        </div>

                        <div class="calendar__week week">
                            <div class="calendar__week-text">Su</div>
                            <div class="calendar__week-text">Mo</div>
                            <div class="calendar__week-text">Tu</div>
                            <div class="calendar__week-text">We</div>
                            <div class="calendar__week-text">Th</div>
                            <div class="calendar__week-text">Fr</div>
                            <div class="calendar__week-text">Sa</div>
                        </div>
                        <div class="days"></div>
                    </div>

                </div>
            </div>
            <!-- Calendar End -->
        </div>
    </div>
</x-student-layout>
