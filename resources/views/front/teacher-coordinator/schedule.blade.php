<div class="container-lg clearfix schedule-tabs">
    <h4 class=" d-sm-none d-block px-18 text-sb pb-2 mb-sm-4 w-100">{{ __('Classes') }}</h4>
    <div class="schedule-nav">
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
    {{-- <div class="d-flex filter-row rounded flex-wrap mb-sm-3">
        <input type="text" class="search-field border-0 px-14 px-4" placeholder="Search..." name="search" id="search"
            class="px-4">
        <div class="dropdown teacherDropdown">
            <button
                class="btn btn-secondary dropdown-toggle border-0 rounded-0 text-dark text-med w-100 px-3 text-start"
                 id="teacherDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Teacher
            </button>
            <ul class="dropdown-menu px-14" aria-labelledby="teacherDropdown" style="">
                <li><a class="dropdown-item" href="#">Teacher</a></li>
                <li><a class="dropdown-item" href="#">Student</a></li>
            </ul>
        </div>
        <div class="dropdown coursesDropdown">
            <button
                class="btn btn-secondary dropdown-toggle border-0 rounded-0 text-dark text-med w-100 px-3 text-start"
                 id="coursesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                All Courses
            </button>
            <ul class="dropdown-menu  px-14" aria-labelledby="coursesDropdown" style="">
                <li><a class="dropdown-item" href="#">Tajweed</a></li>
                <li><a class="dropdown-item" href="#">Hifz</a></li>
                <li><a class="dropdown-item" href="#">Recitation</a></li>
            </ul>
        </div>
        <div class="d-flex align-items-center justify-content-center bg-primary text-light px-18" id="searchIcon">
            <i class="fa-search fa" aria-hidden="true"></i>
        </div>
    </div> --}}

    <div class="tab-content" id="tab-content">
        <div class="tab-pane fade show active" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
            <table class="vertical-table table-borderless Action" id="upcomingClasses-table">
                <thead class="table-header">
                    <tr>
                        <th scope="col" class="ps-2">Day & Time</th>
                        <th scope="col">Teacher Name</th>
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
                        <td data-label="Teacher Name">Haroon Mukhtar</td>
                        <td data-label="Student Name">Noman Ali Khan</td>
                        <td data-label="Course">Tajweed of Quran</td>
                        {{-- <td data-label="Status"><span class="badge status-pill status-primary">Scheduled</span></td> --}}
                        <td data-label="Action">
                            <button class="btn btn-outline-primary py-2 action-btn"
                                data-bs-target="#change_schedule-modal" data-bs-toggle="modal">MakeUp class
                                Request</button>
                        </td>
                    </tr>

                    <tr>
                        <td data-label="Day & Time">
                            <div class="d-flex d-sm-block justify-content-end">
                                <div class="text-sb me-2">Mon 21 Aug</div>
                                <div>07:00 Pm</div>
                            </div>
                        </td>
                        <td data-label="Teacher Name">Haroon Mukhtar</td>
                        <td data-label="Student Name">Fatima Butt</td>
                        <td data-label="Course">Tajweed of Quran</td>
                        {{-- <td data-label="Status"><span class="badge status-pill status-success">Rescheduled</span></td> --}}
                        <td data-label="Action">
                            <button class="btn btn-outline-primary py-2 action-btn"
                                data-bs-target="#change_schedule-modal" data-bs-toggle="modal">MakeUp class
                                Request</button>
                        </td>
                    </tr>
                    <tr>
                        <td data-label="Day & Time">
                            <div class="d-flex d-sm-block justify-content-end">
                                <div class="text-sb me-2">Mon 21 Aug</div>
                                <div>07:00 Pm</div>
                            </div>

                        </td>
                        <td data-label="Teacher Name">Haroon Mukhtar</td>
                        <td data-label="Student Name">Saad Yasin</td>
                        <td data-label="Course">Tajweed of Quran</td>
                        {{-- <td data-label="Status"><span class="badge status-pill status-warning">Cancelled</span></td> --}}
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
                        <td data-label="Teacher Name">Haroon Mukhtar</td>
                        <td data-label="Student Name">Talha Mubashar</td>
                        <td data-label="Course">Tajweed of Quran</td>
                        {{-- <td data-label="Status"><span class="badge status-pill status-primary">Scheduled</span></td> --}}
                        <td data-label="Action">
                            <button class="btn btn-outline-primary py-2 action-btn"
                                data-bs-target="#change_schedule-modal" data-bs-toggle="modal">MakeUp class
                                Request</button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="previous" role="tabpanel" aria-labelledby="previous-tab">
            <table class="vertical-table table-borderless Action" id="previousClasses-table">
                <thead class="table-header">
                    <tr>
                        <th scope="col" class="ps-2">Day & Time</th>
                        <th scope="col">Teacher Name</th>
                        <th scope="col">Student Name</th>
                        <th scope="col">Course</th>
                        <th scope="col">Class Duration</th>
                        <th scope="col">Status</th>
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
                        <td data-label="Teacher Name">Haroon Mukhtar</td>
                        <td data-label="Student Name">Noman Ali Khan</td>
                        <td data-label="Course">Tajweed of Quran</td>
                        <td data-label="Class Duration">30 Minutes</td>
                        <td data-label="Status"><span class="badge status-pill status-success">Attended</span></td>
                    </tr>
                    <tr>
                        <td data-label="Day & Time">
                            <div class="d-flex d-sm-block justify-content-end">
                                <div class="text-sb me-2">Mon 21 Aug</div>
                                <div>07:00 Pm</div>
                            </div>

                        </td>
                        <td data-label="Teacher Name">Haroon Mukhtar</td>
                        <td data-label="Student Name">Saad Yasin</td>
                        <td data-label="Course">Tajweed of Quran</td>
                        <td data-label="Class Duration">-</td>
                        <td data-label="Status"><span class="badge status-pill status-warning">Cancelled</span></td>
                    </tr>
                    <tr>
                        <td data-label="Day & Time">
                            <div class="d-flex d-sm-block justify-content-end">
                                <div class="text-sb me-2">Mon 21 Aug</div>
                                <div>07:00 Pm</div>
                            </div>

                        </td>
                        <td data-label="Teacher Name">Haroon Mukhtar</td>
                        <td data-label="Student Name">Talha Mubashar</td>
                        <td data-label="Course">Tajweed of Quran</td>
                        <td data-label="Class Duration">-</td>
                        <td data-label="Status"><span class="badge status-pill status-danger">Missed</span></td>
                    </tr>

                    <tr>
                        <td data-label="Day & Time">
                            <div class="d-flex d-sm-block justify-content-end">
                                <div class="text-sb me-2">Mon 21 Aug</div>
                                <div>07:00 Pm</div>
                            </div>
                        </td>
                        <td data-label="Teacher Name">Haroon Mukhtar</td>
                        <td data-label="Student Name">Fatima Butt</td>
                        <td data-label="Course">Tajweed of Quran</td>
                        <td data-label="Class Duration">30 Minutes</td>
                        <td data-label="Status"><span class="badge status-pill status-primary">Rescheduled</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="live" role="tabpanel" aria-labelledby="live-tab">
            <table class="vertical-table table-borderless Action liveClass-table" id="todaysClasses-table">
                <thead class="table-header">
                    <tr>
                        <th scope="col" class="ps-2">Day & Time</th>
                        <th scope="col">Teacher Name</th>
                        <th scope="col">Student Name</th>
                        <th scope="col">Course</th>
                        <th scope="col">Attendance</th>
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
                        <td data-label="Teacher Name">Haroon Mukhtar</td>
                        <td data-label="Student Name">Noman Ali khan</td>
                        <td data-label="Course">Tajweed of Quran</td>
                        <td data-label="Attendance">
                            <div class="attendance present"><span></span>Teacher Present</div>
                            <div class="attendance absent"><span></span>Student Absent</div>
                        </td>
                        <td data-label="Action">
                            <a target="_blank" class="btn btn-outline-primary py-2 action-btn"
                                href="https://zoom.us/j/97938383521?pwd=ZHRiVGxMOU1sUE8wMGpzaXFOcHJaZz09">Join
                                Class</a>

                        </td>
                    </tr>
                    <tr>
                        <td data-label="Day & Time">
                            <div class="d-flex d-sm-block justify-content-end">
                                <div class="text-sb me-2">Mon 21 Aug</div>
                                <div>07:00 Pm</div>
                            </div>
                        </td>
                        <td data-label="Teacher Name">Haroon Mukhtar</td>
                        <td data-label="Student Name">Noman Ali khan</td>
                        <td data-label="Course">Tajweed of Quran</td>
                        <td data-label="Attendance">
                            <div class="attendance present"><span></span>Teacher Present</div>
                            <div class="attendance"><span></span>Student Absent</div>
                        </td>
                        <td data-label="Action">
                            <a target="_blank" class="btn btn-outline-primary py-2 action-btn"
                                href="https://zoom.us/j/97938383521?pwd=ZHRiVGxMOU1sUE8wMGpzaXFOcHJaZz09">Join
                                Class</a>

                        </td>
                    </tr>
                    <tr>
                        <td data-label="Day & Time">
                            <div class="d-flex d-sm-block justify-content-end">
                                <div class="text-sb me-2">Mon 21 Aug</div>
                                <div>07:00 Pm</div>
                            </div>

                        </td>
                        <td data-label="Teacher Name">Haroon Mukhtar</td>
                        <td data-label="Student Name">Noman Ali khan</td>
                        <td data-label="Course">Tajweed of Quran</td>
                        <td data-label="Attendance">
                            <div class="attendance present"><span></span>Teacher Present</div>
                            <div class="attendance absent"><span></span>Student Absent</div>
                        </td>
                        <td data-label="Action">
                            <a target="_blank" class="btn btn-outline-primary py-2 action-btn"
                                href="https://zoom.us/j/97938383521?pwd=ZHRiVGxMOU1sUE8wMGpzaXFOcHJaZz09">Join
                                Class</a>

                        </td>
                    </tr>
                    <tr>
                        <td data-label="Day & Time">
                            <div class="d-flex d-sm-block justify-content-end">
                                <div class="text-sb me-2">Mon 21 Aug</div>
                                <div>07:00 Pm</div>
                            </div>

                        </td>
                        <td data-label="Teacher Name">Haroon Mukhtar</td>
                        <td data-label="Student Name">Noman Ali khan</td>
                        <td data-label="Course">Tajweed of Quran</td>
                        <td data-label="Attendance">
                            <div class="attendance present"><span></span>Teacher Present</div>
                            <div class="attendance"><span></span>Student Absent</div>
                        </td>
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
</div>
@push('after-style')
    <style>
        .schedule-tabs .schedule-nav .bg-sec.active {
            background-color: var(--secondary-color) !important;
            font-weight: 500;
        }

        .schedule-tabs .action-btn {
            width: 184px;
            height: 44px;
            padding: 0;
            line-height: 2.1;
        }

        .schedule-tabs .vertical-table .badge {
            max-width: 184px;
        }

        .schedule-tabs .present-btn,
        .schedule-tabs .absent-btn {
            width: 103px;
            height: 44px;
            border: 1px solid #cccaca;
            color: #cccaca;
        }

        .schedule-tabs .present-btn.active {
            background: #559739;
            color: white;
            border: 1px solid #559739;
        }

        .schedule-tabs .absent-btn.active {
            background: #e94235;
            border: 1px solid #e94235;
            color: white !important;
        }

        .schedule-tabs .present-btn {
            border-radius: 2px 0px 0px 2px;

        }

        .schedule-tabs .absent-btn {
            border-radius: 0px 2px 2px 0px;

        }

        .schedule-tabs .present-btn:not(.active),
        .schedule-tabs .absent-btn:not(.active):hover {
            margin: 0 !important;
            color: #cccaca;
        }

        .schedule-tabs .present-btn:focus,
        .schedule-tabs .absent-btn:focus {
            box-shadow: none;
        }

        .schedule-tabs .attendance {
            position: relative;
        }

        .schedule-tabs .attendance>span {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #CCCACA;
            position: absolute;
            left: 30px;
            top: 5px;
        }

        .schedule-tabs .attendance.present {
            color: #559739;
        }

        .schedule-tabs .attendance.absent {
            color: #FF3B3B;
        }

        .schedule-tabs .attendance.present>span {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #559739;
            position: absolute;
            left: 30px;
            top: 5px;
        }

        .schedule-tabs .attendance.absent>span {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #FF3B3B;
            ;
            position: absolute;
            left: 30px;
            top: 5px;
        }

        .schedule-tabs .filter-row {
            height: 50px;
        }

        .schedule-tabs .filter-row>* {}

        .schedule-tabs .filter-row #coursesDropdown,
        .schedule-tabs .filter-row #teacherDropdown {
            background-color: white;
            height: 50px;
        }

        .schedule-tabs .filter-row #coursesDropdown:focus,
        .schedule-tabs .filter-row #teacherDropdown:focus {
            box-shadow: none;
        }

        .schedule-tabs .filter-row>input,
        .schedule-tabs .filter-row>div {
            flex: 1 1 auto;
            box-shadow: 0px 3px 6px #00000029;
        }

        .schedule-tabs .filter-row .search-field {
            width: 50%;
            border-right: 1px solid #00000029 !important;
            outline: 0;
        }

        .schedule-tabs .filter-row .coursesDropdown {
            width: 21%;
            border-left: 1px solid #00000029;
        }

        .schedule-tabs .filter-row .teacherDropdown {
            width: 24%;
            border-left: 1px solid #00000029;
        }

        .schedule-tabs .filter-row #searchIcon {
            width: 5%;
        }

        .schedule-tabs .filter-row .dropdown-toggle::after {
            position: absolute;
            right: 17px;
            top: 22px;
            font-size: 18px;
        }

        .schedule-tabs .filter-row .dropdown-item:hover {
            background-color: var(--secondary-color);
        }

        . @media screen and (max-width: 400px) {
            .schedule-tabs .schedule-nav .bg-sec {
                margin: 0 !important;
            }
        }

        @media screen and (max-width: 575px) {
            .schedule-tabs .schedule-nav a {
                font-size: var(--px-14) !important;
            }

            .coordinator_dashboard li.nav-item {
                width: 33%;
            }

            .coordinator_dashboard .vertical-table td {
                padding: 10px 0 10px 0 !important;
            }

            .schedule-tabs .present-btn,
            .schedule-tabs .absent-btn {
                width: 80px !important;
                height: 37px !important;
            }

            .schedule-tabs .attendance>span {
                right: 120px;
                left: unset !important;
            }

            .schedule-tabs .filter-row {
                margin-bottom: 70px;
            }

            .schedule-tabs .filter-row .search-field {
                height: 50px;
                margin-bottom: 11px;
                border-right: none !important;
                width: 80%;
                order: 3;
            }

            .schedule-tabs .filter-row #searchIcon {
                order: 4;
                width: 20%;
                height: 50px;

            }

            .schedule-tabs .filter-row .teacherDropdown {
                order: 1;
                border-left: none !important;
                width: 50%;
                margin-bottom: 10px;
            }

            .schedule-tabs .filter-row .coursesDropdown {
                order: 2;
                width: 50%;
                margin-bottom: 10px;
            }
        }

        @media screen and (min-width:576px) and (max-width: 767px) {
            .schedule-tabs .action-btn {
                font-size: 10px;
            }

            .schedule-tabs .attendance {
                font-size: 12px;
            }
        }

        @media screen and (min-width:768px) and (max-width: 991px) {
            .schedule-tabs .action-btn {
                font-size: 12px;
            }
        }

        @media screen and (max-width:576px) {
            .schedule-tabs .vertical-table tr:last-child>td:last-child {
                border-bottom: 2px dashed #d3d3d336;

            }
        }

        @media screen and (min-width: 768px) {

            .schedule-tabs .vertical-table:not(.liveClass-table) th:last-child,
            .schedule-tabs .vertical-table:not(.liveClass-table) td:last-child {
                text-align: center !important;
            }
        }

        @media screen and (min-width:576px) and (max-width:991px) {
            .schedule-tabs .action-btn {
                width: 100%;
            }

            .schedule-tabs .present-btn,
            .schedule-tabs .absent-btn {
                width: 48%;
                font-size: 12px;
            }

            .schedule-tabs .status-pill {
                font-size: 12px;
            }

            .schedule-tabs .attendance>span {
                display: none;
            }
        }

        @media screen and (min-width:992px) and (max-width:1399px) {
            .attendance>span {
                left: 5px !important;
            }

        }

        @media screen and (min-width:700px) {
            .schedule-tabs .vertical-table td:first-child {
                text-align: left;
            }

            .coordinator_dashboard li.nav-item {
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
        $(document).ready(function() {
            $('#upcomingClasses-table , #previousClasses-table, #todaysClasses-table').DataTable({
                "columnDefs": [{
                    "orderable": false,
                    "targets": [0, 4]
                }]
            });
            addArrows();
            $(document).on('click', '.paginate_button', function() {
                addArrows()
            });
            $('.dataTables_length select').on('change', function() {
                addArrows()
            })
            styleSearchField();
        })
    </script>
    <script>
        $('.teacher-slots button').on('click', function() {
            $(this).toggleClass('btn-outline-dark');
            $(this).toggleClass('btn-dark active')
        })
    </script>
@endpush
