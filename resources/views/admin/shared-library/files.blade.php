@extends('admin.layouts.admin_master',['page' => $module_slug, 'action' => @$folder->title])

@section('actions')
    <div class="d-flex align-items-center py-1">
        <div class="me-4">
            <a href="#" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                <span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="black" />
                    </svg>
                </span>Filter
            </a>
            <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_616d17d195841">
                <form id="filter-form" method="get" action="{{ url()->current() }}" >
                    <div class="px-7 py-5">
                        <div class="fs-5 text-dark fw-bolder">Filter Options</div>
                    </div>
                    <div class="separator border-gray-200"></div>
                    <div class="px-7 py-5">
                        <div class="mb-10">
                            <label class="form-label fw-bold">File Type:</label>
                            <div>
                                <select class="form-select form-select-solid" data-kt-select2="true" name="file_type"  data-placeholder="Select option" data-dropdown-parent="#kt_menu_616d17d195841" data-allow-clear="true">
                                    <option></option>
                                    @foreach(\App\Classes\AlQuranConfig::$File_Type as $key => $file)
                                        <option value="{{ $key }}" @if(request()->get('status') == $key) selected @endif>{{ beautify_slug($key) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{--<div class="mb-10">
                            <label class="form-label fw-bold">User Type:</label>
                            <div>
                                <select class="form-select form-select-solid" data-kt-select2="true" name="user_type" data-placeholder="Select option" data-dropdown-parent="#kt_menu_616d17d195841" data-allow-clear="true">
                                    <option></option>
                                    @foreach(\App\Classes\Enums\UserTypesEnum::$row_TYPES as $type)
                                        <option value="{{ $type }}" @if(request()->get('user_type') == $type) selected @endif>{{ beautify_slug($type) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>--}}
                        <div class="d-flex justify-content-end">
                            <a href="{{ URL::current() }}">
                                <span class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">Reset</span>
                            </a>
                            <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Apply</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header pt-8">
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black"></rect>
                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black"></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <input form="filter-form" name="title" type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search {{ $module_title }}" value="{{ request()->get('title') }}">
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="card-toolbar me-3">
                    <div class="d-flex justify-content-end align-items-center">
                        @include('admin.partials.bulk-actions', ['action' => 'bulkFileAction'])
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button  class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_upload">
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="black"></path>
                                <path d="M10.4 3.60001L12 6H21C21.6 6 22 6.4 22 7V19C22 19.6 21.6 20 21 20H3C2.4 20 2 19.6 2 19V4C2 3.4 2.4 3 3 3H9.20001C9.70001 3 10.2 3.20001 10.4 3.60001ZM16 11.6L12.7 8.29999C12.3 7.89999 11.7 7.89999 11.3 8.29999L8 11.6H11V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V11.6H16Z" fill="black"></path>
                                <path opacity="0.3" d="M11 11.6V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V11.6H11Z" fill="black"></path>
                            </svg>
                        </span>Upload Files
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex flex-stack">
                <div class="badge badge-lg badge-light-primary">
                    <div class="d-flex align-items-center flex-wrap">
                        <a href="{{ route(auth()->user()->user_type.'.'.$module_slug.'.list') }}">{{ $module_title }}</a>
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                        <span class="svg-icon svg-icon-2 svg-icon-primary mx-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <a href="#">{{ $folder->title }}</a>
                    </div>
                </div>
                <div class="badge badge-lg badge-primary">
                    <span id="kt_file_manager_items_counter">{{ $folder->files->count() }} items</span>
                </div>
            </div>
            <table id="kt_file_manager_list" data-kt-filemanager-table="folders" class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                    <th class="w-10px pe-2">
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_file_manager_list .form-check-input" value="1"/>
                        </div>
                    </th>
                    <th class="min-w-150px">Title</th>
                    <th class="min-w-10px">File Type</th>
                    <th class="min-w-10px">Size</th>
                    <th class="min-w-125px">Last Modified</th>
                    <th class="w-125px"></th>
                </tr>
                </thead>
                <tbody class="fw-bold text-gray-600">
                @if(count($data))
                    @foreach($data as $row)
                    <tr>
                        <td>
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" name="ids[]" type="checkbox" value="{{ $row->id }}" form="bulk-action">
                            </div>
                        </td>
                        <td data-order="account">
                            <div class="d-flex align-items-center" id="title-td-{{$row->id}}">
                                <i class="fas fa-file{{ \App\Classes\AlQuranConfig::$File_Type_Icon[@$row->file_type] ?? '-alt' }} height-100px color-primary" style="font-size: 20px"></i>
                                <a href="{{ route(auth()->user()->user_type.'.shared-library.folderFiles', $row->slug  ) }}" class="text-gray-800 text-hover-primary ms-3">{{ $row->title }}</a>
                            </div>

                            <div class="align-items-center d-none" id="edit-form-{{ $row->id }}">
                                    <i class="fas fa-file{{ \App\Classes\AlQuranConfig::$File_Type_Icon[@$row->file_type] ?? '-alt' }} height-100px color-primary me-3" style="font-size: 20px"> </i>
                                <!-- simple form -->
                                <form id="edit-folder-form-{{$row->id}}" class="" role="form" method="post" action="{{ route(auth()->user()->user_type.'.shared-library.updateFile') }}">@csrf

                                    <input type="text" name="title" value="{{ $row->title }}" placeholder="Enter the folder name" class="form-control mw-250px me-3"/>
                                    <input type="hidden" name="id" value="{{ $row->id }}">
                                </form>
                                <button type="submit" class="btn btn-icon btn-light-primary me-3 ms-3" form="edit-folder-form-{{$row->id}}">
                                        <span class="indicator-label">
                                            <span class="svg-icon svg-icon-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M9.89557 13.4982L7.79487 11.2651C7.26967 10.7068 6.38251 10.7068 5.85731 11.2651C5.37559 11.7772 5.37559 12.5757 5.85731 13.0878L9.74989 17.2257C10.1448 17.6455 10.8118 17.6455 11.2066 17.2257L18.1427 9.85252C18.6244 9.34044 18.6244 8.54191 18.1427 8.02984C17.6175 7.47154 16.7303 7.47154 16.2051 8.02984L11.061 13.4982C10.7451 13.834 10.2115 13.834 9.89557 13.4982Z" fill="black"/>
                                                </svg>
                                            </span>
                                        </span>
                                </button>
                                <button class="btn btn-icon btn-light-danger edit-cancel-btn" data-id="{{ $row->id }}">
                                        <span class="indicator-label">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr088.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="black"></rect>
                                <rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="black"></rect>
                            </svg>
                        </span>
                                            <!--end::Svg Icon-->
                    </span>
                                </button>
                            </div>
                        </td>
                        <td><span class="badge badge-light-{{ \App\Classes\AlQuranConfig::$File_Type[@$row->file_type] ?? 'info' }}">.{{ $row->file_type ?? '--' }}</span></td>
                        <td><span class="badge badge-light-info">{{ humanFileSize($row->file_size) ?? '--' }}</span></td>
                        <td>{{ $row->updated_at->diffForHumans() }}</td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end">
                                <div class="ms-2">
                                        <span id="abcd" class="btn btn-sm btn-icon btn-light btn-active-light-primary btn-edit-folder" data-id="{{ $row->id }}" data-title="{{ $row->title }}">
                                           <i class="fas fa-pen-alt"></i>
                                        </span>
                                </div>
                                <div class="ms-2">
                                    <button  data-name="{{ $row->title }}" data-id="{{ $row->id }}" class="btn btn-sm btn-icon btn-light delete-btn btn-active-light-primary">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @else
                    <tr></tr>
                @endif
                </tbody>
                <!--end::Table body-->
            </table>
            @if(!count($data))
                <div class="text-muted text-center"> <strong>No Records Found!</strong></div>
            @endif
        </div>
    </div>
    <div class="modal fade" id="kt_modal_upload" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <form class="form" method="post" action="{{ route(auth()->user()->user_type.'.shared-library.addFile', $folder->id) }}" id="kt_modal_upload_form" enctype="multipart/form-data">@csrf
                    <div class="modal-header">
                        <h2 class="fw-bolder">Upload files</h2>
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                            <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="modal-body pt-10 pb-15 px-lg-17">
                        <div class="form-group">
                            <div class="dropzone dropzone-queue mb-2">
                                <div class="fv-row mb-7 fv-plugins-icon-container">
                                    <label class="required fw-bold fs-6 mb-2">Title</label>
                                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror form-control-solid mb-3 mb-lg-0" placeholder="Title" value="{{ old('title', @$data->title) }}" required>
                                    @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="dropzone-panel mb-4">
                                    <a class="dropzone-select btn btn-sm btn-primary me-2" onclick="$('#file_input').click()">Attach file</a>
                                    <input class="d-none" type="file" name="file" id="file_input" value=""  placeholder=""/>
                                </div>
                                <div class="dropzone-items wm-200px">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="dropzone-select btn btn-sm btn-primary me-2">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('after-script')
    <script>
        $('.delete-btn').on('click', function () {
            Swal.fire({
                html: 'Are you sure you want to delete "'+ $(this).data('name') +'" file?</br>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace('{{ URL::to('admin/'.$module_slug.'/file/destroy') }}/' + $(this).data('id'))
                }
            })
        })

        $('#file_input').on('change', function () {
            var fileInput = document.getElementById('file_input');
            var _size = fileInput.files[0].size;
            var _name = fileInput.files[0].name;
            var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
                i=0;while(_size>900){_size/=1024;i++;}
            var exactSize = (Math.round(_size*100)/100)+' '+fSExt[i];
            $('.dropzone-items').html('<div class="dropzone-item p-5">\n' +
    '                                        <div class="dropzone-file">\n' +
    '                                            <div class="dropzone-filename text-dark" title="some_image_file_name.jpg">\n' +
    '                                                <span data-dz-name="">'+_name+'</span>\n' +
    '                                                <strong>(\n' +
    '                                                    <span data-dz-size="">'+exactSize+'</span>)</strong>\n' +
    '                                            </div>\n' +
    '                                            <div class="dropzone-error mt-0" data-dz-errormessage=""></div>\n' +
    '                                        </div>\n' +
    '                                    </div>' +
                '')
        })
        @if ($errors->any())
            @foreach ($errors->all() as $error)
            toastr['error']("{{ $error }}", 'Error!');
        @endforeach
        @endif

        $('.btn-edit-folder').on('click', function () {
            var title = $(this).data('title');
            var id = $(this).data('id');

            $('#title-td-'+id).removeClass('d-flex').addClass('d-none')
            $('#edit-form-'+id).removeClass('d-none').addClass('d-flex')

            $('#edit-folder-form-'+id+' input[name="title"]').focus().select()
        })

        $('.edit-cancel-btn').on('click', function () {
            var id = $(this).data('id');

            $('#edit-form-'+id).removeClass('d-flex').addClass('d-none')
            $('#title-td-'+id).removeClass('d-none').addClass('d-flex')
        })
    </script>

@endpush
