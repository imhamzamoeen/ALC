@extends('admin.layouts.admin_master', ['page' => $module_slug, 'action' => ''])

@section('actions')
    <div class="d-flex align-items-center py-1">
        <div class="me-4">
            <a href="#" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder" data-kt-menu-trigger="click"
                data-kt-menu-placement="bottom-end">
                <span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                            fill="black" />
                    </svg>
                </span>Filter
            </a>
            <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_616d17d195841">
                <form id="filter-form" method="get" action="{{ url()->current() }}">
                    <div class="px-7 py-5">
                        <div class="fs-5 text-dark fw-bolder">Filter Options</div>
                    </div>
                    <div class="separator border-gray-200"></div>
                    <div class="px-7 py-5">
                        <div class="mb-10">
                            <label class="form-label fw-bold">Status:</label>
                            <div>
                                <select class="form-select form-select-solid" data-kt-select2="true" name="status"
                                    data-placeholder="Select option" data-dropdown-parent="#kt_menu_616d17d195841"
                                    data-allow-clear="true">
                                    <option></option>
                                    @foreach (\App\Classes\Enums\StatusEnum::$Statuses as $status)
                                        <option value="{{ $status }}"
                                            @if (request()->get('status') == $status) selected @endif>{{ beautify_slug($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- <div class="mb-10">
                            <label class="form-label fw-bold">User Type:</label>
                            <div>
                                <select class="form-select form-select-solid" data-kt-select2="true" name="user_type" data-placeholder="Select option" data-dropdown-parent="#kt_menu_616d17d195841" data-allow-clear="true">
                                    <option></option>
                                    @foreach (\App\Classes\Enums\UserTypesEnum::$row_TYPES as $type)
                                        <option value="{{ $type }}" @if (request()->get('user_type') == $type) selected @endif>{{ beautify_slug($type) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                        <div class="d-flex justify-content-end">
                            <a href="{{ URL::current() }}">
                                <span class="btn btn-sm btn-light btn-active-light-primary me-2"
                                    data-kt-menu-dismiss="true">Reset</span>
                            </a>
                            <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Apply</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <a href="{{ route('admin' . '.' . $module_slug . '.add') }}" class="btn btn-sm btn-primary">Create</a>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1 mr-2   ">
                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                transform="rotate(45 17.0365 15.1223)" fill="black"></rect>
                            <path
                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                fill="black"></path>
                        </svg>
                    </span>
                    <input form="filter-form" name="title" type="text" data-kt-user-table-filter="search"
                        class="form-control form-control-solid w-250px ps-14" placeholder="Search {{ $module_title }}"
                        value="{{ request()->get('title') }}">
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end align-items-center">
                    @include('admin.partials.bulk-actions')
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer" id="kt_table_users">
                        <thead>
                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                <th class="w-10px pe-2 sorting_disabled" rowspan="1" colspan="1" aria-label=""
                                    style="width: 29.25px;">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                                            data-kt-check-target="#kt_table_users .form-check-input" value="1">
                                    </div>
                                </th>
                                <th class="min-w-50px" tabindex="0" aria-controls="kt_table_users" rowspan="1"
                                    colspan="1" aria-label="Id: activate to sort column ascending" style="width: 50px;">
                                    Id
                                </th>
                                <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1"
                                    colspan="1" aria-label="User: activate to sort column ascending"
                                    style="width: 257.5px;">
                                    Title
                                </th>
                                <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_table_users"
                                    rowspan="1" colspan="1"
                                    aria-label="User Type: activate to sort column ascending" style="width: 145.25px;">
                                    Description
                                </th>
                                <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_table_users"
                                    rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending"
                                    style="width: 145.25px;">
                                    Status
                                </th>
                                <th class="text-end min-w-100px sorting_disabled" rowspan="1" colspan="1"
                                    aria-label="Actions" style="width: 113.531px;">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-bold">
                            @foreach ($data as $row)
                                <tr class="odd">
                                    <td>
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" name="ids[]" type="checkbox"
                                                value="{{ $row->id }}" form="bulk-action">
                                        </div>
                                    </td>
                                    <td>
                                        {{ $row->id }}
                                    </td>
                                    <td class="d-flex align-items-center">
                                        <div class="d-flex flex-column">
                                            <a href="{{ route('admin' . '.' . $module_slug . '.view', $row->id) }}"
                                                class="text-gray-800 text-hover-primary mb-1">{{ $row->title ?? '--' }}</a>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $row->description }}
                                    </td>
                                    <td>
                                        <div
                                            class="badge badge-light-{{ \App\Classes\Enums\StatusEnum::$Status_color[$row->status] }} fw-bolder">
                                            {{ beautify_slug($row->status) }}
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            Actions
                                            <span class="svg-icon svg-icon-5 m-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                        fill="black"></path>
                                                </svg>
                                            </span>
                                        </a>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                            data-kt-menu="true">
                                            <div class="menu-item px-3">
                                                <a href="{{ route('admin' . '.' . $module_slug . '.edit', $row->id) }}"
                                                    class="menu-link px-3">Edit</a>
                                            </div>
                                            <div class="menu-item px-3">
                                                <a href="javascript:void(0);" data-name="{{ $row->title }}"
                                                    data-id="{{ $row->id }}"
                                                    class="menu-link px-3 delete-btn">Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if (!count($data))
                        <div class="text-muted text-center"> <strong>No Records Found!</strong></div>
                    @endif
                </div>
                <div class="row">
                    <div
                        class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start">
                    </div>
                    <div
                        class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                        <div class="dataTables_paginate paging_simple_numbers" id="kt_table_users_paginate">
                            {!! $data->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('after-script')
    <script>
        $('.delete-btn').on('click', function() {
            Swal.fire({
                text: 'Are you sure you want to delete "' + $(this).data('name') + '" course?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace('{{ URL::to('admin/' . $module_slug . '/destroy') }}/' + $(this)
                        .data('id'))
                }
            })
        })
    </script>
@endpush
