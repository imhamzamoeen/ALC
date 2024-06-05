<div class="container-lg clearfix schedule-tabs">
    <div class="schedule-nav mb-sm-4">
        <h4 class="px-18 text-sb pb-2 d-sm-none d-block">{{ __('Classes') }}</h4>

        <ul class="nav top-navs justify-content-sm-start justify-content-center mb-3" id="myTab" role="tablist">
            <li class="nav-item bg-sec active flex-sm-grow-0 border text-center" role="presentation">
                <a class="nav-link active py-2 text-center" id="upcoming-tab" data-bs-toggle="tab"
                    data-bs-target="#upcoming" role="tab" aria-controls="upcoming" aria-selected="true">Upcoming
                    <span class="d-sm-inline d-none">Classes</span></a>
            </li>
            <li class="nav-item bg-sec flex-sm-grow-0 border text-center" role="presentation">
                <a class="nav-link py-2 text-center" id="previous-tab" data-bs-toggle="tab" data-bs-target="#previous"
                    role="tab" aria-controls="previous" aria-selected="true"><span>Previous </span> <span
                        class="d-sm-inline d-none">Classes</span></a>
            </li>
            <li class="nav-item bg-sec flex-sm-grow-0 border text-center" role="presentation">
                <a class="nav-link py-2 text-center" id="live-tab" data-bs-toggle="tab" data-bs-target="#live"
                    role="tab" aria-controls="live" aria-selected="true"><span>Live
                    </span><span class="d-sm-inline d-none">Classes</span> </a>
            </li>
        </ul>
    </div>
    <div class="tab-content" id="tab-content">
        <div class="tab-pane fade show active" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
            <table class="vertical-table table-borderless Action">
                <thead class="table-header">
                    <tr>
                        <th scope="col" class="ps-2">Day & Time</th>
                        <th scope="col">Student Name</th>
                        <th scope="col">Course</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="pe-2">Action</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td data-label="Day & Time">
                            <div class="d-flex d-sm-block justify-content-end">
                                <div class="text-sb me-2">Mon 21 Aug</div>
                                <div>07:00 Pm</div>
                            </div>
                        </td>
                        <td data-label="Student Name">Noman Ali Khan</td>
                        <td data-label="Course">Tajweed of Quran</td>
                        <td data-label="Status"><span class="badge status-pill status-primary">Scheduled</span></td>
                        <td data-label="Action">
                            <button class="btn btn-outline-primary py-2 action-btn"
                                data-bs-target="#change_schedule-modal" data-bs-toggle="modal">Request For
                                Reschedule</button>
                        </td>
                    </tr>

                    <tr>
                        <td data-label="Day & Time">
                            <div class="d-flex d-sm-block justify-content-end">
                                <div class="text-sb me-2">Mon 21 Aug</div>
                                <div>07:00 Pm</div>
                            </div>
                        </td>
                        <td data-label="Student Name">Fatima Butt</td>
                        <td data-label="Course">Tajweed of Quran</td>
                        <td data-label="Status"><span class="badge status-pill status-success">Rescheduled</span></td>
                        <td data-label="Action">
                            <button class="btn btn-outline-primary py-2 action-btn"
                                data-bs-target="#change_schedule-modal" data-bs-toggle="modal">Request For
                                Reschedule</button>
                        </td>
                    </tr>
                    <tr>
                        <td data-label="Day & Time">
                            <div class="d-flex d-sm-block justify-content-end">
                                <div class="text-sb me-2">Mon 21 Aug</div>
                                <div>07:00 Pm</div>
                            </div>

                        </td>
                        <td data-label="Student Name">Saad Yasin</td>
                        <td data-label="Course">Tajweed of Quran</td>
                        <td data-label="Status"><span class="badge status-pill status-warning">Cancelled</span></td>
                        <td data-label="Action">
                            -
                        </td>
                    </tr>
                    <tr>
                        <td data-label="Day & Time">
                            <div class="d-flex d-sm-block justify-content-end">
                                <div class="text-sb me-2">Mon 21 Aug</div>
                                <div>07:00 Pm</div>
                            </div>

                        </td>
                        <td data-label="Student Name">Talha Mubashar</td>
                        <td data-label="Course">Tajweed of Quran</td>
                        <td data-label="Status"><span class="badge status-pill status-primary">Scheduled</span></td>
                        <td data-label="Action">
                            <button class="btn btn-outline-primary py-2 action-btn"
                                data-bs-target="#change_schedule-modal" data-bs-toggle="modal">Request For
                                Reschedule</button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="previous" role="tabpanel" aria-labelledby="previous-tab">
            <table class="vertical-table table-borderless Action">
                <thead class="table-header">
                    <tr>
                        <th scope="col" class="ps-2">Day & Time</th>
                        <th scope="col">Student Name</th>
                        <th scope="col">Course</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="pe-2">Action</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td data-label="Day & Time">
                            <div class="d-flex d-sm-block justify-content-end">
                                <div class="text-sb me-2">Mon 21 Aug</div>
                                <div>07:00 Pm</div>
                            </div>

                        </td>
                        <td data-label="Student Name">Noman Ali Khan</td>
                        <td data-label="Course">Tajweed of Quran</td>
                        <td data-label="Status"><span class="badge status-pill status-success">Attended</span></td>
                        <td data-label="Action">
                            -
                        </td>
                    </tr>
                    <tr>
                        <td data-label="Day & Time">
                            <div class="d-flex d-sm-block justify-content-end">
                                <div class="text-sb me-2">Mon 21 Aug</div>
                                <div>07:00 Pm</div>
                            </div>
                        </td>
                        <td data-label="Student Name">Saad Yasin</td>
                        <td data-label="Course">Tajweed of Quran</td>
                        <td data-label="Status"><span class="badge status-pill status-warning">Cancelled</span></td>
                        <td data-label="Action">
                            -
                        </td>
                    </tr>
                    <tr>
                        <td data-label="Day & Time">
                            <div class="d-flex d-sm-block justify-content-end">
                                <div class="text-sb me-2">Mon 21 Aug</div>
                                <div>07:00 Pm</div>
                            </div>

                        </td>
                        <td data-label="Student Name">Talha Mubashar</td>
                        <td data-label="Course">Tajweed of Quran</td>
                        <td data-label="Status"><span class="badge status-pill status-danger">Missed</span></td>
                        <td data-label="Action">
                            <button class="btn btn-outline-primary py-2 action-btn"
                                data-bs-target="#change_schedule-modal" data-bs-toggle="modal">Request For
                                Makeup</button>
                        </td>
                    </tr>

                    <tr>
                        <td data-label="Day & Time">
                            <div class="d-flex d-sm-block justify-content-end">
                                <div class="text-sb me-2">Mon 21 Aug</div>
                                <div>07:00 Pm</div>
                            </div>
                        </td>
                        <td data-label="Student Name">Fatima Butt</td>
                        <td data-label="Course">Tajweed of Quran</td>
                        <td data-label="Status"><span class="badge status-pill status-primary">Rescheduled</span></td>
                        <td data-label="Action">
                            -
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="live" role="tabpanel" aria-labelledby="live-tab">
            <table class="vertical-table table-borderless Action liveClass-table">
                <thead class="table-header">
                    <tr>
                        <th scope="col" class="ps-2">Day & Time</th>
                        <th scope="col">Student Name</th>
                        <th scope="col">Course</th>
                        {{-- <th scope="col">Status</th> --}}
                        <th scope="col" class="pe-2">Action</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td data-label="Day & Time">
                            <div class="d-flex d-sm-block justify-content-end">
                                <div class="text-sb me-2">Mon 21 Aug</div>
                                <div>07:00 Pm</div>
                            </div>
                        </td>
                        <td data-label="Student Name">Noman Ali khan</td>
                        <td data-label="Course">Tajweed of Quran</td>
                        {{-- <td data-label="Status" class="d-flex d-sm-block justify-content-between align-items-center">
                            <div class="px-14 d-flex justify-content-center">
                                <button class="btn present-btn"><span class="d-md-inline d-none">Present</span><span
                                        class="d-md-none d-inline">P</span></button>
                                <button class="btn absent-btn"><span class="d-md-inline d-none">Absent</span><span
                                        class="d-md-none d-inline">A</span></button>
                            </div>
                        </td> --}}
                        <td data-label="Action">
                            <a target="_blank" class="btn btn-outline-primary py-2 action-btn"
                                href="https://zoom.us/j/97938383521?pwd=ZHRiVGxMOU1sUE8wMGpzaXFOcHJaZz09">Join
                                Class</a>

                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
    {{-- @include('front.customer.components.change_schedule_modal') --}}
    {{-- <button class="btn btn-outline-primary float-end px-5 py-2 mt-sm-5 my-3" onclick="location.href = '/en/customer/profile';"><i class="fa fa-arrow-left me-1"></i> Back</button> --}}
</div>
@push('after-style')
    <style>
        .schedule-nav .bg-sec.active {
            background-color: var(--secondary-color) !important;
            font-weight: 500;
        }

        .action-btn {
            width: 184px;
            height: 44px;
            padding: 0;
            line-height: 2.1;
        }

        .vertical-table .badge {
            max-width: 184px;
        }

        .present-btn,
        .absent-btn {
            width: 103px;
            height: 44px;
            border: 1px solid #cccaca;
            color: #cccaca;
        }

        .present-btn.active {
            background: #559739;
            color: white;
            border: 1px solid #559739;
        }

        .absent-btn.active {
            background: #e94235;
            border: 1px solid #e94235;
            color: white !important;
        }

        .present-btn {
            border-radius: 2px 0px 0px 2px;

        }

        .absent-btn {
            border-radius: 0px 2px 2px 0px;

        }

        .present-btn:not(.active),
        .absent-btn:not(.active):hover {
            margin: 0 !important;
            color: #cccaca;
        }

        .present-btn:focus,
        .absent-btn:focus {
            box-shadow: none;
        }

        @media screen and (max-width: 400px) {
            .schedule-nav .bg-sec {
                margin: 0 !important;
            }
        }

        @media screen and (max-width: 575px) {
            .schedule-nav a {
                font-size: var(--px-14) !important;
            }

            .teacher_dashboard li.nav-item {
                width: 33%;
            }

            .teacher_dashboard .vertical-table td {
                padding: 10px 0 10px 0 !important;
            }

            .present-btn,
            .absent-btn {
                width: 80px !important;
                height: 37px !important;
            }
        }

        @media screen and (min-width:576px) and (max-width: 767px) {
            .action-btn {
                font-size: 10px;
            }
        }

        @media screen and (min-width:768px) and (max-width: 991px) {
            .action-btn {
                font-size: 12px;
            }
        }

        @media screen and (max-width:576px) {
            .schedule-tabs .vertical-table tr:last-child>td:last-child {
                border-bottom: 2px dashed #d3d3d336;

            }
        }

        @media screen and (min-width: 768px) {

            .vertical-table:not(.liveClass-table) th:last-child,
            .vertical-table:not(.liveClass-table) td:last-child {
                text-align: center !important;
            }
        }

        @media screen and (min-width:576px) and (max-width:991px) {
            .action-btn {
                width: 100%;
            }

            .present-btn,
            .absent-btn {
                width: 48%;
                font-size: 12px;
            }
        }

        @media screen and (min-width:700px) {
            .vertical-table td:first-child {
                text-align: left;
            }

            .teacher_dashboard li.nav-item {
                width: 216px;
            }
        }
    </style>
@endpush
@push('after-script')
    <script>
        $('.schedule-nav .nav-link').click(function() {
            $('.schedule-nav .bg-sec').removeClass('active');
            $(this).parent().addClass('active');
        })
        $('.absent-btn, .present-btn').click(function() {
            $('.absent-btn, .present-btn').removeClass('active');
            $(this).addClass('active');
            if ($(this).hasClass('present-btn')) {
                $('#coursesDropdown, .time-slot, .timetable-days h5').removeClass('disabled');
            } else {
                $('#coursesDropdown, .time-slot, .timetable-days h5').addClass('disabled');
            }
        })
    </script>
    <script>
        $('.teacher-slots button').on('click', function() {
            $(this).toggleClass('btn-outline-dark');
            $(this).toggleClass('btn-dark active')
        })
    </script>
@endpush
