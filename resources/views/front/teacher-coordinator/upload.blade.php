<div class="container-xl upload">
    <h4 class="px-24 text-sb mb-4">Tajweed</h4>
    <div class="row">
        <div class="col-md-6 col-lg-8 col-12">
            <input type="file" class="my-pond">
            <h4 class="px-24 text-sb mb-4 mt-5">{{ __('Files Uploaded') }}</h4>
            <h4 class="px-18 text-sb empty-state pt-4" style="display: none">
                {{ __('No Files To Show') }}
            </h4>
            <div class="d-flex justify-content-between align-items-center pb-4 px-2 border-bottom file-row"
                data-id="1">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('/images/file/docx.svg') }}" alt="file" class="me-2" width="45"
                        height="45">
                    <div>
                        <span class="mb-1 px-14 text-sb file-name">tajweed book</span><span
                            class="mb-1 px-14 text-sb file-type">.docx</span>
                        <input type="text" name="file-name" required autofocus id="file-name" style="display: none"
                            class="border-0 file-name-input px-14 text-sb w-100"
                            placeholder="Enter File Name Here"><span class="tooltiptext text-med">File Name
                            Cannot Be Empty</span>
                        <p class="mb-0 px-12 text-med">17 Aug, 2021 at 17:05</p>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="rounded-circle action-icon edit" data-btn-id="1">
                        <i class="fa fa-pencil"></i>
                    </div>
                    <div class="ms-2 rounded-circle action-icon delete" data-btn-id="1">
                        <i class="fa fa-times"></i>
                    </div>
                </div>

            </div>
            <div class="d-flex justify-content-between align-items-center py-4 px-2 border-bottom file-row"
                data-id="2">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('/images/file/pdf.svg') }}" alt="file" class="me-2" width="45"
                        height="45">
                    <div>
                        <span class="mb-1 px-14 text-sb file-name">Tajweed book</span><span
                            class="mb-1 px-14 text-sb file-type">.pdf</span>
                        <input type="text" name="file-name" required autofocus id="file-name" style="display: none"
                            class="border-0 file-name-input px-14 text-sb w-100"
                            placeholder="Enter File Name Here"><span class="tooltiptext text-med">File Name
                            Cannot Be Empty</span>
                        <p class="mb-0 px-12 text-med">17 Aug, 2021 at 17:05</p>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="rounded-circle action-icon edit" data-btn-id="2">
                        <i class="fa fa-pencil"></i>
                    </div>
                    <div class="ms-2 rounded-circle action-icon delete" data-btn-id="2">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center py-4 px-2 border-bottom file-row"
                data-id="3">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('/images/file/pptx.svg') }}" alt="file" class="me-2" width="45"
                        height="45">
                    <div>
                        <span class="mb-1 px-14 text-sb file-name">Hifz course</span><span
                            class="mb-1 px-14 text-sb file-type">.pptx</span>
                        <input type="text" name="file-name" required autofocus id="file-name" style="display: none"
                            class="border-0 file-name-input px-14 text-sb w-100"
                            placeholder="Enter File Name Here"><span class="tooltiptext text-med">File Name
                            Cannot Be Empty</span>
                        <p class="mb-0 px-12 text-med">17 Aug, 2021 at 17:05</p>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="rounded-circle action-icon edit" data-btn-id="3">
                        <i class="fa fa-pencil"></i>
                    </div>
                    <div class="ms-2 rounded-circle action-icon delete" data-btn-id="3">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center py-4 px-2 border-bottom file-row"
                data-id="4">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('/images/file/file.svg') }}" alt="file" class="me-2" width="45"
                        height="45">
                    <div>
                        <span class="mb-1 px-14 text-sb file-name">Random file</span><span
                            class="mb-1 px-14 text-sb file-type">.ext</span>
                        <input type="text" name="file-name" required autofocus id="file-name" style="display: none"
                            class="border-0 file-name-input px-14 text-sb w-100"
                            placeholder="Enter File Name Here"><span class="tooltiptext text-med">File Name
                            Cannot Be Empty</span>
                        <p class="mb-0 px-12 text-med">17 Aug, 2021 at 17:05</p>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="rounded-circle action-icon edit" data-btn-id="4">
                        <i class="fa fa-pencil"></i>
                    </div>
                    <div class="ms-2 rounded-circle action-icon delete" data-btn-id="4">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 col-12 rounded border shadow mt-md-0 mt-4">
            <div class="px-3 py-4">
                <div class="position-relative">
                    <input type="text" placeholder="Search a Teacher" class="border px-14 rounded search-box px-3"
                        name="search" id="search">
                    <i class="fa fa-search search-icon text-muted" aria-hidden="true"></i>
                </div>
                <div class="px-14 pt-4">
                    <div class="d-flex mb-3 justify-content-between">
                        <div class="d-flex align-items-center">
                            {!! generate_profile_picture_by_name('Haroon Mukhtar', 45) !!}
                            <div class="ms-2">
                                Haroon Mukhtar
                            </div>
                        </div>
                        <button class="btn btn-outline-primary btn-action assign">Assign</button>
                    </div>
                    <div class="d-flex mb-3 justify-content-between">
                        <div class="d-flex align-items-center">
                            {!! generate_profile_picture_by_name('N A', 45) !!}
                            <div class="ms-2">
                                Noman Ali
                            </div>
                        </div>
                        <button class="btn btn-outline-primary btn-action assign">Assign</button>
                    </div>
                    <div class="d-flex mb-3 justify-content-between">
                        <div class="d-flex align-items-center">
                            {!! generate_profile_picture_by_name('S T', 45) !!}
                            <div class="ms-2">
                                Saad Yasin
                            </div>
                        </div>
                        <button class="btn btn-outline-primary btn-action assign">Assign</button>
                    </div>
                    <div class="d-flex mb-3 justify-content-between">
                        <div class="d-flex align-items-center">
                            {!! generate_profile_picture_by_name('T M', 45) !!}
                            <div class="ms-2">
                                Talha Mubashar
                            </div>
                        </div>
                        <button class="btn btn-primary btn-action unassign">Unassign</button>
                        {{-- <div class="rounded-circle cross-icon">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        {{-- <button class="nav nav-link nav-item btn btn-outline-primary float-end px-5 py-2 mt-sm-5 my-3 back-btn"
            data-bs-toggle="tab" data-bs-target="#library" role="tab" aria-controls="library"
            aria-selected="true"> Back</button> --}}
    </div>
</div>
@push('after-style')
    {{-- <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" /> --}}
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

        .file-row {
            position: relative;
            display: inline-block;
        }

        /* Tooltip text */
        .file-row .tooltiptext {
            width: 265px;
            top: 48px;
            left: 10px;
        }

        .back-btn {
            width: 150px;
            height: 44px;
            font-size: 14px !important;
        }
    </style>
@endpush
@push('after-script')
    {{-- <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script> --}}
    {{-- <script src="https://unpkg.com/filepond-plugin-file-rename/dist/filepond-plugin-file-rename.js"></script> --}}

    <script>
        // Get a reference to the file input element
        const inputElement = document.querySelector('.my-pond');
        // FilePond.registerPlugin(FilePondPluginFileRename);
        // Create a FilePond instance
        const pond = FilePond.create(inputElement);
        pond.setOptions({
            maxFiles: 30,
            required: true,
            allowMultiple: true,
            dropValidation: true,
            checkValidity: true,
            instantUpload: true,
            server: {
                url: 'http://192.168.33.10',
                process: './process.php',
                revert: './revert.php',
            },
            // acceptedFileTypes: ['image/*']
        });
        $(document).ready(function() {

            $('.btn-action.assign').on('click', assignButton)
            $('.btn-action.unassign').on('click', unassignButton)

            function assignButton() {
                $(this).removeClass('btn-outline-primary assign');
                $(this).addClass('btn-primary unassign');
                $(this).html('Unassign');
                $(this).off('click');
                $('.btn-action.unassign').on('click', unassignButton)
            }

            function unassignButton() {
                $(this).off('click');
                $(this).removeClass('btn-primary unassign');
                $(this).addClass('btn-outline-primary assign');
                $(this).html('Assign');
                $('.btn-action.assign').on('click', assignButton)
            }

            $('.action-icon.delete').on('click', function() {
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
                        const id = $(this).data('btn-id');
                        $('.file-row[data-id="' + id + '"]').remove();
                        if ($('.file-row').length === 0) {
                            $('.empty-state').show();
                        } else {
                            $('.empty-state').hide();
                        }
                    }
                })
                // Swal.fire({
                //     position: 'center',
                //     icon: 'success',
                //     title: 'Changes Done',
                //     heightAuto: false,
                //     width: '1000px',
                //     showConfirmButton: false,
                //     timer: 1500
                // })

            })
            let id = '';
            $('.action-icon.edit').on('click', function(event) {
                event.stopPropagation();
                id = $(this).data('btn-id');
                const name = $('.file-row[data-id="' + id + '"]').find('.file-name')
                $(this).hide();
                $(this).next().hide();
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
            })
            $('.file-row:not([data-id="' + id + '"])').on('click', function(event) {
                event.stopPropagation();
            })
            $(document).on('click', changeName);
            $(document).on('keypress', function(e) {
                if (e.which == 13) {
                    changeName();
                }
            });
            $('.back-btn').on('click', function() {
                $(this).removeClass('active');
                $('.folder .nav.active').removeClass('active');
            })

            function invalidName(str) {
                var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
                var onlySpaces = str.trim().length === 0;
                console.log('only spaces: ', onlySpaces);
                if (format.test(str) || onlySpaces) {
                    return true;
                } else {
                    return false;
                }
            }

            function changeName() {
                let fileName = '';
                fileName = $('.file-row.active .file-name-input').val();
                if (fileName != undefined) {
                    if (fileName === '' || invalidName(fileName)) {
                        $('.file-row[data-id="' + id + '"] .tooltiptext').addClass("show");
                        $('.file-row[data-id="' + id + '"] .file-name-input').focus();
                        return false;
                    } else {
                        const input = $('.file-row[data-id="' + id + '"] .file-name-input')
                        input.hide();
                        const name = $('.file-row[data-id="' + id + '"] .file-name')
                        name.show();
                        name.next().show();
                        name.html(fileName.trim());
                        $('.edit-btn[data-btn-id="' + id + '"]').show();
                        const icon = $('.file-row[data-id="' + id + '"] .action-icon');
                        icon.show();
                        $('.file-row').removeClass('active avoid-clicks')
                        $('.tooltiptext').removeClass("show");
                        id = '';
                        Toast.fire({
                            icon: 'success',
                            title: 'File Renamed Successfully',
                            timer: 1500
                        })
                        return true;
                    }
                } else return true

                return true;
            }

        })
    </script>
@endpush
