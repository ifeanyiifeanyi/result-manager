<aside class="sidebar">
    <!-- sidebar close btn -->
    <button type="button"
        class="w-24 h-24 text-gray-500 border border-gray-100 sidebar-close-btn hover-text-white hover-bg-main-600 text-md hover-border-main-600 d-xl-none d-flex flex-center rounded-circle position-absolute"><i
            class="ph ph-x"></i></button>
    <!-- sidebar close btn -->

    <a href="{{ route('student.dashboard') }}"
        class="p-20 pb-10 text-center bg-white sidebar__logo position-sticky inset-block-start-0 z-1">
        <img src="{{ asset($school->logo ?? 'no-img.png') }}" alt="Logo" class="w-25">
    </a>

    <div class="overflow-y-auto sidebar-menu-wrapper scroll-sm">
        <div class="p-20 pt-10">
            <ul class="sidebar-menu">

                <li class="sidebar-menu__item">
                    <a href="{{ route('student.dashboard') }}" class="sidebar-menu__link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                        <span class="icon"><i class="ph ph-squares-four"></i></span>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-menu__item">
                    <a href="{{ route('student.application.start') }}" class="sidebar-menu__link {{ request()->routeIs('student.application.start') ? 'active' : '' }}">
                        <span class="icon"><i class="ph ph-user"></i></span>
                        <span class="text">Start Application</span>
                    </a>
                </li>

                 <li class="sidebar-menu__item">
                    <a href="{{ route('student.profile.show') }}" class="sidebar-menu__link {{ request()->routeIs('student.profile.show') ? 'active' : '' }}">
                        <span class="icon"><i class="ph ph-users-three"></i></span>
                        <span class="text">Profile</span>
                    </a>
                </li>
                <hr>
                <li class="sidebar-menu__item">
                    <a href="{{ route('student.logout') }}" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-sign-out"></i></span>
                        <span class="text">Log Out</span>
                    </a>
                </li>

            </ul>
        </div>

    </div>

</aside>
