<h4 class="px-18 text-sb pb-2 mb-3">Enrolled Students</h4>
<table class="vertical-table table-borderless students" id="students-table">
    <thead class="table-header">
        <tr>
            <th scope="col" class="ps-2">Student Name</th>
            <th scope="col">Reg NO</th>

            <th scope="col">Attendance</th>
            <th scope="col">Action</th>
            <th scope="col" class="pe-2">Attachments</th>
        </tr>
    </thead>
    <tbody>
        @isset($Model)
            @forelse($Model->Students as $user)
                <tr>
                    <td data-label="Student Name">
                        <div class="row">
                            <div class="col-md-3 col-lg-2 d-none d-md-inline-block ">{!! generate_profile_picture_by_name($user->name, 45) !!}</div>
                            <div class="col-12 col-md-9 col-lg-10 align-self-center pe-0 ps-md-0 ps-md-4">
                                {{ $user->name }}</div>
                        </div>

                    </td>
                    <td> {{ $user->reg_no }}</td>

                    <td data-label="Attendance">
                        <div class="btn btn-custom py-0 px-sm-2 px-0"><a
                                class="btn px-0 view_attendance-btn teacher_check_student_attendance"
                                data-studentid="{{ $user->id }}" role="tab" aria-controls="attendance"
                                aria-selected="true">View
                                Attendance</a></div>
                    </td>
                    <td data-label="Assign Resources"><button class="btn btn-outline-primary add_resources-btn"
                            data-bs-target="#resources-modal" data-studentid={{ $user->id }}
                            data-bs-toggle="modal">Attach
                            Resources</button></td>
                    <td data-label="Notes / Docs">
                        <a data-bs-target="#notes-modal" data-bs-toggle="modal" data-studentid={{ $user->id }}
                            class="btn view_attendance-btn px-0 view_notes_btn">View
                            Attachments</a>
                    </td>
                </tr>
            @empty
                {{-- {{ __('No Student Yet') }} --}}
            @endforelse
        @endisset

    </tbody>
</table>
<div class="modal fade resources-modal" id="resources-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header pb-0 px-4 pt-4">
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0 px-sm-5 pb-5">
                <h3 class="px-18 text-med mb-4">{{ __('Search book/notes') }}</h3>
                <form action="{{ route('teacher.SearchResource', [app()->getLocale()]) }}"
                    class="position-relative SearchResourceForm" method="post">
                    <i class="fa fa-search search-icon"></i>
                    <input type="text" name="search" id="search_resource" class="form-control border-0 search-input"
                        placeholder="Search...">
                </form>
                <div class="border mt-3 pt-2 pb-3 rounded resources-div">
                    <div class="notes-container p-4">
                        @isset($Model->libraries)
                            <x-teacher-assigned-resource-component :model="$Model" />
                        @endisset

                    </div>
                </div>
                <button
                    class="btn done-button float-end clearfix mt-5 btn-outline-primary disabled assign_resource_to_student_button"
                    data-bs-dismiss="modal" aria-label="Close">Done</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade notes-modal" id="notes-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header px-4 pt-4">
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0 px-sm-5 pb-4">
                <div class="pt-2 pb-3 rounded each_student_note">
                    <div class="pb-4 student_note">
                        <!-- getting each student notes form ajax -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .view_attendance-btn:hover {
        text-decoration: underline;
        color: var(--primary-color);
        font-weight: 600;
    }

    .resources-modal .modal-dialog {
        max-width: 776px;
    }

    .notes-modal .modal-dialog {
        max-width: 714px;
    }

    .add_resources-btn {
        width: 161px;
        height: 39px;
    }

    .search-icon {
        position: absolute;
        top: 21px;
        left: 17px;
    }

    .search-input {
        height: 58px;
        padding-left: 40px;
        -webkit-box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15);
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15);

    }

    .search-input:focus {
        -webkit-box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
    }

    .search-input::-webkit-input-placeholder {
        color: #CCCACA;
    }

    .search-input::-moz-placeholder {
        color: #CCCACA;
    }

    .search-input:-ms-input-placeholder {
        color: #CCCACA;
    }

    .search-input::-ms-input-placeholder {
        color: #CCCACA;
    }

    .search-icon,
    .search-input::placeholder {
        color: #CCCACA;
    }

    #students-table .btn-custom>a {
        font-size: var(--px-14);
    }

    .notes-container {
        height: 443px;
        overflow-y: auto;
    }

    .done-button {
        width: 169px;
        height: 52px;
    }

    .done-button.disabled {
        background-color: #F3F3F3;
        border-color: #CCCACA;
        color: #CCCACA;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 34px;
        height: 14px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        -o-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: -5px;
        top: -3px;
        background-color: white;
        -webkit-transition: .4s;
        -o-transition: .4s;
        transition: .4s;
        -webkit-box-shadow: 1px 1px 15px 2px lightgrey;
        box-shadow: 1px 1px 15px 2px lightgrey;
    }

    input:checked+.slider::before {
        background-color: var(--primary-color);
    }

    input:checked+.slider {
        background-color: #51987261;
    }

    input:focus+.slider {
        -webkit-box-shadow: 0 0 1px #51987261;
        box-shadow: 0 0 1px #51987261;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    .notes-modal .border-bottom {
        border-bottom: 1px solid #dee2e64f !important;
    }

    .cross-icon {
        padding: 6px 10px 4px;
        background-color: #D9D9D972;
        cursor: pointer;
    }

    .cross-icon>i {
        color: #CCCACA;
        font-size: 18px;
    }

    .cross-icon>i:hover {
        color: #E94235;

    }

    @media screen and (max-width:576px) {
        .students.vertical-table td {
            padding: 10px 0 10px 0 !important;
        }
    }
</style>

<script>
    var old_search_val = '';

    var StudentChoosenForResourceAllocation;
    var AssignedResourceFormData;
    var GlobalAttachmentFormData; // this will have all the selected files in it
    $(document).ready(function() {
        GlobalAttachmentFormData = new FormData();
        $('#students-table').on('order.dt', function() {
                editArrows()
            })
            .on('search.dt', function() {
                editArrows()
            }).DataTable({
                "language": {
                    "emptyTable": "No Students Found"
                },
                "columnDefs": [{
                    "orderable": false,
                    "targets": [2, 3, 4]
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

        $(document).on("click", ".notes-container .switch input[name='ResrouceCheckbox[]']", function() {
            var items = $('.notes-container .switch input').is(':checked');
            if ($(items).length >= 1) {
                $('.done-button').removeClass('disabled')
            } else {
                $('.done-button').addClass('disabled')
            }
        })

    });

    function assignResource() {
        // console.log('unning');

        var items = $('.notes-container .switch input').is(':checked');
        if ($(items).length >= 1) {
            $('.done-button').removeClass('disabled')
        } else {
            $('.done-button').addClass('disabled')
        }
    }
    $(".notes-container .switch input[name='ResrouceCheckbox[]']").on("click", assignResource);
    $(".notes-container .switch input[type=checkbox]").on("click", function(e) {

        if ($(this).is(':checked')) {
            // the button is checked now add it to global form
            GlobalAttachmentFormData.append('libray_files[]', this.value)
        } else {
            var enteries = GlobalAttachmentFormData.getAll('libray_files[]');


            if (enteries.includes(this.value)) {
                // that entry is present in the form data remove it

                const index = enteries.indexOf(this.value);
                enteries.splice(index, 1);
                // remove one element from given index

                GlobalAttachmentFormData = new FormData(); //clear form data

                if (enteries.length > 0) {
                    enteries.forEach(element => {
                        GlobalAttachmentFormData.append('libray_files[]', element);
                    });

                }

                console.log(GlobalAttachmentFormData.getAll('libray_files[]'));
            }

            // the button is unchecked now remove it fom form data
        }

    });

    $(".SearchResourceForm [name='search']").keyup(function(e) {
        e.preventDefault();

        var fromdata = new FormData($('.SearchResourceForm')[0]);

        var new_search_val = fromdata.get(
            'search'); // save the old value to not send ajax request on every backspace
        if (new_search_val === old_search_val) {
            return;
        }
        old_search_val = new_search_val;
        var url = $($('.SearchResourceForm')[0]).attr('action');
        var method = $($('.SearchResourceForm')[0]).attr('method');
        Ajax_Call_Dynamic(url, method, fromdata, "SearchResourceSuccess", 'FailedToasterResponse',
            '.resources-div > .notes-container', 'False');



    });
    $('SearchResourceForm').submit(function(e) {
        e.preventDefault();
        $(".SearchResourceForm [name='search']").trigger('keyup');
    });

    $('.add_resources-btn').click(function(e) {
        e.preventDefault();
        StudentChoosenForResourceAllocation = $(this).data("studentid");
    });

    $('.view_notes_btn').click(function(e) { //whenver view note of a student is clicked get his/her notes 
        e.preventDefault();
        var formdata = new FormData();
        formdata.append('studentid', $(this).data("studentid"));

        Ajax_Call_Dynamic('{{ route('teacher.GetStudentResource', [app()->getLocale()]) }}', 'POST', formdata,
            "StudentNotesSuccess", 'FailedToasterResponse', '.each_student_note > .student_note');
    });

    function SearchResourceSuccess(response) {
        // $('.done-button').addClass('disabled');
        var enteries = GlobalAttachmentFormData.getAll('libray_files[]');
        $.each(enteries, function(indexInArray, valueOfElement) {
            setTimeout(() => {
                $("input[name='ResrouceCheckbox[]']").each(function(index, element) {

                    if (this.value == valueOfElement) {
                        $(this).prop('checked', true);
                    }

                });
            }, 10);


        });
        $('.resources-div > .notes-container').html(response.response)
    }

    function StudentNotesSuccess(response) {
        $('.each_student_note > .student_note').html(response.response)
    }

    function AssignedResourceSuccess(response) {
        $(".notes-container .switch input[type=checkbox]:checked").prop('checked', false); // uncheck all selected files
        GlobalAttachmentFormData = new FormData();
        toaster('success', 'Resources Assigned Successfully Added');
    }




    $('.assign_resource_to_student_button').click(function(e) {
        e.preventDefault();
        // AssignedResourceFormData = new FormData();  // ever time we are making an empty form data and adding selected options to it
        // $(".notes-container .switch input[type=checkbox]:checked").each(function() {

        //     AssignedResourceFormData.append('libray_files[]', this.value)

        // });

        GlobalAttachmentFormData.append('student_id', StudentChoosenForResourceAllocation)
        Ajax_Call_Dynamic('{{ route('teacher.AssignResourceToStudent', [app()->getLocale()]) }}', 'POST',
            GlobalAttachmentFormData, "AssignedResourceSuccess", 'FailedToasterResponse',
            '.resources-div > .notes-container', 'False');

    });

    $('.teacher_check_student_attendance').click(function(e) {
        e.preventDefault();
        var formdata = new FormData();
        formdata.append('student_id', $(this).data('studentid'));
        formdata.append('asking_id', "{{ auth()->user()->id }}");


        Ajax_Call_Dynamic('{{ route('GetAttendance', [app()->getLocale()]) }}', 'POST', formdata,
            "AttendanceSuccess", 'FailedToasterResponse', '.tab-pane[data-component="students"]');
    });

    function AttendanceSuccess(response) {
        $('.tab-pane[data-component="students"]').html(response
            .response); // because teacher has view attendance option in student tab and that would be active that time 

    }
</script>
