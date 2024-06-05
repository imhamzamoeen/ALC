{{-- <div class="row">
    <div class="col-sm-4 col-12 me-sm-3 mx-auto d-sm-block d-none">
        <h4 class="px-18 text-sb mb-3 mt-sm-5 mt-0">Today's Classes</h4>
    </div>
    <div class="col-sm-7 col-12 p-sm-0 mx-auto">
        <h4 class="px-18 text-sb mb-3 mt-sm-5 mt-0">Timeline</h4>
    </div>
</div> --}}
<div class="row student_timeline">
    <div class="col-sm-4 col-12 me-sm-3 mx-auto d-sm-block d-none">
        <h4 class="px-18 text-sb mb-3 mt-sm-5 mt-0">Today's Classes</h4>

        <div class="py-4 border px-14 text-med timeline-box">
            <div class="px-3 py-2 active-class">
                <div class="py-1 text-bold">Mon, 23 Aug - 05:00 Pm</div>
                <p class="py-1 mb-0">Tajweed pf Quran</p>
            </div>
            <div class="px-3 py-2">
                <div class="py-1 text-bold">Mon, 23 Aug - 07:00 Pm</div>
                <p class="py-1 mb-0">Tajweed pf Quran</p>
            </div>
        </div>
        <h4 class="px-18 text-sb mb-3 mt-5">Next Classes</h4>
        <div class="border clearfix py-3 px-14 text-med timeline-box">
            <div class="px-3 py-2">
                <div class="py-1 text-bold">Mon, 23 Aug - 07:00 Pm</div>
                <p class="py-1 mb-0">Tajweed pf Quran</p>
            </div>
            <div class="px-3 py-2">
                <div class="py-1 text-bold">Tue, 23 Aug - 07:00 Pm</div>
                <p class="py-1 mb-0">Tajweed pf Quran</p>
            </div>
            <div class="px-3 py-2">
                <div class="py-1 text-bold">Wed, 23 Aug - 07:00 Pm</div>
                <p class="py-1 mb-0">Tajweed pf Quran</p>
            </div>
            <div class="px-3 py-2">
                <div class="py-1 text-bold">Thus, 23 Aug - 07:00 Pm</div>
                <p class="py-1 mb-0">Tajweed pf Quran</p>
            </div>
            <a class="nav nav-item nav-link btn color-primary float-end text-sb" id="view-classes" data-bs-toggle="tab"
                data-bs-target="#schedule" role="tab" aria-controls="schedule" aria-selected="true">View
                All</a>
        </div>
    </div>
    <div class="col-sm-7 col-12 border rounded p-sm-0 mx-auto student-notifications">
        <h4 class="px-18 text-sb mb-3 mt-sm-5 mt-0">Timeline</h4>
        <div class="p-4 timeline-box">
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
            <div class="px-14 py-3 text-med container px-0">
                <div class="row">
                    <div class="col-1 pe-0">
                        <i class="color-primary fa-circle fa-xs fas join-class-notification" aria-hidden="true"></i>
                    </div>
                    <div class="col-11 pe-0 pe-sm-2 ps-1">
                        <div><span>Today Class Link :
                                https://zoom.us/j/97938383521?pwd=ZHRiVGxMOU1sUE8wMGpzaXFOcHJaZz09</span>
                            <div><a target="_blank"
                                    href="https://zoom.us/j/97938383521?pwd=ZHRiVGxMOU1sUE8wMGpzaXFOcHJaZz09"
                                    class="btn btn-primary my-2 px-4 py-2">Join Class</a></div>
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
                        <div class="pb-2">Your Request for MakeUp Class has been approved</div>
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
                        <div class="pb-2">Your Student Requested for a change in class schedule do you agree?
                        </div>
                        <div class="text-muted">
                            10 Min ago
                        </div>
                        <div class="mt-2">
                            <span><a href="javascript:void(0)"
                                    class="btn btn-primary py-2 px-4">Accept</a></span><span><a
                                    href="javascript:void(0)"
                                    class="btn btn-outline-primary py-2 px-4 ms-3">Decline</a></span>
                            {{-- Use Below Code when request is Accepted --}}
                            {{-- <a class="color-primary text-decoration-none text-sb px-12" href="javascript:void(0)">Request Accepted</a> --}}
                        </div>
                    </div>
                </div>

            </div>
            <h5 class="px-14 fw-bold pb-3 mt-4 mb-0">YESTERDAY</h5>
            <div class="px-14 py-3 text-med container px-0">
                <div class="row">
                    <div class="col-1 pe-0">
                        <i class="text-muted fa-circle fa-xs fas" aria-hidden="true"></i>
                    </div>
                    <div class="col-11 pe-0 pe-sm-2 ps-1">
                        <div class="pb-2">Your Request for MakeUp Class has been approved</div>
                        <div class="text-muted">
                            10 Min ago
                        </div>
                    </div>
                </div>

            </div>
            <div class="px-14 py-3 text-med container px-0">
                <div class="row">
                    <div class="col-1 pe-0">
                        <i class="text-muted fa-circle fa-xs fas" aria-hidden="true"></i>
                    </div>
                    <div class="col-11 pe-0 pe-sm-2 ps-1">
                        <div class="pb-2">Your Request for MakeUp Class has been approved</div>
                        <div class="text-muted">
                            10 Min ago
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@push('after-style')
    <style>
        .student_timeline .active-class {
            background-color: var(--secondary-color);
            border-left: 3px solid var(--primary-color);
        }

        .student_timeline>.student-notifications {
            border: none !important;
        }

        .student_timeline>.student-notifications>div {
            border: 1px solid #dee2e6 !important;
        }

        .student_timeline .student-notifications .col-11 {
            margin-left: -15px
        }

        .student_timeline .nav-link {
            font-size: var(--px-14);
        }

        .student_timeline .timeline-box {
            border-radius: 10px;
        }

        @media screen and (max-width:992px) {
            .student_timeline .student-notifications .col-11 {
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
@endpush
