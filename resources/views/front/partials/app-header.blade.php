<div class="w-100 fixed-top bg-white">
    <div class="container-fluid border-bottom custom-nav">

        <div class="row align-middle ">
            <div class="col-lg-2 col-md-2 col-6 px-5 text-left">
                {{-- <img class="navbar-toggler sidebar_toggle_button" src="{{ asset('images/menu_black.svg') }}"> --}}
                @include('front.partials.sidebar')
            </div>
            <div class="col-lg-2 col-md-2 col-6 pt-4 d-block d-md-none text-right">

                <div class="h-100 d-flex justify-content-end align-items-lg-center mt-0">

                    <div class="position-relative">
                        {{-- <img class="navbar-toggler sidebar_toggle_button" src="{{ asset('images/vuesax-linear-message-notif.svg') }}">
                        <span class=" position-absolute text-center text-light" style="background-color: #F45E76; font-size: 12px;cursor: pointer;border-radius: 50%; width: 18px; height: 18px; right: 5px; top: -5px; bottom:10px;">1</span> --}}
                    </div>
                    <div class="dropdown">
                        <a data-toggle="dropdown" class="text-decoration-none" href="javascript:void(0);"
                            id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                {!! generate_profile_picture_by_name(Auth::user()->name, 50) !!}
                            @else
                                <img src="{{ asset('images/user-image.svg') }}" />
                            @endif

                        </a>
                        <ul class="dropdown-menu px-14" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">{{ auth()->user()->name }}</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 pt-4 pt-sm-0 pt-md-2 text-center">
                @if (auth()->user()->user_type == \App\Classes\Enums\UserTypesEnum::SalesSupport)
                    <ul class="nav top-navs justify-content-center" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active border-custom-bottom py-md-4 text-med" id="unscheduled-tab"
                                data-bs-toggle="tab" data-bs-target="#unscheduled" role="tab"
                                aria-controls="unscheduled" aria-selected="true">Unscheduled <span
                                    class=" d-none d-sm-inline">Trial</span></a>
                        </li>
                        {{-- <li class="nav-item" role="presentation">
                            <a class="nav-link border-custom-bottom py-md-4 text-med" id="pending-tab"
                                data-bs-toggle="tab" data-bs-target="#pending"  role="tab"
                                aria-controls="pending" aria-selected="true">Pending <span
                                    class=" d-none d-sm-inline">Trial</span></a>
                        </li> --}}
                        <li class="nav-item" role="presentation">
                            <a class="nav-link border-custom-bottom py-md-4 text-med" id="scheduled-tab"
                                data-bs-toggle="tab" data-bs-target="#unscheduled" role="tab"
                                aria-controls="unscheduled" aria-selected="true">Scheduled <span
                                    class=" d-none d-sm-inline">Trial</span></a>
                        </li>
                    </ul>
                @elseif (auth()->user()->user_type == \App\Classes\Enums\UserTypesEnum::Customer)
                    <ul class="nav top-navs justify-content-center" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ request()->component == 'timeline' ? 'active' : '' ?? 'active' }} {{ is_null(request()->component) ? 'show active' : '' }} border-custom-bottom py-md-4 text-med"
                                id="timeline-tab" data-component="timeline" data-bs-toggle="tab"
                                data-bs-target="#timeline" role="tab" aria-controls="timeline"
                                data-sibling="timeline-sidebar-tab" aria-selected="true">Timeline</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link border-custom-bottom py-md-4 text-med {{ request()->component == 'class_schedule' ? 'active' : '' }}"
                                id="class_schedule-tab" data-component="class_schedule" data-bs-toggle="tab"
                                data-bs-target="#class_schedule" role="tab" aria-controls="class_schedule"
                                data-sibling="schedule-sidebar-tab" aria-selected="true"><span
                                    class="d-sm-inline d-none">Class</span> <span>
                                    Schedule</span></a>
                        </li>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link border-custom-bottom py-md-4 text-med {{ request()->component == 'helping_material' ? 'active' : '' }}"
                                id="helping_material-tab" data-component="helping_material" data-bs-toggle="tab"
                                data-bs-target="#helping_material" role="tab" aria-controls="helping_material"
                                aria-selected="true"><span class="d-sm-inline d-none">Helping Material</span><span
                                    class="d-sm-none d-inline">Notes</span> </a>
                        </li>
                    </ul>
                    </ul>
                @elseif (auth()->user()->user_type == \App\Classes\Enums\UserTypesEnum::TeacherCoordinator)
                    <ul class="nav top-navs justify-content-center" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link  border-custom-bottom py-md-4 text-med {{ request()->component == 'teacher' ? 'active' : '' }} {{ is_null(request()->component) ? 'show active' : '' }}"
                                id="teacher-tab" data-component="teacher" data-bs-toggle="tab" data-bs-target="#teacher"
                                role="tab" aria-controls="teacher" aria-selected="true">Teachers</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link border-custom-bottom py-md-4 text-med {{ request()->component == 'schedule' ? 'active' : '' }}"
                                id="schedule-tab" data-bs-toggle="tab" data-bs-target="#schedule" role="tab"
                                data-component="schedule" aria-controls="schedule" aria-selected="true"><span
                                    class="d-sm-inline d-none">Class</span> <span> Schedule</span></a>
                        </li>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link border-custom-bottom py-md-4 text-med {{ request()->component == 'library' ? 'active' : '' }}"
                                id="library-tab" data-bs-toggle="tab" data-bs-target="#library" role="tab"
                                data-component="library" aria-controls="library" aria-selected="true"><span
                                    class="d-sm-inline d-none">Shared</span> <span> Library</span></a>
                        </li>
                    </ul>
                @elseif (auth()->user()->user_type == \App\Classes\Enums\UserTypesEnum::Teacher)
                    <ul class="nav top-navs justify-content-center" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link  border-custom-bottom py-md-4 text-med {{ request()->component == 'timeline' ? 'active' : '' }} {{ is_null(request()->component) ? 'show active' : '' }}"
                                id="timeline-tab" data-component="timeline" data-bs-toggle="tab"
                                data-bs-target="#timeline" role="tab" aria-controls="timeline"
                                data-sibling="timeline-sidebar-tab" aria-selected="true">Timeline</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link border-custom-bottom py-md-4 text-med {{ request()->component == 'schedule' ? 'active' : '' }}"
                                id="schedule-tab" data-component="schedule" data-bs-toggle="tab"
                                data-bs-target="#schedule" role="tab" aria-controls="schedule"
                                data-sibling="schedule-sidebar-tab" aria-selected="true"><span
                                    class="d-sm-inline d-none">Class</span> <span>
                                    Schedule</span></a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link border-custom-bottom py-md-4 text-med {{ request()->component == 'students' ? 'active' : '' }}"
                                id="students-tab" data-component="students" data-bs-toggle="tab"
                                data-bs-target="#students" role="tab" aria-controls="students"
                                aria-selected="true"><span>Students</span></a>
                        </li>
                    </ul>
                @endif
            </div>
            <div class="col-lg-2 col-md-2 px-5 pt-lg-0 pt-md-3 d-none d-md-block text-right">
                <div class="h-100 d-flex justify-content-end align-items-lg-center mt-1 ">
                    {{-- <div class="position-relative me-3">
                        @if (auth()->user()->user_type == \App\Classes\Enums\UserTypesEnum::Customer)
                            <img class="navbar-toggler sidebar_toggle_button"
                                src="{{ asset('images/vuesax-linear-message-notif.svg') }}">
                            <span class=" position-absolute text-center text-light"
                                style="background-color: #F45E76; font-size: 12px; border-radius: 50%;cursor: pointer;width: 18px; height: 18px; right: 5px; top: -5px; bottom:10px;">1</span>
                        @endif
                    </div> --}}
                    <div class="dropdown mb-1">
                        <a data-toggle="dropdown" class="text-decoration-none" href="javascript:void(0);"
                            id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                {!! generate_profile_picture_by_name(Auth::user()->name, 50) !!}
                            @else
                                <img src="{{ asset('images/user-image.svg') }}" />
                            @endif
                        </a>
                        <ul class="dropdown-menu px-14" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">{{ auth()->user()->name }}</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br>
<br>
<br>
@push('after-script')
    <script>
        $(document).ready(function() {
            $('.sidebar_toggle_button').click(function() {
                $('#sidebar-toggle').slideToggle(500);
                $('#sidebar-toggle').css('transition', '0.5s');
                $('#sidebar-toggle').animate({
                    '100%': 'toggle'
                });
                $('#sidebar-toggle').animate({
                    width: 'toggle'
                });
            });
        });

        // synchronize sidebar tabs with app header
        $('#myTab a').on('click', function() {
            $('.sidebar-menu .active').removeClass('active');
            const id = $(this).attr('id');
            $('.sidebar-menu a[data-sibling=' + id + ']').parent().addClass('active');
        })
        $('.sidebar-menu a').on('click', function() {
            $('#myTab .active').removeClass('active');
            const id = $(this).attr('id');
            setTimeout(() => {
                $('#myTab a[data-sibling=' + id + ']').addClass('active');
            });
        })
        // $('#timeline-sidebar-tab').on('click', function() {
        //     $('#myTab').find('.active').removeClass('active')

        //     $('#timeline-tab').addClass('active')
        // })
        $(document).on('click', '#view-classes', function() {
            $('#myTab .active').removeClass('active');
            const target = $(this).data('bs-target');
            setTimeout(() => {
                $(target + '-tab').addClass('active')
                $('#view-classes').removeClass('active');
            });
        })
    </script>
@endpush
