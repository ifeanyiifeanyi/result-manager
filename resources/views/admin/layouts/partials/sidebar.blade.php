<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <div class="logo-box">
                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-light.png" alt="" height="24">
                    </span>
                </a>
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-dark.png" alt="" height="24">
                    </span>
                </a>
            </div>

            <ul id="side-menu">



                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <i data-feather="home"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.analytics') }}">
                        <i data-feather="home"></i>
                        <span> Analytics </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.academic-sessions') }}">
                        <i data-feather="home"></i>
                        <span> Academic Session </span>
                    </a>
                </li>



                <li>
                    <a href="#sidebarAuth" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> School Manager </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarAuth">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('admin.school-settings') }}">Settings</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.school-settings.show') }}">School Details</a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#sidebarError" data-bs-toggle="collapse">
                        <i data-feather="alert-octagon"></i>
                        <span> Questions Settings </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarError">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{  route('admin.questions') }}">Questions</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.questions.create') }}">Create Question</a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarExpages" data-bs-toggle="collapse">
                        <i data-feather="file-text"></i>
                        <span> Applications </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarExpages">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('admin.applications') }}">Applications</a>
                            </li>
                            <li>
                                <a href="pages-profile.html">Profile</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarBaseui" data-bs-toggle="collapse">
                        <i data-feather="package"></i>
                        <span> Students </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarBaseui">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('admin.students') }}">All Students</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.students.create') }}">Create Student</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <hr>

                <li>
                    <a href="{{ route('admin.logout') }}">
                        <i data-feather="log-out"></i>
                        <span>Logout</span>
                    </a>
                </li>



            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
</div>
