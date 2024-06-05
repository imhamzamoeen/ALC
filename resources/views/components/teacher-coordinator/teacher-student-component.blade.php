<div class="container view-students">
    <h4 class="px-24 text-sb mb-4">{{ __('All Students') }}</h4>
    <table class="vertical-table table-borderless" id="students-table">
        <thead class="table-header">
            <tr>
                <th scope="col" class="ps-2">{{ __('Student Name') }}</th>
                <th scope="col" class="ps-2">{{ __('Student Reg No') }}</th>

                <th scope="col">{{ __('Attendance') }}</th>
                {{-- <th scope="col" class="pe-2">{{ __('Action') }}</th> --}}
            </tr>
        </thead>
        <tbody>


            @foreach ($Model->Students as $eachStudent)
                <tr>
                    <td data-label="student Name">
                        <div class="row">
                            <div class="col-lg-2 col-md-3 d-none d-md-inline-block ">{!! generate_profile_picture_by_name($eachStudent->name, 45) !!}</div>
                            <div class="align-self-center text-md-start text-end col-12 col-lg-10 col-md-9 pe-0 ps-0">
                                {{ $eachStudent->name }}</div>
                        </div>
                    </td>
                    <td data-label="student Reg No">

                        {{ $eachStudent->reg_no }}

                    </td>
                    <td data-label="Attendance">
                        <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                                class="nav nav-link nav-item px-0 text-dark py-sm-2 attendace_of_student_btn  py-0"
                                data-student_id="{{ $eachStudent->id }}" data-bs-toggle="tab" role="tab"
                                aria-controls="attendance" aria-selected="true">View Attendance</a></div>
                    </td>
                    {{-- <td data-label="Action">
                        <button class="btn py-0"><i class="far fa-comments color-primary px-24"></i></button>
                    </td> --}}
                </tr>
            @endforeach


        </tbody>
    </table>
</div>

<style>
    .view-students .btn-custom>a:hover {
        font-weight: 600;
        text-decoration: underline;
        color: var(--primary-color) !important;
    }

    .view-students .btn-custom>a {
        font-size: var(--px-14);
    }

    .vertical-table .btn:focus {
        box-shadow: none;
    }
</style>

<script>
    $(document).ready(function() {
        $('#students-table').on('order.dt', function() {
                editArrows()
            })
            .on('search.dt', function() {
                editArrows()
            }).DataTable({
                "columnDefs": [{
                    "orderable": false,
                    "targets": [2]
                }]
            });
        $(document).on('click', '.paginate_button', function() {
            editArrows()
        });
        $('.dataTables_length select').on('change', function() {
            editArrows()
        })
        editArrows();
        styleSearchField();
    })

    $('.attendace_of_student_btn').click(function(e) {
        e.preventDefault();
        var formdata = new FormData();
        formdata.append('student_id', $(this).data('student_id'));
        formdata.append('asking_id', asking_id);

        Ajax_Call_Dynamic('{{ route('GetAttendance', [app()->getLocale()]) }}', 'POST', formdata,
            "TeachersStudentAttendanceSuccess", 'FailedToasterResponse',
            '.tab-pane[data-component="students"]');
    });


    function TeachersStudentAttendanceSuccess(response) {
        $('.tab-pane[data-component="teacher"]').html(response
            .response
        ); // because Teacher co ordinator has view attendance option in teacher  tab and that would be active that time 

    }
</script>
