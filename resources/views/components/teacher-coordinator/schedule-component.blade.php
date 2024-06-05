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


    <div class="tab-content" id="tab-content">
        <div class="tab-pane fade show active" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
            <table class="vertical-table table-borderless Action" id="upcomingClasses-table">
                <thead class="table-header">
                    <tr>
                        <th scope="col" class="ps-2">Day & Time</th>
                        <th scope="col">Teacher Name</th>
                        <th scope="col">Student Name</th>
                        <th scope="col">Student Reg No</th>

                        <th scope="col">Course</th>
                        {{-- <th scope="col">Status</th> --}}
                        <th scope="col" class="pe-2">Action</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($nextClasses as $class)
                        <tr>
                            <td data-label="Day & Time">
                                <div class="d-flex d-sm-block justify-content-end">
                                    <div class="text-sb me-2">{{ $class->class_time->format('D d M') }}</div>
                                    <div>{{ $class->class_time->format('h:i A') }}</div>
                                </div>

                            </td>
                            <td data-label="Teacher Name">{{ $class->teacher_name }}</td>
                            <td data-label="Student Name">{{ $class->student->name }}</td>
                            <td data-label="Student Reg">{{ $class->student->reg_no }}</td>

                            <td data-label="Course">{{ $class->student->course->title }}</td>

                            <td data-label="Action">
                                <button class="btn btn-outline-primary py-2 action-btn"
                                    data-weeklyclassid="{{ $class->id }}" data-studentid="{{ $class->student_id }}"
                                    data-teacherid={{ $class->teacher_id }} data-action="reschedule"
                                    data-bs-target="#change_schedule_modal" data-bs-toggle="modal">Change
                                    Schedule</button>
                            </td>
                        </tr>
                    @empty
                    @endforelse
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
                        <th scope="col">Student Reg No</th>


                        <th scope="col">Course</th>
                        <th scope="col">Class Duration</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="pe-2">Action</th>


                    </tr>
                </thead>
                <tbody>

                    @forelse ($previousClasses as $class)
                        <tr>
                            <td data-label="Day & Time">
                                <div class="d-flex d-sm-block justify-content-end">
                                    <div class="text-sb me-2">{{ $class->class_time->format('D d M') }}</div>
                                    <div>{{ $class->class_time->format('h:i A') }}</div>
                                </div>

                            </td>
                            <td data-label="Teacher Name">{{ $class->teacher_name }}</td>
                            <td data-label="Student Name">{{ $class->student->name }}</td>
                            <td data-label="Student Reg">{{ $class->student->reg_no }}</td>


                        <td data-label="Course">{{ $class->student->course->title }}</td>
                        <td data-label="Class Duration">{{ $class->class_duration }}</td>
                        <td data-label="Status"><span class="badge status-pill status-success">{{ $class->status
                                }}</span>
                        </td>

                            <td data-label="Action">
                                @if ($class->status == \App\Classes\Enums\StatusEnum::UNATTENDED)
                                    <button class="btn btn-outline-primary px-0 py-2 action-btn"
                                        data-bs-target="#change_schedule_modal"
                                        data-weeklyclassid="{{ $class->id }}"
                                        data-studentid="{{ $class->student_id }}"
                                        data-teacherid={{ $class->teacher_id }} data-action="reschedule"
                                        data-bs-toggle="modal">Request for MakeUp</button>
                                @else
                                    <span>--</span>
                                @endif

                            </td>


                        </tr>
                    @empty
                    @endforelse


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
                        <th scope="col">Student Reg No</th>

                        <th scope="col">Course</th>
                        <th scope="col">Attendance</th>
                        {{-- <th scope="col">Status</th> --}}
                        <th scope="col" class="pe-2">Action</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($todayClasses as $class)
                        <tr>
                            <td data-label="Day & Time">
                                <div class="d-flex d-sm-block justify-content-end">
                                    <div class="text-sb me-2">{{ $class->class_time->format('D d M') }}</div>
                                    <div>{{ $class->class_time->format('h:i A') }}</div>
                                </div>

                            </td>
                            <td data-label="Teacher Name">{{ $class->teacher_name }}</td>
                            <td data-label="Student Name">{{ $class->student->name }}</td>
                            <td data-label="Student Reg">{{ $class->student->reg_no }}</td>

                            <td data-label="Course">{{ $class->student->course->title }}</td>
                            <td data-label="Attendance">
                                <div class="attendance {{ $class->teacher_status }} ps-3"><span></span>Teacher
                                    {{ $class->teacher_status }}</div>
                                <div class="attendance {{ $class->student_status }} ps-3"><span></span>Student
                                    {{ $class->student_status }}</div>
                            </td>
                            <td data-label="Action">
                                <a href="{{ route('joinClass', [app()->getLocale(), 'user' => $model, 'WeeklyClass' => $class->session_key]) }}"
                                    target="_blank" class="btn btn-primary px-3 py-2">Join Class</a>
                                {{-- <a target="_blank" class="btn btn-outline-primary py-2 action-btn"
                                href="{{ $class->class_link }}">Join Class</a> --}}

                            </td>


                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Reschedule Class Modal -->
<div class="modal fade change_schedule_modal" id="change_schedule_modal" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="border-0 modal-content">
            <div class="modal-header pb-0 pt-sm-4 px-4">
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-3 pb-sm-5 pb-3 px-4" id="change_schedule_body">
            </div>
        </div>
    </div>
</div>
{{-- @push('after-style') --}}
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
        left: 15px;
        top: 5px;
    }

    .schedule-tabs .attendance.attended {
        color: #559739;
    }

    .schedule-tabs .attendance.unattended {
        color: #FF3B3B;
    }

    .schedule-tabs .attendance.attended>span {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: #559739;
        position: absolute;
        left: 15px;
        top: 5px;
    }

    .schedule-tabs .attendance.unattended>span {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: #FF3B3B;
        position: absolute;
        left: 15px;
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

        .change_schedule_modal .modal-dialog {
            max-width: 90%;
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
{{-- @endpush --}}
{{-- @push('after-script') --}}
<script>
    function addNoSlotColumn() {
        let max = 0;
        $('.timetable-wrapper .slots-col').each(function(item) {
            let length = $(this).children('div').length;
            if (length > max) {
                max = length;
            }
        });
        if (max > 1 && max < 5) {
            $('.timetable-slots .empty').append('<span>No Slots</span>')
        } else if (max > 4) {
            $('.timetable-slots .empty').append('<span>No Slots</span><span>No Slots</span>')
        }
    }
    $('#change_schedule_modal').on('shown.bs.modal', function() {
        addNoSlotColumn()
    })
    var StudentChoosenForClassChange;
    var WeeklyClassChoosenForClassChange;
    var TeacherChoosenForClassChange;
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
        if (!$.fn.DataTable.isDataTable('#upcomingClasses-table')) {
            $('#upcomingClasses-table').on('order.dt', function() {
                    editArrows()
                })
                .on('search.dt', function() {
                    editArrows()
                }).DataTable({
                    "language": {
                        "emptyTable": "No Classes Found"
                    },
                    "aaSorting": [],

                    "columnDefs": [{
                        "orderable": false,
                        "targets": [0, 5]
                    }, ],
                });
            styleSearchField();
        }
        $(document).on('click', '#previous-tab', function() {
            // console.log('running 1');
            if (!$.fn.DataTable.isDataTable('#previousClasses-table')) {
                $('#previousClasses-table').on('order.dt', function() {
                        editArrows()
                    })
                    .on('search.dt', function() {
                        editArrows()
                    }).DataTable({
                        "language": {
                            "emptyTable": "No Classes Found"
                        },
                        "aaSorting": [],

                        "columnDefs": [{
                            "orderable": false,
                            "targets": [0, 6, 7]
                        }, ],
                    });
                styleSearchField();
            }
        })
        $(document).on('click', '#live-tab', function() {
            console.log('running 2');
            if (!$.fn.DataTable.isDataTable('#todaysClasses-table')) {
                $('#todaysClasses-table').on('order.dt', function() {
                        editArrows()
                    })
                    .on('search.dt', function() {
                        editArrows()
                    }).DataTable({
                        "language": {
                            "emptyTable": "No Classes Found"
                        },
                        "aaSorting": [],

                        "columnDefs": [{
                            "orderable": false,
                            "targets": [0, 5, 6]
                        }, ],
                    });
                styleSearchField();
            }
        })
        editArrows();
        $(document).on('click', '.paginate_button', function() {
            editArrows()
        });
        $('.dataTables_length select').on('change', function() {
            editArrows()
        })
    })

    $('.teacher-slots button').on('click', function() {
        $(this).toggleClass('btn-outline-dark');
        $(this).toggleClass('btn-dark active')
    })

    $(document).on('click', 'button[data-action="reschedule"]', function() {

        StudentChoosenForClassChange = $(this).data(
            'studentid'); // which student's class is going to be rescheduled
        WeeklyClassChoosenForClassChange = $(this).data(
            'weeklyclassid'); // which student's class is going to be rescheduled
        TeacherChoosenForClassChange = $(this).data(
            'teacherid'); // which teacher's class we are going to change

        // get the latest schedule of the teacher and paste it in the modal 
        var formdata = new FormData();
        formdata.append('teacherid', $(this).data('teacherid'));
        formdata.append('studentid', $(this).data('studentid'));

        Ajax_Call_Dynamic('{{ route('teacher-coordinator.RescheduleRequest', [app()->getLocale()]) }}',
            "POST", formdata, "TeacherCoordinatorRescheduleSuccess",
            'FailedToasterResponse', '#change_schedule_body');
    });

    function TeacherCoordinatorRescheduleSuccess(response) {

        $('#change_schedule_body').html(response.response);
    }
</script>
{{-- @endpush --}}
