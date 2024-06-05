<div class="container-xl notifications-tab">
    <h4 class="px-24 text-sb mb-4">{{ __('Notifications') }}</h4>
    <div class="notifications-nav mb-4">
        <ul class="nav top-navs justify-content-sm-start justify-content-center mb-3" id="myTab" role="tablist">
            <li class="nav-item bg-sec active flex-sm-grow-0 border text-center" role="presentation">
                <a class="nav-link active py-2 text-center" id="teachers-tab" data-bs-toggle="tab"
                    data-bs-target="#teachers-notifications" role="tab" aria-controls="teachers-notifications"
                    aria-selected="true">Teachers</a>
            </li>
            <li class="nav-item bg-sec flex-sm-grow-0 border text-center" role="presentation">
                <a class="nav-link py-2 text-center" id="students-tab" data-bs-toggle="tab"
                    data-bs-target="#students-notifications" role="tab" aria-controls="students-notifications"
                    aria-selected=" true"><span>Students</span></a>
            </li>
        </ul>
    </div>
    <div class="row mx-0 flex-sm-row flex-column-reverse mx-0">
        <div class="col-sm-6 col-lg-8 col-12 mt-sm-0 mt-3 ps-sm-0">
            <div class="tab-content" id="tab-content">

                <div class="tab-pane fade show active" id="teachers-notifications" role="tabpanel"
                    aria-labelledby="teachers-tab">
                    <div class="border rounded p-sm-0 mx-auto notifications">
                        <div class="py-4 px-sm-4 px-3 timeline-box">
                            <?php
                            $current = '';
                            ?>
                            {{-- @forelse ($user->notifications as $notification)
                                @if ($current != \Carbon\Carbon::parse($notification->created_at)->toDateString())
                                    <?php $current = \Carbon\Carbon::parse($notification->created_at)->toDateString(); ?>
                                        <h5 class="px-14 fw-bold pb-2 mb-0">{{ $current == \Carbon\Carbon::today()->toDateString()? 'Today': \Carbon\Carbon::parse($current)->format('d M, Y') }}</h5>
                                @endif
                                @include('notifications.'.$notification->type, ['extras' => json_decode(stripslashes($notification->json)), 'timeline' => true])
                            @empty
                                <div class="py-2">
                                <h5 class="px-14 fw-bold py-1 mb-0 text-center">{{ __('No Activity yet!') }}</h5>
                            </div>
                            @endforelse --}}
                            <h5 class="px-14 text-sb pb-3 mt-2 mb-0">TODAY</h5>
                            <div class="px-14 py-3 text-med container px-0">
                                <div class="row">
                                    <div class="col-1 pe-0">
                                        <i class="color-primary fa-circle fa-xs fas" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-11 pe-0 pe-sm-2 ps-1">
                                        <div class="pb-2">Teacher Saad Accepted the rescheduling of his
                                            Student
                                            (Noman Ali Khan)
                                        </div>
                                        <div class="text-muted">
                                            10 Min ago
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="px-14 py-3 text-med container px-0">
                                <div class="row">
                                    <div class="col-1 pe-0">
                                        <i class="color-primary fa-circle fa-xs fas" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-11 pe-0 pe-sm-2 ps-1">
                                        <div class="pb-2">Teacher Asad cancelled his tomorrow's class
                                        </div>
                                        <div class="text-muted">
                                            10 Min ago
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="px-14 py-3 text-med container px-0">
                                <div class="row">
                                    <div class="col-1 pe-0">
                                        <i class="color-primary fa-circle fa-xs fas" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-11 pe-0 pe-sm-2 ps-1">
                                        <div class="pb-2">Teacher Umar Accepted the rescheduling of his
                                            Student
                                            (Qaiser)
                                        </div>
                                        <div class="text-muted">
                                            10 Min ago
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" id="students-notifications" role="tabpanel"
                    aria-labelledby="students-tab">

                    <div class="border rounded p-sm-0 mx-auto notifications">
                        <div class="py-4 px-sm-4 px-3 timeline-box">
                            <?php
                            $current = '';
                            ?>
                            {{-- @forelse ($user->notifications as $notification)
                                @if ($current != \Carbon\Carbon::parse($notification->created_at)->toDateString())
                                    <?php $current = \Carbon\Carbon::parse($notification->created_at)->toDateString(); ?>
                                        <h5 class="px-14 fw-bold pb-2 mb-0">{{ $current == \Carbon\Carbon::today()->toDateString()? 'Today': \Carbon\Carbon::parse($current)->format('d M, Y') }}</h5>
                                @endif
                                @include('notifications.'.$notification->type, ['extras' => json_decode(stripslashes($notification->json)), 'timeline' => true])
                            @empty
                                <div class="py-2">
                                <h5 class="px-14 fw-bold py-1 mb-0 text-center">{{ __('No Activity yet!') }}</h5>
                            </div>
                            @endforelse --}}
                            <h5 class="px-14 text-sb pb-3 mt-2 mb-0">TODAY</h5>
                            <div class="px-14 py-3 text-med container px-0">
                                <div class="row">
                                    <div class="col-1 pe-0">
                                        <i class="color-primary fa-circle fa-xs fas" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-11 pe-0 pe-sm-2 ps-1">
                                        <div class="pb-2">Class rescheduling request of Student Noman Ali Khan
                                            has been approved by the Teacher (Asad)
                                        </div>
                                        <div class="text-muted">
                                            10 Min ago
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="px-14 py-3 text-med container px-0">
                                <div class="row">
                                    <div class="col-1 pe-0">
                                        <i class="color-primary fa-circle fa-xs fas" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-11 pe-0 pe-sm-2 ps-1">
                                        <div class="pb-2">Class of Student Awais has been cancelled.
                                        </div>
                                        <div class="text-muted">
                                            10 Min ago
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="px-14 py-3 text-med container px-0">
                                <div class="row">
                                    <div class="col-1 pe-0">
                                        <i class="color-primary fa-circle fa-xs fas" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-11 pe-0 pe-sm-2 ps-1">
                                        <div class="pb-2">Class rescheduling request of Student Qaiser has
                                            been approved by the Teacher (Umer)
                                        </div>
                                        <div class="text-muted">
                                            10 Min ago
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-sm-6 col-lg-4 col-12 pe-sm-0">
            <div class="shadow p-3 pt-5">
                <h2 class="px-18 text-sb mb-4">{{ __('Select date to see notifications') }}</h2>
                @include('front.customer.components.schedule_calender')
            </div>
        </div>
    </div>
</div>
@push('after-style')
    <style>
        .notifications-tab .notifications-nav .bg-sec.active {
            background-color: var(--secondary-color) !important;
            font-weight: 500;
        }

        .notifications-tab>.notifications {
            border: none !important;
        }

        .notifications-tab>.notifications>div {
            border: 1px solid #dee2e6 !important;
        }

        .notifications-tab .timeline-box {
            border-radius: 10px;
        }

        . @media screen and (max-width: 400px) {
            .notifications-tab .notifications-nav .bg-sec {
                margin: 0 !important;
            }
        }

        @media screen and (max-width: 575px) {
            .notifications-tab .notifications-nav a {
                font-size: var(--px-14) !important;
            }
        }

        @media screen and (min-width:992px) {
            .notifications-tab .notifications .col-11 {
                margin-left: -15px
            }
        }
    </style>
@endpush
@push('after-script')
    <script>
        $('.notifications-nav .nav-link').click(function() {
            $('.notifications-nav .bg-sec').removeClass('active');
            $(this).parent().addClass('active');
        })
    </script>
@endpush
