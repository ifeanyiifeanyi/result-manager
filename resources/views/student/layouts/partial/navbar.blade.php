<div class="gap-16 top-navbar flex-between">

    <div class="gap-16 flex-align">
        <!-- Toggle Button Start -->
        <button type="button" class="text-gray-500 toggle-btn d-xl-none d-flex text-26"><i
                class="ph ph-list"></i></button>
        <!-- Toggle Button End -->

        <form action="#" class="w-350 d-sm-block d-none">
            <div class="position-relative">
                <button type="submit" class="text-xl text-gray-100 input-icon d-flex pointer-event-none"><i
                        class="ph ph-magnifying-glass"></i></button>
                <input type="text"
                    class="h-40 border-transparent form-control ps-40 focus-border-main-600 bg-main-50 rounded-pill placeholder-15"
                    placeholder="Search...">
            </div>
        </form>
    </div>

    <div class="gap-16 flex-align">



        <!-- User Profile Start -->
        <div class="dropdown">
            <button
                class="p-4 border border-gray-200 users arrow-down-icon rounded-pill d-inline-block pe-40 position-relative"
                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="position-relative">
                    <img src="{{ $user->photo }}" alt="Image" class="w-32 h-32 rounded-circle">
                    <span
                        class="w-8 h-8 activation-badge position-absolute inset-block-end-0 inset-inline-end-0"></span>
                </span>
            </button>
            <div class="p-0 bg-transparent border-0 dropdown-menu dropdown-menu--lg">
                <div class="border border-gray-100 card rounded-12 box-shadow-custom">
                    <div class="card-body">
                        <div class="gap-8 pb-20 mb-20 border-gray-100 flex-align border-bottom">
                            <img src="{{ $user->photo }}" alt="" class="w-54 h-54 rounded-circle">
                            <div class="">
                                <h4 class="mb-0">{{ $user->full_name }}</h4>
                                <p class="text-gray-200 fw-medium text-13">{{ $user->email }}</p>
                            </div>
                        </div>
                        <ul class="overflow-y-auto max-h-270 scroll-sm pe-4">
                            <li class="mb-4">
                                <a href="{{ route('student.profile.show') }}"
                                    class="gap-8 px-20 py-12 text-gray-300 text-15 hover-bg-gray-50 rounded-8 flex-align fw-medium">
                                    <span class="text-2xl text-primary-600 d-flex"><i class="ph ph-gear"></i></span>
                                    <span class="text">Account Settings</span>
                                </a>
                            </li>
                            <li class="mb-4">
                                <a href="analytics.html"
                                    class="gap-8 px-20 py-12 text-gray-300 text-15 hover-bg-gray-50 rounded-8 flex-align fw-medium">
                                    <span class="text-2xl text-primary-600 d-flex"><i
                                            class="ph ph-chart-line-up"></i></span>
                                    <span class="text">Daily Activity</span>
                                </a>
                            </li>
                            <li class="pt-8 border-gray-100 border-top">
                                <a href="sign-in.html"
                                    class="gap-8 px-20 py-12 text-gray-300 text-15 hover-bg-danger-50 hover-text-danger-600 rounded-8 flex-align fw-medium">
                                    <span class="text-2xl text-danger-600 d-flex"><i
                                            class="ph ph-sign-out"></i></span>
                                    <span class="text">Log Out</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- User Profile Start -->

    </div>
</div>
