<div class="container-xl upload">
    {{-- <h4 class="px-24 text-sb mb-4">Tajweed</h4> --}}
    <div class="row">
        <div class="col-md-6 col-lg-8 col-12">
            <input type="file" class="my-pond">
            <h4 class="px-24 text-sb mb-4 mt-5">{{ __('Files Uploaded') }}</h4>
            <div class="files_wrapper">
                @forelse($Model->files as $key => $value)
                    <div class="d-flex justify-content-between align-items-center pb-4 px-2 border-bottom file-row"
                        data-id="{{ $value->id }}">
                        <div class="d-flex align-items-center">
                            {{-- <img src="{!! get_icon_of_resource_file($value->file_type) !!}" alt="file" class="me-2"
                            height="45px" width="45px"> --}}
                            <object type="image/svg+xml" data="{!! get_icon_of_resource_file($value->file_type) !!}" width="45" height="45">
                                Your browser does not support SVG.
                            </object>
                            <div>
                                <span class="mb-1 px-14 text-sb file-name">{{ $value->title }}</span><span
                                    class="mb-1 px-14 text-sb file-type">.{{ $value->file_type }}</span>
                                <input type="text" name="file-name" required autofocus id="file-name"
                                    style="display: none" class="border-0 file-name-input px-14 text-sb w-100"
                                    placeholder="Enter File Name Here"><span class="tooltiptext text-med"></span>
                                <p class="mb-0 px-12 text-med">{{ $value->created_at->format('d M,Y h:i A') }}</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="rounded-circle action-icon edit" data-btn-id="{{ $value->id }}">
                                <i class="fa fa-pencil"></i>
                            </div>
                            <div class="ms-2 rounded-circle action-icon delete" data-btn-id="{{ $value->id }}">
                                <i class="fa fa-times"></i>
                            </div>
                            <div class="ms-2 spinner-border color-primary text-light loading" style="display: none"
                                role="status"></div>

                        </div>

                    </div>
                @empty
                    <h4 class="px-18 text-sb empty-state pt-4 default">
                        {{ __('No Files To Show') }}
                    </h4>
                @endforelse
                <h4 class="px-18 text-sb empty-state pt-4" style="display: none">
                    {{ __('No Files To Show') }}
                </h4>
            </div>

        </div>
        <div class="col-md-6 col-lg-4 col-12 rounded border shadow mt-md-0 mt-4 teacher_wrapper">
            <div class="px-3 pb-3 pt-0">
                {{-- <div class="position-relative">
                    <input type="text" placeholder="Search a Teacher" class="border px-14 rounded search-box px-3"
                        name="search" id="search">
                    <i class="fa fa-search search-icon text-muted" aria-hidden="true"></i>
                </div> --}}
                <div class="px-14">
                    <table id="TeacherTable">
                        <tbody>
                            @forelse ($Teachers->Teacher as $Eachteacher)
                                <tr>
                                    <div class="d-flex mb-3 justify-content-between">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                {!! generate_profile_picture_by_name($Eachteacher->name, 45) !!}
                                                <div class="ms-2">
                                                    {{ $Eachteacher->name }}
                                                </div>
                                            </div>
                                        </td>


                                        <td class="teacher-id-{{ $Eachteacher->id }}"
                                            data-teacher="{{ $Eachteacher->id }}">
                                            @if ($Eachteacher->shareableLibraries->isEmpty())
                                                <button
                                                    class="btn btn-outline-primary btn-action assign float-end clearfix"
                                                    data-teacherid="{{ $Eachteacher->id }}"
                                                    data-folderid="{{ $Model->id }}">Assign</button>
                                            @else
                                                <button class="btn btn-primary btn-action unassign float-end clearfix"
                                                    data-id="{{ $Eachteacher->shareableLibraries[0]->id }}">UnAssign</button>
                                            @endif
                                        </td>
                                    </div>
                                </tr>
                            @empty
                                <h4 class="px-18 text-sb empty-state pt-4">
                                    {{ __('No Teacher To Show') }}
                                </h4>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div>
        {{-- <button class="nav nav-link nav-item btn btn-outline-primary float-end px-5 py-2 mt-sm-5 my-3 back-btn"
            data-bs-toggle="tab" data-bs-target="#library" role="tab" aria-controls="library" aria-selected="true">
            Back</button> --}}
    </div>
</div>

<style>
    .filepond--credits {
        display: none;
    }

    .filepond--roo.my-pond.filepond--hopper {
        min-height: 200px;
        border: 2px dashed #d4d4d4;
    }

    .filepond--drop-label {
        height: 200px;
        /* background-color: #FCFCFC; */

    }

    .search-icon {
        position: absolute;
        right: 15px;
        top: 17px;
    }

    .search-box {
        height: 54px;
        width: 100%;
    }

    .search-box:focus-visible {
        outline: none;
    }

    #TeacherTable_wrapper .dataTables_filter input {
        padding: 15px 10px !important;
    }

    #TeacherTable.dataTable.no-footer {
        border-bottom: none;
    }

    th.sorting_disabled {
        padding-top: 0 !important;
    }

    .action-icon {
        background-color: #D9D9D972;
        cursor: pointer;
        width: 35px;
        height: 35px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .action-icon>i {
        color: #CCCACA;
        font-size: 18px;
    }

    .action-icon>i:hover {
        color: var(--primary-color);

    }

    .btn-action {
        width: 88px;
    }

    .file-name-input:focus-visible {
        outline: 0;
    }

    .filepond--label-action {
        font-weight: 600;
        color: #0A5CD6;
        display: block;
        margin-top: 10px;
        text-decoration: none;
    }

    .files_wrapper,
    .teacher_wrapper {
        max-height: 400px;
        overflow-y: scroll;
    }

    .file-row {
        position: relative;
        display: inline-block;
    }

    .file-row:not(:first-child) {
        padding-top: 20px;
    }

    /* Tooltip text */
    .file-row .tooltiptext {
        width: 265px;
        top: 48px;
        left: 10px;
    }

    .btn-action {
        width: 100px;
        height: 40px;
    }

    .back-btn {
        width: 150px;
        height: 44px;
        font-size: 14px !important;
    }
</style>

{{-- <script src="https://unpkg.com/filepond-plugin-file-rename/dist/filepond-plugin-file-rename.js"></script> --}}

<script>
    var TeacherSelected;
    $(document).ready(function() {
        $(document).off(
            '.folder_events'); //removing events to prevent them from reassigning when user revisits this tab
        $(document).off('.library_events'); //removing events of library tab
        $('.action-icon.delete').off('click');
        $('.action-icon.edit').off('click');
        $(document).on('click.folder_events', changeName);
        $(document).on('keypress.folder_events', submitOnEnter);
        $(document).on('click.folder_events', '.btn-action.assign', assignButton)
        $(document).on('click.folder_events', '.btn-action.unassign', unassignButton)
        $(document).on('click.folder_events', '.action-icon.delete', deleteFile);
        $(document).on('click.folder_events', '.action-icon.edit', editFile);
        $('.action-icon.delete').on('click', deleteFile);
        $('.action-icon.edit').on('click', editFile);

        //creating data table on teacher component for searching
        if (!$.fn.DataTable.isDataTable('#TeacherTable')) {
            $('#TeacherTable').DataTable({
                "bPaginate": false,
                "bLengthChange": false,
                "bFilter": true,
                "bInfo": false,
                "bAutoWidth": false,

                "language": {
                    "emptyTable": "No Teacher Found"
                },
                "aaSorting": [],
                language: {
                    search: ""
                },

                "columnDefs": [{
                    "orderable": false,
                    "targets": [0, 1]
                }, ],
            });
            styleSearchField();
        }

    });
    // Get a reference to the file input element
    var inputElement = document.querySelector('.my-pond');
    // FilePond.registerPlugin(FilePondPluginFileRename);
    // Create a FilePond instance
    var pond = FilePond.create(inputElement);
    var id = '';
    // var fileType = '';
    pond.setOptions({
        maxFiles: 30,
        required: true,
        allowMultiple: true,
        dropValidation: true,
        checkValidity: true,
        instantUpload: true,

        server: {
            revert: null,
            // url: 'http://192.168.33.10',    // agar koi aur server ho tb hm yeh add krty 
            process: {
                url: '{{ route('teacher-coordinator.AddFileToFolder', [app()->getLocale()]) }}',
                method: "POST",
                withCredentials: false,
                //   Accept: 'application/json',
                onload: (response) => {

                    //runs after serve returns response 
                    // console.log(typeof response);

                    var data = JSON.parse(response).response;
                    console.log(data.file_type);

                    var asset = "{{ asset('images/file/') }}";
                    // varfile_name =
                    //     console.log(file_name +
                    //         'pdf.svg');
                    // return;
                    // response;

                    if (['pdf', 'png', 'docx', 'txt', 'jpg', 'jpeg', 'dox', 'pptx', 'ppt', 'word'].includes(
                            data.file_type))
                        var file = data.file_type;
                    else
                        var file = 'file';
                    $('.empty-state').hide();
                    $('.files_wrapper').append(
                        '<div class="d-flex justify-content-between align-items-center pb-4 px-2 border-bottom file-row"' +
                        'data-id="' + data.id + '">' +
                        '<div class="d-flex align-items-center">' +
                        '<object type="image/svg+xml" data=' + asset + '/' + file + '.svg' +
                        ' width="45" height="45">' +
                        'Your browser does not support SVG' +
                        '</object>' +

                        '<div>' +
                        '<span class="mb-1 px-14 text-sb file-name">' + data.title +
                        '</span><span ' +
                        'class="mb-1 px-14 text-sb file-type">.' + data.file_type + '</span>' +
                        '<input type="text" name="file-name" required autofocus id="file-name"' +
                        'style="display: none" class="border-0 file-name-input px-14 text-sb w-100"' +
                        'placeholder="Enter File Name Here"><span class="tooltiptext text-med"></span>' +
                        '<p class="mb-0 px-12 text-med">Just Now' +
                        '</p>' +
                        '</div>' +
                        '</div>' +
                        '<div class="d-flex">' +
                        '<div class="rounded-circle action-icon edit" data-btn-id="' + data
                        .id + '">' +
                        '<i class="fa fa-pencil"></i>' +
                        '</div>' +
                        '<div class="ms-2 rounded-circle action-icon delete" data-btn-id="' + data
                        .id + '">' +
                        '<i class="fa fa-times"></i>' +
                        '</div>' +
                        '<div class="ms-2 spinner-border color-primary text-light loading" style="display: none"' +
                        'role="status"></div>' +
                        '</div>' +
                        '</div>')
                    //
                    // response.key, 
                }, // onsuccess of filepond
                onerror: (response) => {

                    // alert("error");
                    // response.data,   //on error of filepond 
                },
                //   data: ,
                ondata: (formData) => { // add data to the filepond while adding file
                    formData.append('folder_id', FolderSelected);
                    return formData;
                }
            },

            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        // acceptedFileTypes: ['image/*']
    });

    //run api for assigning folder to teacher
    function assignButton() {
        TeacherSelected = $(this).parent().data('teacher');
        console.log('assign running');
        var formdata = new FormData();
        formdata.append('folder_id', $(this).data('folderid'));
        formdata.append('teacher_id', $(this).data('teacherid'));

        Ajax_Call_Dynamic('{{ route('teacher-coordinator.AssignFolderToTeacher', [app()->getLocale()]) }}', "post",
            formdata, "AssginFolderSuccess",
            'FailedToasterResponse', );

        $('.btn-action.unassign').on('click', unassignButton)
    }

    //run api for unassigning folder to teacher
    function unassignButton() {
        console.log('unassign button clicked');
        TeacherSelected = $(this).parent().data('teacher');

        id = $(this).data('id');
        var formdata = new FormData();
        formdata.append('shared_id', id);

        Ajax_Call_Dynamic('{{ route('teacher-coordinator.DeleteSharedFile', [app()->getLocale()]) }}', "post",
            formdata, "UnAssignFileSuccess",
            'FailedToasterResponse', );
        $('.btn-action.assign').on('click', assignButton)
    }

    //runs automatically after folder is unassigned successfully
    function UnAssignFileSuccess(response) {

        console.log("in unassign file succ6ess");
        $('.teacher-id-' + TeacherSelected).html(
            '<button class="btn btn-outline-primary btn-action assign float-end clearfix" data-teacherid="' +
            TeacherSelected + '" data-folderid="' + response.response.folder.id + '">Assign</button>'
        )

    }

    //runs automatically after folder is assigned successfully
    function AssginFolderSuccess(response) {

        toaster('success', 'Folder Assigned Successfully')
        console.log("in Assign Folder file success");
        $('.teacher-id-' + TeacherSelected).html(
            '<button class="btn btn-primary btn-action unassign float-end clearfix" data-id="' + response.response
            .id + '">UnAssign</button>'
        );
    }

    var id;

    //runs when user clicks edit button and replaces name with input field and ralevent buttons.
    function editFile(event) {
        event.stopPropagation();

        id = $(this).data('btn-id');
        let name = $('.file-row[data-id="' + id + '"]').find('.file-name');
        // fileType = $('.file-row[data-id="' + id + '"]').find('.file-type').html();
        $(this).hide();
        console.log(name.html());
        $(this).siblings('.delete').hide();
        // $(this).siblings('.loading').show();
        name.hide();
        name.next().hide();
        const input = $('.file-row[data-id="' + id + '"]').find('.file-name-input');
        input.show();
        $('.file-row[data-id="' + id + '"]').addClass('active');
        $('.file-row[data-id="' + id + '"]:not(.active)').addClass('avoid-clicks');
        input.attr('value', name.html())
        const end = name.html().length;
        const el = document.querySelector('.file-row[data-id="' + id + '"] .file-name-input');
        el.setSelectionRange(end, end);
        el.focus();
        $('.file-row:not([data-id="' + id + '"])').addClass('avoid-clicks');
    }

    //runs when user clicks on delete button
    function deleteFile() {
        console.log('runnning');
        Swal.fire({
            text: 'Are you sure you want to Delete the file',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete!'
        }).then((result) => {
            if (result.isConfirmed) {
                swal.close()
                id = $(this).data('btn-id');
                $(this).siblings('.edit').hide();
                $(this).siblings('.loading').show();
                DeleteFile(id);
            }
        })
    }

    //does not allow clicking on action buttons of other files when you are renaming other file already.
    $('.file-row:not([data-id="' + id + '"])').on('click', function(event) {
        event.stopPropagation();
    })

    //submits file name when user press enter key.
    function submitOnEnter(e) {
        if (e.which == 13) {
            changeName();
        } else {
            $('.tooltiptext').removeClass("show");
        }
    }

    //brings back user to library tab
    $('.back-btn').on('click', function() {
        $(this).removeClass('active');
        $('.folder .nav.active').removeClass('active');
    })

    //run after user submits file name
    function changeName() {
        fileName = $('.file-row.active .file-name-input').val();
        // fileName += fileType;
        if (!(fileName == undefined || fileName === 'undefined')) {
            if (fileName === '' || invalidName(fileName)) {
                const message = 'Invalid File Name';
                showTooltip(message);
            } else {
                ChangeFileName(id, fileName);
            }
        }
    }

    //call api for submitting new file name
    function ChangeFileName(id, fileName) {
        var formdata = new FormData();
        formdata.append('file_id', id);
        formdata.append('file_name', fileName);

        Ajax_Call_Dynamic('{{ route('teacher-coordinator.UpdateFileName', [app()->getLocale()]) }}', "post",
            formdata, "RenameFileSuccess",
            'FailedEditResponse', );
    }

    //runs automatically after file is renamed successfully
    function RenameFileSuccess(response) {

        const input = $('.file-row[data-id="' + id + '"] .file-name-input')
        input.hide();
        const name = $('.file-row[data-id="' + id + '"] .file-name')
        name.show();
        name.next().show();
        name.html(fileName.trim());
        $('.edit-btn[data-btn-id="' + id + '"]').show();
        const icon = $('.file-row[data-id="' + id + '"] .action-icon');
        icon.show();
        icon.siblings('.loading').hide();
        $('.file-row').removeClass('active avoid-clicks')
        $('.tooltiptext').removeClass("show");
        id = '';
        Toast.fire({
            icon: 'success',
            title: 'File Renamed Successfully',
            timer: 1500
        })
    }

    //show error tooltip on invalid file name
    function showTooltip(message) {
        $('.file-row[data-id="' + id + '"] .tooltiptext').addClass("show");
        $('.file-row[data-id="' + id + '"] .tooltiptext').html(message);
        $('.file-row[data-id="' + id + '"] .file-name-input').focus();
    }

    //runs api for deleting file
    function DeleteFile(id) {
        var formdata = new FormData();
        formdata.append('file_id', id);


        Ajax_Call_Dynamic('{{ route('teacher-coordinator.DeleteFile', [app()->getLocale()]) }}', "post", formdata,
            "DeleteFileSuccess",
            'FailedDeleteResponse');
    }

    //runs automatically after successful file deletion.
    function DeleteFileSuccess(response) {

        $('.file-row[data-id="' + id + '"]').remove();
        console.log(id);
        if ($('.file-row').length === 0) {
            $('.empty-state:not(.default)').show();
        } else {
            $('.empty-state').hide();
        }
        Toast.fire({
            icon: 'success',
            title: 'File Deleted Successfully',
            timer: 1500
        })
    }

    //runs automatically after failed edit file api.
    function FailedEditResponse(response) {

        $('.file-row.active .loading').hide();
        const errors = response.responseJSON.errors;
        const message = Object.values(errors)[0]
        showTooltip(message);
        // $('.file-row.active .submit')
    }

    //runs automatically after failed delete api.
    function FailedDeleteResponse(response) {

        $('.file-row.active .loading').hide();
        $('.file-row.active .action').show();
        // $('.file-row.active .submit')
    }
</script>
