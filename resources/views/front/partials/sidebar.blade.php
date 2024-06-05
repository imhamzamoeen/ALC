<aside class="sidebar">
    <div class="toggle pt-4">
        <a href="#" class="burger js-menu-toggle mt-0 mt-md-1" data-toggle="collapse" data-target="#main-navbar">
            <span></span>
        </a>
    </div>
    <div class="side-inner p-0 position-relative">
        <div class="sider-header mb-5">
            <div class="container text-center py-4">
                <a href="{{ route('sales-support.dashboard', app()->getLocale()) }}">
                    <img width="140" src="/images/logo_white.png" alt="logo"></a>
            </div>
        </div>
        @if (auth()->user()->user_type == \App\Classes\Enums\UserTypesEnum::SalesSupport)
            <ul class="sidebar-menu px-0 nav">
                <li class="sidebarMenu-item active">
                    <a href="javascript:void(0)" id="unscheduled-home-tab">
                        <div class="py-3 px-4">
                            <span class="me-4"><img src="/images/home.svg" alt="home"></span><span
                                class="text-med">Home</span>
                        </div>
                    </a>

                </li>
                <li class="sidebarMenu-item dropdown collapsed">
                    <a>
                        <div class="py-3 px-4 nav-collapsable">
                            <span class="me-4"><img src="/images/presentation.svg" alt="presentation"></span><span
                                class="text-med">Trial Status</span>
                        </div>
                    </a>
                    <div>
                        <ul class="sidebar-submenu show px-0 sidebar-tabs">
                            <li class="submenu-item py-2">
                                <a href="javascript:void(0)" id="successful-tab" data-bs-toggle="tab"
                                    data-bs-target="#unscheduled" role="tab" aria-controls="unscheduled"
                                    aria-selected="true">
                                    <div><i class="fa fa-minus fa-xs ms-3 me-2"></i><span class="text-med">Trial
                                            Successful</span></div>
                                </a>
                            </li>
                            <li class="submenu-item py-2">
                                <a href="javascript:void(0)" id="unsuccessful-tab" data-bs-toggle="tab"
                                    data-bs-target="#unscheduled" role="tab" aria-controls="unscheduled"
                                    aria-selected="true">
                                    <div><i class="fa fa-minus fa-xs ms-3 me-2"></i><span class="text-med">Trial
                                            Unsuccessful</span></div>
                                </a>
                            </li>
                            <li class="submenu-item py-2">
                                <a href="javascript:void(0)" id="missed-tab" data-bs-toggle="tab"
                                    data-bs-target="#unscheduled" role="tab" aria-controls="unscheduled"
                                    aria-selected="true">
                                    <div><i class="fa fa-minus fa-xs ms-3 me-2"></i><span class="text-med">Trial
                                            Missed</span></div>
                                </a>
                            </li>
                            <li class="submenu-item py-2">
                                <a href="javascript:void(0)" id="rescheduled-tab" data-bs-toggle="tab"
                                    data-bs-target="#unscheduled" role="tab" aria-controls="unscheduled"
                                    aria-selected="true">
                                    <div><i class="fa fa-minus fa-xs ms-3 me-2"></i><span class="text-med">Trial
                                            Rescheduled</span></div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="sidebarMenu-item dropdown collapsed">
                    <a>
                        <div class="py-3 px-4 nav-collapsable">
                            <span class="me-4"><img src="/images/menu_black.svg" alt="Changes Requests"></span><span
                                class="text-med">Changes Requests </span>
                        </div>
                    </a>
                    <div>
                        <ul class="sidebar-submenu show px-0 sidebar-tabs">
                            <li class="submenu-item py-2">
                                <a href="javascript:void(0)" id="pending-tab" data-bs-toggle="tab"
                                    data-bs-target="#pending" role="tab" aria-controls="pending"
                                    aria-selected="true">
                                    <div><i class="fa fa-minus fa-xs ms-3 me-2"></i><span class="text-med">Pending
                                            Changes</span></div>
                                </a>
                            </li>
                            <li class="submenu-item py-2">
                                <a href="javascript:void(0)" id="progress-tab" data-bs-toggle="tab"
                                    data-bs-target="#progress" role="tab" aria-controls="progress"
                                    aria-selected="true">
                                    <div><i class="fa fa-minus fa-xs ms-3 me-2"></i><span class="text-med">Progress
                                            Changes</span></div>
                                </a>
                            </li>
                            <li class="submenu-item py-2">
                                <a href="javascript:void(0)" id="completed-tab" data-bs-toggle="tab"
                                    data-bs-target="#completed" role="tab" aria-controls="completed"
                                    aria-selected="true">
                                    <div><i class="fa fa-minus fa-xs ms-3 me-2"></i><span class="text-med">Approved
                                        Changes</span></div>
                                </a>
                            </li>
                  
                        </ul>
                    </div>
                </li>
                <li class="sidebarMenu-item sidebar-tabs">
                    <a href="{{ route('sales-support.dashboard', app()->getLocale()) }}" id="invalid-tab"
                        data-bs-toggle="tab" data-bs-target="#unscheduled" role="tab" aria-controls="unscheduled"
                        aria-selected="true">
                        <div class="py-3 px-4">
                            <span class="me-4"><img src="/images/user.svg" alt="user"></span><span
                                class="text-med">Invalid Requests</span>
                        </div>
                    </a>
                </li>
                <li class="sidebarMenu-item sidebar-tabs">
                    <a href="javascript:void(0)" id="summary-tab" data-bs-toggle="tab" data-bs-target="#unscheduled"
                        role="tab" aria-controls="unscheduled" aria-selected="true">
                        <div class="py-3 px-4">
                            <span class="me-4"><img src="/images/search.svg" alt="search"></span><span
                                class="text-med">Summary</span>
                        </div>
                    </a>
                </li>
            </ul>
        @elseif (auth()->user()->user_type == \App\Classes\Enums\UserTypesEnum::Customer)
            <ul class="sidebar-menu px-0 nav">
                <li
                    class="sidebarMenu-item {{ request()->component == 'timeline' ? 'active' : '' }} {{ is_null(request()->component) ? 'active' : '' }}">
                    <a href="javascript:void(0)" id="timeline-sidebar-tab" data-bs-toggle="tab"
                        data-component="timeline" data-bs-target="#timeline" role="tab" aria-controls="timeline"
                        aria-selected="false" data-sibling="timeline-tab">
                        <div class="py-3 px-4">
                            <span class="me-4"><img src="/images/home.svg" alt="home"></span><span
                                class="text-med">Home</span>
                        </div>
                    </a>

                </li>
                <li
                    class="sidebarMenu-item sidebar-tabs {{ request()->component == 'recorded_classes' ? 'active' : '' }}">
                    <a href="javascript:void(0)" id="recorded_classes-tab" data-bs-toggle="tab"
                        data-bs-target="#recorded_classes" data-component="recorded_classes" role="tab"
                        aria-controls="recorded_classes" aria-selected="false">
                        <div class="py-3 px-4">
                            <span class="me-4"><img src="/images/video-call.svg" alt="home"></span><span
                                class="text-med">Recorded Classes</span>
                        </div>
                    </a>

                </li>
                <li
                    class="sidebarMenu-item sidebar-tabs {{ request()->component == 'class_schedule' ? 'active' : '' }}">
                    <a href="javascript:void(0)" id="schedule-sidebar-tab" data-bs-toggle="tab"
                        data-component="class_schedule" data-bs-target="#class_schedule" role="tab"
                        aria-controls="class_schedule" aria-selected="true" data-sibling="class_schedule-tab">
                        <div class="py-3 px-4">
                            <span class="me-4"><img src="/images/presentation.svg" alt="presentation"></span><span
                                class="text-med">Request for MakeUp Class</span>
                        </div>
                    </a>

                </li>
                {{-- <li class="sidebarMenu-item dropdown collapsed">
                    <a>
                        <div class="py-3 px-4 nav-collapsable">
                            <span class="me-4"><img src="/images/vuesax-linear-calendar-edit.svg"
                                    alt="presentation"></span><span class="text-med">Request</span>
                        </div>
                    </a>
                    <div>
                        <ul class="sidebar-submenu show px-0">
                            <li class="submenu-item py-2">
                                <a href="javascript:void(0)" id="change_teacher-tab" data-bs-toggle="tab"
                                    data-bs-target="#change_teacher"  role="tab"
                                    aria-controls="change_teacher" aria-selected="true">
                                    <div><i class="fa fa-minus fa-xs ms-3 me-2"></i><span class="text-med">Change
                                            Teacher</span></div>
                                </a>
                            </li>
                            <li class="submenu-item py-2">
                                <a href="javascript:void(0)" id="schedule-sidebar-tab" data-bs-toggle="tab"
                                    data-component="class_schedule" data-bs-target="#schedule"  role="tab"
                                    aria-controls="schedule" aria-selected="true" data-sibling="schedule-tab">
                                    <div><i class="fa fa-minus fa-xs ms-3 me-2"></i><span class="text-med">Request
                                            For MakeUp</span></div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> --}}
                {{-- <li class="sidebarMenu-item sidebar-tabs" role="presentation">
                    <a href="javascript:void(0)" id="vacation-tab" data-bs-toggle="tab" data-bs-target="#vacation"
                         role="tab" aria-controls="vacation" aria-selected="false">
                        <div class="py-3 px-4">
                            <span class="me-4"><img src="/images/luggage.svg" alt="home"></span><span
                                class="text-med">Vacation Mode</span>
                        </div>
                    </a>

                </li> --}}
            </ul>
            {{-- <ul class="border-top nav px-0 py-2 sidebar-menu w-100 d-sm-none d-block">
                <a href="https://test.alquranclasses.com/en/customer/dashboard">
                    <div class="py-3 px-4" style="border-left:3px solid transparent">
                        <span class="me-4" style="width:25px;height:25px"><i class="fa fa-arrow-left px-18"
                                aria-hidden="true" style="width:25px;height:25px"></i></span><span
                            class="text-med">Back To
                            Dashboard</span>
                    </div>
                </a>
            </ul> --}}
            <ul class="sidebar-menu py-2 bottom-nav border-top px-0 nav w-100">
                <a href="{{ route(auth()->user()->user_type . '.dashboard', app()->getLocale()) }}">
                    <div class="py-3 px-4">
                        <span class="me-4"><i class="fa fa-arrow-left"></i></span><span class="text-med">Back To
                            Dashboard</span>
                    </div>
                </a>
            </ul>
        @elseif (auth()->user()->user_type == \App\Classes\Enums\UserTypesEnum::Teacher)
            <ul class="sidebar-menu px-0 nav">
                <li
                    class="sidebarMenu-item {{ request()->component == 'timeline' ? 'active' : '' }} {{ is_null(request()->component) ? 'active' : '' }}">
                    <a href="javascript:void(0)" id="timeline-sidebar-tab" data-bs-toggle="tab"
                        data-bs-target="#timeline" data-component="timeline" role="tab" aria-controls="timeline"
                        aria-selected="false" data-sibling="timeline-tab">
                        <div class="py-3 px-4">
                            <span class="me-4"><img src="/images/home.svg" alt="home"></span><span
                                class="text-med">Home</span>
                        </div>
                    </a>

                </li>

                <li class="sidebarMenu-item sidebar-tabs {{ request()->component == 'class_stats' ? 'active' : '' }}">
                    <a href="javascript:void(0)" id="class_stats-tab" data-bs-toggle="tab"
                        data-bs-target="#class_stats" data-component="class_stats" role="tab"
                        aria-controls="class_stats" aria-selected="false">
                        <div class="py-3 px-4">
                            <span class="me-4"><img src="/images/presentation.svg" alt="home"></span><span
                                class="text-med">Class Stats</span>
                        </div>
                    </a>

                </li>

                <li class="sidebarMenu-item sidebar-tabs {{ request()->component == 'schedule' ? 'active' : '' }}">
                    <a href="javascript:void(0)" id="schedule-sidebar-tab" data-bs-toggle="tab"
                        data-bs-target="#schedule" role="tab" aria-controls="schedule" data-component="schedule"
                        aria-selected="true" data-sibling="schedule-tab">
                        <div class="py-3 px-4">
                            <span class="me-4"><img src="/images/vuesax-linear-calendar-edit.svg"
                                    alt="presentation"></span><span class="text-med">Request for MakeUp Class</span>
                        </div>
                    </a>

                </li>
                {{-- <li class="sidebarMenu-item sidebar-tabs" role="presentation">
                    <a href="javascript:void(0)" id="vacation-tab" data-bs-toggle="tab" data-bs-target="#vacation"
                         role="tab" aria-controls="vacation" aria-selected="false">
                        <div class="py-3 px-4">
                            <span class="me-4"><img src="/images/luggage.svg" alt="home"></span><span
                                class="text-med">Vacation Mode</span>
                        </div>
                    </a>

                </li> --}}
            </ul>
        @elseif (auth()->user()->user_type == \App\Classes\Enums\UserTypesEnum::TeacherCoordinator)
            <ul class="sidebar-menu px-0 nav">
                <li
                    class="sidebarMenu-item {{ request()->component == 'teacher' ? 'active' : '' }} {{ is_null(request()->component) ? 'active' : '' }}">
                    <a href="javascript:void(0)" id="teacher-sidebar-tab" data-bs-toggle="tab"
                        data-bs-target="#teacher" role="tab" aria-controls="teacher" aria-selected="false"
                        data-component="teacher" data-sibling="teacher-tab">
                        <div class="py-3 px-4">
                            <span class="me-4"><img src="/images/home.svg" alt="home"></span><span
                                class="text-med">Home</span>
                        </div>
                    </a>

                </li>
                <li class="sidebarMenu-item sidebar-tabs {{ request()->component == 'updates' ? 'active' : '' }}">
                    <a href="javascript:void(0)" id="updates-tab" data-bs-toggle="tab" data-bs-target="#updates"
                        data-component="updates" role="tab" aria-controls="updates" aria-selected="false">
                        <div class="py-3 px-4">
                            <span class="me-4"><img src="/images/presentation.svg" alt="home"></span><span
                                class="text-med">Updates</span>
                        </div>
                    </a>

                </li>
                <li
                    class="sidebarMenu-item sidebar-tabs {{ request()->component == 'schedule_changes' ? 'active' : '' }}">
                    <a href="javascript:void(0)" id="schedule_changes-tab" data-bs-toggle="tab"
                        data-component="schedule_changes" data-bs-target="#schedule_changes" role="tab"
                        aria-controls="schedule_changes" aria-selected="true">
                        <div class="py-3 px-4">
                            <span class="me-4"><img src="/images/vuesax-linear-calendar-edit.svg"
                                    alt="presentation"></span><span class="text-med">MakeUp Classes</span>
                        </div>
                    </a>

                </li>
            </ul>
        @endif
    </div>
</aside>

@push('after-script')
    <script>
        $('.sidebarMenu-item').on('click', function() {
            $('.sidebarMenu-item').removeClass("active");
            $(this).toggleClass("active");
            if (!$(this).hasClass("dropdown")) {
                $('.dropdown').find('.active').removeClass('active');
            }
        })
        $('.nav-collapsable').on('click', function() {
            const parent = $(this).parent().parent();
            parent.toggleClass("collapsed active");
            // parent.find('.submenu-item:first-child > a').click()
            // getComponent( parent.find('.submenu-item:first-child > a').a);
        })
        $('.sidebarMenu-item:not(.dropdown)').on('click', function() {
            $('body').removeClass('show-sidebar')
            $('.js-menu-toggle').removeClass('active')
            $('.sidebarMenu-item').find('.active').removeClass("active");
        })
        $('.submenu-item').on('click', function() {
            $('body').removeClass('show-sidebar')
            $('.js-menu-toggle').removeClass('active')
            $('.sidebar-submenu').find('.active').removeClass("active");
            $(this).toggleClass("active");
        })
    </script>
@endpush
