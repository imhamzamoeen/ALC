<div class="row teacher_timeline">
    <div class="col-md-4 col-12">
        <h4 class="px-18 text-sb mb-3 mt-md-2 mt-4">{{ __('Class Schedule') }}</h4>
        <div class="border text-med timeline-box">
            <ul class="nav top-navs text-center" id="classSchedule-tabs" role="tablist">
                <li class="nav-item w-50" role="presentation">
                    <a class="nav-link  border-custom-bottom py-md-3 text-med active" id="todays-tab"
                        data-bs-toggle="tab" data-bs-target="#todays" role="tab" aria-controls="todays"
                        aria-selected="true">Today</a>
                </li>
                <li class="nav-item w-50" role="presentation">
                    <a class="nav-link border-custom-bottom py-md-3 text-med" id="upcomings-tab" data-bs-toggle="tab"
                        data-bs-target="#upcomings" role="tab" aria-controls="upcomings"
                        aria-selected="true">Upcoming</a>
                </li>
            </ul>
            <div class="tab-content mt-3" id="classScheduleTab-content">
                <div class="tab-pane fade show active mb-3" id="todays" role="tabpanel" aria-labelledby="todays-tab">
                    @isset($todayClasses)
                        @forelse($todayClasses as $class)
                            <div class="class px-3 py-2 @if ($class->live_status == 1) live @endif">
                                <div class="d-flex justify-content-between align-items-center py-3">
                                    <p class="mb-0 text-sb">{{ $class->Student->course->title }}</p>
                                    @if ($class->live_status == 1)
                                        <a href="{{ route('joinClass', [app()->getLocale(), 'user' => $model, 'WeeklyClass' => $class->session_key]) }}"
                                            target="_blank" class="btn btn-primary px-3 py-2">Join Class</a>
                                    @endif
                                </div>
                                <hr class="my-0">

                                <div class="d-flex align-items-center py-3">
                                    {!! generate_profile_picture_by_name($class->Student->name, 24, 12) !!}
                                    <p class="ms-2 px-14 text-sb mb-0">{{ $class->Student->name }}</p>
                                </div>
                                <hr class="my-0">
                                <div class="d-flex px-12 pt-3">
                                    <div class="w-50 d-flex align-items-center border-end">
                                        <i class="fa fa-clock text-muted ms-4" aria-hidden="true"></i>
                                        <div class="ms-2">
                                            <div class="text-muted lh-1 time-heading">
                                                Time
                                            </div>
                                            <div class="text-sb">
                                                {{ $class->class_time->format('h:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-50 d-flex align-items-center">
                                        <i class="fa fa-clock text-muted ms-4" aria-hidden="true"></i>
                                        <div class="ms-2">
                                            <div class="text-muted lh-1 time-heading">
                                                Date
                                            </div>
                                            <div class="text-sb">
                                                {{ $class->class_time->format('D, d M') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>

                                </div>
                            </div>
                        @empty
                            <div class="px-3 py-2">
                                <div class="py-1 text-bold">{{ __('No Classes Today!') }}</div>
                            </div>
                        @endforelse
                    @else
                        <div class="px-3 py-2 text-center">
                            <div class="py-1 text-bold">{{ __('No Classes Today!') }}</div>
                        </div>
                    @endisset
                </div>
                <div class="tab-pane fade mb-3" id="upcomings" role="tabpanel" aria-labelledby="upcomings-tab">
                    @isset($nextClasses)
                        @foreach ($nextClasses as $class)
                            @if ($loop->iteration < 5)
                                <div class="class px-3 py-2">
                                    <div class="py-3">
                                        <p class="mb-0 text-sb">{{ $class->Student->course->title }}</p>
                                    </div>
                                    <hr class="my-0">

                                    <div class="d-flex align-items-center py-3">
                                        {!! generate_profile_picture_by_name($class->Student->name, 24, 12) !!}
                                        <p class="ms-2 px-14 text-sb mb-0">{{ $class->Student->name }}</p>
                                    </div>
                                    <hr class="my-0">
                                    <div class="d-flex px-12 pt-3">
                                        <div class="w-50 d-flex align-items-center border-end">
                                            <i class="fa fa-clock text-muted ms-4" aria-hidden="true"></i>
                                            <div class="ms-2">
                                                <div class="text-muted lh-1 time-heading">
                                                    Time
                                                </div>
                                                <div class="text-sb">
                                                    {{ $class->class_time->format('h:i A') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-50 d-flex align-items-center">
                                            <i class="fa fa-clock text-muted ms-4" aria-hidden="true"></i>
                                            <div class="ms-2">
                                                <div class="text-muted lh-1 time-heading">
                                                    Date
                                                </div>
                                                <div class="text-sb">
                                                    {{ $class->class_time->format('D, d M') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>

                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <a class="nav nav-item nav-link btn color-primary float-end text-sb" href="javascript:void(0)"
                            id="view-classes" data-bs-toggle="tab" data-component="schedule" data-bs-target="#schedule"
                            role="tab" aria-controls="schedule" aria-selected="true">
                            View All
                        </a>
                    @else
                        <div class="px-3 py-2 text-center">
                            <div class="py-1 text-bold">{{ __('No Upcoming Classes!') }}</div>
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-12 border rounded teacher-notifications">
        <h4 class="px-18 text-sb mb-3 mt-md-2 mt-3 mt-0">{{ __('Timeline') }}</h4>
        <div class="p-4 timeline-box">
            @isset($liveClass)
                @if (!empty($liveClass))
                    <h5 class="px-14 fw-bold pb-2 mb-0">
                        <div class="spinner-grow spinner-grow-sm color-primary me-2" role="status">
                        </div>{{ __('Live Class') }}
                    </h5>
                    @foreach ($liveClass as $class)
                        <div class="px-14 pb-3 text-med container px-0">
                            <div class="live py-2">
                                <div class="mx-3 pe-0 pe-md-2 ps-1">
                                    <div>
                                        <span>
                                            <p class="mb-0">
                                                {{ ucfirst($class['student']['course']['title']) . '`s ' . ' class with Student ' . ucfirst($class['student']['name']) . ' has just begun. here is the live class link:' }}
                                            </p>

                                            {{-- {{ $liveClass->class_link }}</p> --}}
                                        </span>
                                        <span>
                                            <a href="{{ route('joinClass', [app()->getLocale(), 'user' => $model, 'WeeklyClass' => $class['session_key']]) }}"
                                                target="_blank" class="btn btn-primary px-3 py-2">Join Class</a>
                                        </span>
                                    </div>
                                    <div class="text-muted">
                                        {{ $class['class_time']->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endisset

            <?php
            $current = '';
            ?>
            @forelse ($model->notifications as $notification)
                @if ($current != \Carbon\Carbon::parse($notification->created_at)->toDateString())
                    <?php $current = \Carbon\Carbon::parse($notification->created_at)->toDateString(); ?>
                    <h5 class="px-14 fw-bold pb-2 mb-0">
                        {{ $current == \Carbon\Carbon::today()->toDateString()
                            ? 'Today'
                            : \Carbon\Carbon::parse($current)->format('d M, Y') }}
                    </h5>
                @endif
                @include('notifications.' . $notification->type, ['$notification' => $notification])
            @empty
                <div class="py-2">
                    <h5 class="px-14 fw-bold py-1 mb-0 text-center">{{ __('No Activity yet!') }}</h5>
                </div>
            @endforelse




        </div>
    </div>

    {{-- <div class="d-flex justify-content-center justify-content-sm-start">
    <button class="btn btn-outline-primary px-5 py-2 mt-5" id="back-btn">Back</button>
</div> --}}
    {{-- TIMELINE CSS --}}
    <style>
        .teacher_timeline .live {
            background-color: rgba(81, 152, 114, 0.1);
            border-left: 3px solid var(--primary-color);
            margin-top: 10px;
        }

        .teacher_timeline .class:not(:first-child) {
            margin-top: 30px;
        }

        .tab-pane#todays,
        .tab-pane#upcomings {
            max-height: 550px;
            overflow-y: auto;
        }

        .teacher_timeline>.teacher-notifications {
            border: none !important;
        }

        .teacher_timeline>.teacher-notifications>div {
            border: 1px solid #DEE2E6 !important;
        }

        .teacher_timeline .teacher-notifications .col-11 {
            margin-left: -15px
        }

        .teacher_timeline .class hr {
            height: 1px;
            border-top: 1px solid #d5dbe1;
        }

        .teacher-notifications .timeline-box {
            max-height: 650px;
            overflow-y: auto;
        }

        .teacher_timeline #view-classes {
            font-size: var(--px-14);
        }

        .teacher_timeline .time-heading {
            color: #ABB0BC;
            font-weight: 300;
        }

        .teacher_timeline #view-classes:focus {
            box-shadow: none;
        }

        .teacher_timeline .timeline-box {
            border-radius: 10px;
        }

        @media screen and (max-width:992px) {
            .teacher_timeline .teacher-notifications .col-11 {
                margin-left: 0;
                padding-right: 0 !important;
            }
        }

        @media screen and (min-width:756px) and (max-width:991px) {
            .join-class-notification {
                margin-top: 20px;
            }
        }

        @media screen and (min-width:992px) {
            .join-class-notification {
                margin-top: 12px;
            }
        }
    </style>

    <script src="{{ asset('js/RescheduleRequest/index.js') }}"></script>
