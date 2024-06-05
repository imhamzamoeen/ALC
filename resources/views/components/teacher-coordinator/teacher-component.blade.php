<div class="container view-teachers">
    <h4 class="px-24 text-sb mb-sm-2 mb-4">{{ __('All Teachers') }}</h4>
    <table class="vertical-table table-borderless" id="teachers_table">
        <thead class="table-header">
            <tr>
                <th scope="col" class="ps-2">{{ __('Teacher Name') }}</th>
                <th scope="col" class="">{{ __('Attendance') }}</th>
                <th scope="col" class="">{{ __('Assigned Student') }}</th>
                <th scope="col" class="">{{ __('Classed Recording') }}</th>
                {{-- <th scope="col" class="pe-2 ">{{ __('Action') }}</th> --}}
            </tr>
        </thead>
        <tbody>
            @forelse ($Model->Teacher as $Eachteacher)
                <tr>
                    <td data-label="Teacher Name">
                        <div class="row">
                            <div class="col-lg-2 col-md-3 d-none d-md-inline-block ">
                                {!! generate_profile_picture_by_name($Eachteacher->name, 45) !!}

                            </div>
                            <div
                                class="align-self-center text-sm-start text-end col-12 col-lg-10 col-md-9 pe-0 ps-0 ps-md-4">
                                {{ $Eachteacher->name }}</div>
                        </div>
                    </td>
                    <td data-label="Attendance">
                        <div class="btn btn-custom py-0 px-sm-2 px-0 attendance-btn "><a
                                class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0 teacher_attendance_btn"
                                data-bs-toggle="tab" data-teacher_id="{{ $Eachteacher->id }}"
                                data-bs-target="#attendance" role="tab" aria-controls="attendance"
                                aria-selected="true">View
                                Attendance</a></div>
                    </td>
                    <td data-label="Assigned Student">
                        <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                                class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0 view_student_btn"
                                data-bs-toggle="tab" data-teacher_id="{{ $Eachteacher->id }}"
                                data-bs-target="#students" role="tab" aria-controls="students"
                                aria-selected="true">View
                                Students</a></div>
                    </td>
                    <td data-label="Class Recordings">
                        <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                                class="nav nav-link nav-item px-0 text-dark py-sm-2 py-0 view_recording_btn"
                                data-bs-toggle="tab" data-teacher_id="{{ $Eachteacher->id }}"
                                data-bs-target="#recordings" role="tab" aria-controls="recordings"
                                aria-selected="true">View
                                Recordings</a></div>
                    </td>
                    {{-- <td data-label="Action">
                        <button class="btn py-0"><i class="far fa-comments color-primary px-24"></i></button>
                    </td> --}}
                </tr>
            @empty
            @endforelse


        </tbody>
    </table>
</div>
{{-- <div class="d-flex justify-content-center justify-content-sm-start">
    <button class="btn btn-outline-primary px-5 py-2 mt-sm-3" id="back-btn">Back</button>
</div> --}}
{{-- @push('after-style') --}}
<style>
    .view-teachers {
        margin-bottom: 50px;
    }

    #teachers_table {
        table-layout: auto;
    }

    .view-teachers .btn-custom>a:hover {
        font-weight: 600;
        text-decoration: underline;
        color: var(--primary-color) !important;
    }

    .view-teachers .btn-custom>a {
        font-size: var(--px-14);
    }

    .vertical-table .btn:focus {
        box-shadow: none;
    }
</style>
{{-- @endpush --}}
{{-- @push('after-script') --}}
<script>
    var asking_id = '{{ auth()->id() }}';
    $('.vertical-table a.nav').on('click', function() {
        $(this).removeClass('active');
    })
    $(document).ready(function() {
        $('#teachers_table').on('order.dt', function() {
                editArrows()
            })
            .on('search.dt', function() {
                editArrows()
            }).DataTable({
                "columnDefs": [{
                    "orderable": false,
                    "targets": [1, 2, 3]
                }]
            });
        editArrows();
        $(document).on('click', '.paginate_button', function() {
            editArrows()
        });
        $('.dataTables_length select').on('change', function() {
            editArrows()
        })
        styleSearchField();
    });

    $('.teacher_attendance_btn').click(function(e) {
        e.preventDefault();

        var formdata = new FormData();
        formdata.append('teacher_id', $(this).data('teacher_id'));
        formdata.append('asking_id', asking_id);

        Ajax_Call_Dynamic('{{ route('GetTeacherAttendance', [app()->getLocale()]) }}', 'POST', formdata,
            "TeacherAttendanceSuccess", 'FailedToasterResponse', '.tab-pane[data-component="students"]');
    });

    function TeacherAttendanceSuccess(response) {
        $('.tab-pane[data-component="teacher"]').html(response
            .response
        ); // because Teacher co ordinator has view attendance option in teacher  tab and that would be active that time 

    }

    $('.view_student_btn').click(function(e) {
        e.preventDefault();

        var formdata = new FormData();
        formdata.append('teacher_id', $(this).data('teacher_id'));
        formdata.append('asking_id', asking_id);

        Ajax_Call_Dynamic('{{ route('teacher-coordinator.GetStudentOfTeacher', [app()->getLocale()]) }}',
            'POST', formdata,
            "TeachersAttendanceSuccess", 'FailedToasterResponse', '.tab-pane[data-component="students"]');
    });

    function TeachersAttendanceSuccess(response) {
        $('.tab-pane[data-component="teacher"]').html(response
            .response
        ); // because Teacher co ordinator has view attendance option in teacher  tab and that would be active that time 

    }
</script>
{{-- @endpush --}}
