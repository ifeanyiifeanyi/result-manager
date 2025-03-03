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

                            <li>
                                <a href="ui-typography.html">Typography</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarAdvancedUI" data-bs-toggle="collapse">
                        <i data-feather="cpu"></i>
                        <span> Extended UI </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarAdvancedUI">
                        <ul class="nav-second-level">
                            <li>
                                <a href="extended-carousel.html">Carousel</a>
                            </li>
                            <li>
                                <a href="extended-notifications.html">Notifications</a>
                            </li>
                            <li>
                                <a href="extended-offcanvas.html">Offcanvas</a>
                            </li>
                            <li>
                                <a href="extended-range-slider.html">Range Slider</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarIcons" data-bs-toggle="collapse">
                        <i data-feather="award"></i>
                        <span> Icons </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarIcons">
                        <ul class="nav-second-level">
                            <li>
                                <a href="icons-feather.html">Feather Icons</a>
                            </li>
                            <li>
                                <a href="icons-mdi.html">Material Design Icons</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarForms" data-bs-toggle="collapse">
                        <i data-feather="briefcase"></i>
                        <span> Forms </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarForms">
                        <ul class="nav-second-level">
                            <li>
                                <a href="forms-elements.html">General Elements</a>
                            </li>
                            <li>
                                <a href="forms-validation.html">Validation</a>
                            </li>
                            <li>
                                <a href="forms-quilljs.html">Quilljs Editor</a>
                            </li>
                            <li>
                                <a href="forms-pickers.html">Picker</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarTables" data-bs-toggle="collapse">
                        <i data-feather="table"></i>
                        <span> Tables </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarTables">
                        <ul class="nav-second-level">
                            <li>
                                <a href="tables-basic.html">Basic Tables</a>
                            </li>
                            <li>
                                <a href="tables-datatables.html">Data Tables</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarCharts" data-bs-toggle="collapse">
                        <i data-feather="pie-chart"></i>
                        <span> Apex Charts </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarCharts">
                        <ul class="nav-second-level">
                            <li>
                                <a href="charts-line.html">Line</a>
                            </li>
                            <li>
                                <a href="charts-area.html">Area</a>
                            </li>
                            <li>
                                <a href="charts-column.html">Column</a>
                            </li>
                            <li>
                                <a href="charts-bar.html">Bar</a>
                            </li>
                            <li>
                                <a href="charts-mixed.html">Mixed</a>
                            </li>
                            <li>
                                <a href="charts-timeline.html">Timeline</a>
                            </li>
                            <li>
                                <a href="charts-rangearea.html">Range Area</a>
                            </li>
                            <li>
                                <a href="charts-funnel.html">Funnel</a>
                            </li>
                            <li>
                                <a href="charts-candlestick.html">Candlestick</a>
                            </li>
                            <li>
                                <a href="charts-boxplot.html">Boxplot</a>
                            </li>
                            <li>
                                <a href="charts-bubble.html">Bubble</a>
                            </li>
                            <li>
                                <a href="charts-scatter.html">Scatter</a>
                            </li>
                            <li>
                                <a href="charts-heatmap.html">Heatmap</a>
                            </li>
                            <li>
                                <a href="charts-treemap.html">Treemap</a>
                            </li>
                            <li>
                                <a href="charts-pie.html">Pie</a>
                            </li>
                            <li>
                                <a href="charts-radialbar.html">Radialbar</a>
                            </li>
                            <li>
                                <a href="charts-radar.html">Radar</a>
                            </li>
                            <li>
                                <a href="charts-polararea.html">Polar</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
</div>
