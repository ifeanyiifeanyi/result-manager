<aside class="sidebar">
    <!-- sidebar close btn -->
    <button type="button"
        class="w-24 h-24 text-gray-500 border border-gray-100 sidebar-close-btn hover-text-white hover-bg-main-600 text-md hover-border-main-600 d-xl-none d-flex flex-center rounded-circle position-absolute"><i
            class="ph ph-x"></i></button>
    <!-- sidebar close btn -->

    <a href="{{ route('student.dashboard') }}"
        class="p-20 pb-10 text-center bg-white sidebar__logo position-sticky inset-block-start-0 w-100 z-1">
        <img src="{{ asset('/studentsrc/assets/images/logo/logo.png') }}" alt="Logo">
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
                <li class="sidebar-menu__item has-dropdown">
                    <a href="javascript:void(0)" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-graduation-cap"></i></span>
                        <span class="text">Courses</span>
                    </a>
                    <!-- Submenu start -->
                    <ul class="sidebar-submenu">
                        <li class="sidebar-submenu__item">
                            <a href="student-courses.html" class="sidebar-submenu__link"> Student Courses </a>
                        </li>
                        <li class="sidebar-submenu__item">
                            <a href="mentor-courses.html" class="sidebar-submenu__link"> Mentor Courses </a>
                        </li>
                        <li class="sidebar-submenu__item">
                            <a href="create-course.html" class="sidebar-submenu__link"> Create Course </a>
                        </li>
                    </ul>
                    <!-- Submenu End -->
                </li>
                <li class="sidebar-menu__item">
                    <a href="students.html" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-users-three"></i></span>
                        <span class="text">Students</span>
                    </a>
                </li>


            </ul>
        </div>

    </div>

</aside>
