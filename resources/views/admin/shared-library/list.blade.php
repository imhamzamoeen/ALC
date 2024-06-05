@extends('admin.layouts.admin_master',['page' => $module_slug, 'action' => ''])

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
                            <label class="form-label fw-bold">Status:</label>
                            <div>
                                <select class="form-select form-select-solid" data-kt-select2="true" name="status"  data-placeholder="Select option" data-dropdown-parent="#kt_menu_616d17d195841" data-allow-clear="true">
                                    <option></option>
                                    @foreach(\App\Classes\Enums\StatusEnum::$Statuses as $status)
                                        <option value="{{ $status }}" @if(request()->get('status') == $status) selected @endif>{{ beautify_slug($status) }}</option>
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
        <a href="{{ route(auth()->user()->user_type.'.'.$module_slug.'.add') }}" class="btn btn-sm btn-primary">Create</a>
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
														<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
														<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
													</svg>
												</span>
                    <!--end::Svg Icon-->
                    <input type="text" data-kt-filemanager-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Files &amp; Folders" />
                </div>
                <!--end::Search-->
            </div>

        <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-filemanager-table-toolbar="base">
                    <!--begin::Export-->
                    <div class="card-toolbar me-3">
                        <div class="d-flex justify-content-end align-items-center">
                            @include('admin.partials.bulk-actions')
                        </div>
                    </div>
                    <button  class="btn btn-light-primary me-3" id="kt_file_manager_new_folder">
                        <!--begin::Svg Icon | path: icons/duotune/files/fil013.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="black" />
                                <path d="M10.4 3.60001L12 6H21C21.6 6 22 6.4 22 7V19C22 19.6 21.6 20 21 20H3C2.4 20 2 19.6 2 19V4C2 3.4 2.4 3 3 3H9.2C9.7 3 10.2 3.20001 10.4 3.60001ZM16 12H13V9C13 8.4 12.6 8 12 8C11.4 8 11 8.4 11 9V12H8C7.4 12 7 12.4 7 13C7 13.6 7.4 14 8 14H11V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V14H16C16.6 14 17 13.6 17 13C17 12.4 16.6 12 16 12Z" fill="black" />
                                <path opacity="0.3" d="M11 14H8C7.4 14 7 13.6 7 13C7 12.4 7.4 12 8 12H11V14ZM16 12H13V14H16C16.6 14 17 13.6 17 13C17 12.4 16.6 12 16 12Z" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->New Folder
                    </button>
                </div>
                <!--end::Toolbar-->
                <!--begin::Group actions-->
                <div class="d-flex justify-content-end align-items-center d-none" data-kt-filemanager-table-toolbar="selected">
                    <div class="fw-bolder me-5">
                        <span class="me-2" data-kt-filemanager-table-select="selected_count"></span>Selected</div>
                    <button  class="btn btn-danger" data-kt-filemanager-table-select="delete_selected">Delete Selected</button>
                </div>
                <!--end::Group actions-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body">
            <!--begin::Table header-->
            <div class="d-flex flex-stack">
                <!--begin::Folder path-->
                <div class="badge badge-lg badge-light-primary">
                    <div class="d-flex align-items-center flex-wrap">
                        <a href="#">{{ $module_title }}</a>
                    </div>
                </div>
                <!--end::Folder path-->
                <!--begin::Folder Stats-->
                <div class="badge badge-lg badge-primary">
                    <span id="kt_file_manager_items_counter">{{ \App\Models\SharedLibrary::count() }} folders</span>
                </div>
                <!--end::Folder Stats-->
            </div>
            <!--end::Table header-->
            <!--begin::Table-->
            <table id="folders-table" data-kt-filemanager-table="folders" class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                    <th class="w-10px pe-2">
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_file_manager_list .form-check-input" value="1"/>
                        </div>
                    </th>
                    <th class="min-w-250px">Name</th>
                    <th class="min-w-10px">Files</th>
                    <th style="width: 40%">Assign To Teacher</th>
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
                                <td data-order="account" id="edit-folder-row-{{$row->id}}">
                                    <div class="d-flex align-items-center" id="title-td-{{$row->id}}">
                                        <i class="fas fa-folder height-100px color-primary" style="font-size: 20px"></i>
                                        <a href="{{ route(auth()->user()->user_type.'.shared-library.folderFiles', $row->slug  ) }}" class="text-gray-800 text-hover-primary ms-3">{{ $row->title }}</a>
                                    </div>

                                    <div class="align-items-center d-none" id="edit-form-{{ $row->id }}">
                                        <span class="svg-icon svg-icon-2x svg-icon-primary me-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="black"/>
                                                <path d="M9.2 3H3C2.4 3 2 3.4 2 4V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V7C22 6.4 21.6 6 21 6H12L10.4 3.60001C10.2 3.20001 9.7 3 9.2 3Z" fill="black"/>
                                            </svg>
                                        </span>
                                        <!-- simple form -->
                                        <form id="edit-folder-form-{{$row->id}}" class="" role="form" method="post" action="{{ route(auth()->user()->user_type.'.shared-library.update') }}">@csrf

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
                                <td>{{ $row->files->count() ?? '--' }}</td>
                                <td>
                                    @include('admin.shared-library.components.assign_teacher')
                                </td>
                                <td>{{ $row->updated_at->diffForHumans() }}</td>
                                <td>
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

                                <!--end::Actions-->
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
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>

    <table class="d-none" id="add-new-folder-sec">
        <tr id="kt_file_manager_new_folder_row" data-kt-filemanager-template="upload">
            <td></td>
            <td id="kt_file_manager_add_folder_form" class="fv-row">
                <div class="d-flex align-items-center">
                    <span class="svg-icon svg-icon-2x svg-icon-primary me-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="black"/>
                            <path d="M9.2 3H3C2.4 3 2 3.4 2 4V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V7C22 6.4 21.6 6 21 6H12L10.4 3.60001C10.2 3.20001 9.7 3 9.2 3Z" fill="black"/>
                        </svg>
                    </span>
                    <!-- simple form -->
                    <form id="add-folder-form" class="" role="form" method="post" action="{{ route(auth()->user()->user_type.'.'.$module_slug.'.addFolder') }}">@csrf

                    <input type="text" name="new_folder_name" placeholder="Enter the folder name" class="form-control mw-250px me-3"/></form>
                    <button type="submit" form="add-folder-form" class="btn btn-icon btn-light-primary me-3 ms-3">
                        <span class="indicator-label">
                            <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M9.89557 13.4982L7.79487 11.2651C7.26967 10.7068 6.38251 10.7068 5.85731 11.2651C5.37559 11.7772 5.37559 12.5757 5.85731 13.0878L9.74989 17.2257C10.1448 17.6455 10.8118 17.6455 11.2066 17.2257L18.1427 9.85252C18.6244 9.34044 18.6244 8.54191 18.1427 8.02984C17.6175 7.47154 16.7303 7.47154 16.2051 8.02984L11.061 13.4982C10.7451 13.834 10.2115 13.834 9.89557 13.4982Z" fill="black"/>
                                </svg>
                            </span>
                        </span>
                    </button>
                    <button class="btn btn-icon btn-light-danger" id="kt_file_manager_cancel_folder">
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
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
@endsection
@push('after-script')
        <script src="{{ asset('admin-assets/js/datatables.bundle.js') }}"></script>
    {{--<script src="{{ asset('admin-assets/js/list.js') }}"></script>--}}
    <script>
        $('.delete-btn').on('click', function () {
            Swal.fire({
                text: 'Are you sure you want to delete "'+ $(this).data('name') +'" folder?</br>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace('{{ URL::to('admin/'.$module_slug.'/destroy') }}/' + $(this).data('id'))
                }

            })
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

        $('#kt_file_manager_new_folder').on('click', function () {
            var html = $('#add-new-folder-sec tr')
            $('#folders-table tbody tr:first').before(html)
        })

        $('#kt_file_manager_cancel_folder').on('click', function () {
            $('#add-new-folder-sec').html($('#kt_file_manager_new_folder_row'))
        })

        $('.edit-cancel-btn').on('click', function () {
            var id = $(this).data('id');

            $('#edit-form-'+id).removeClass('d-flex').addClass('d-none')
            $('#title-td-'+id).removeClass('d-none').addClass('d-flex')
        })
    </script>

    <script>
        $('.select3-multiple').select2({
            placeholder: 'Select teachers to assign',
            closeOnSelect: false,

            initSelection: function(element, callback) {
            }
        });
    </script>

@endpush
