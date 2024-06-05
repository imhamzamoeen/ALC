@extends('admin.layouts.admin_master',['page' => $module_slug, 'action' => ''])

@section('content')
    <div class="d-flex flex-column flex-xl-row">
    <div class="flex-column flex-lg-row-auto w-100 w-lg-300px mb-10">
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title">
                    <h2 class="mb-0">{{ beautify_slug($role->name) }}</h2>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Permissions-->
                <div class="d-flex flex-column text-gray-600">
                    @foreach($role->permissions as $key => $permission)
                        <div class="d-flex align-items-center py-2">
                            <span class="bullet bg-primary me-3"></span>{{ beautify_slug($permission->name) }}
                        </div>
                    @endforeach
                </div>
                <!--end::Permissions-->
            </div>
            <!--end::Card body-->
            <!--begin::Card footer-->
            <div class="card-footer pt-0">
                <a href="{{ route(auth()->user()->user_type.'.'.$module_slug.'.assign', $role->id) }}" class="btn btn-light btn-active-primary">Edit Permissions</a>
            </div>
            <!--end::Card footer-->
        </div>
    </div>
    <div class="flex-lg-row-fluid ms-lg-10">
        <!--begin::Card-->
        <div class="card card-flush mb-6 mb-xl-9">
            <!--begin::Card header-->
            <div class="card-header pt-5">
                <div class="card-title">
                    <h2 class="d-flex align-items-center">Users Assigned
                        <span class="text-gray-600 fs-6 ms-1">({{ $role->users->count() }})</span>
                    </h2>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="table-responsive"><table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer" id="kt_table_users">
                            <thead>
                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                <th class="w-10px pe-2 sorting_disabled" rowspan="1" colspan="1" aria-label="" style="width: 29.25px;">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_users .form-check-input" value="1">
                                    </div>
                                </th>
                                <th class="min-w-50px" tabindex="0" aria-controls="kt_table_users" rowspan="1" colspan="1" aria-label="Id: activate to sort column ascending" style="width: 50px;">
                                    Id
                                </th>
                                <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1" colspan="1" aria-label="User: activate to sort column ascending" style="width: 257.5px;">
                                    User
                                </th>
                                <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1" colspan="1" aria-label="User Type: activate to sort column ascending" style="width: 145.25px;">
                                    User Type
                                </th>
                                <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending" style="width: 145.25px;">
                                    Phone
                                </th>
                                <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 145.25px;">
                                    Status
                                </th>
                                <th class="text-end min-w-100px sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 113.531px;">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-bold">
                                @foreach($users as $user)
                                <tr class="odd">
                                    <td>
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" name="select-check" type="checkbox" value="{{ $user->id }}">
                                        </div>
                                    </td>
                                    <td>
                                        {{ $user->id }}
                                    </td>
                                    <td class="d-flex align-items-center">
                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                            <a href="{{ route(auth()->user()->user_type.'.users.view', $user->id) }}">
                                                <div class="symbol-label">
                                                    {!! generate_profile_picture_by_name(@$user->name, 50) !!}
                                                </div>
                                            </a>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="{{ route(auth()->user()->user_type.'.users.view', $user->id) }}" class="text-gray-800 text-hover-primary mb-1">{{ $user->name ?? '--' }}</a>
                                            <span>{{ $user->email ?? '--' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="badge badge-light-{{ \App\Classes\Enums\UserTypesEnum::$USER_TYPE_COLOR[$user->user_type] ?? 'primary' }} fw-bolder">
                                            {{ beautify_slug($user->user_type) }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="badge badge-light fw-bolder">
                                            {{ $user->phone }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="badge badge-light-{{ \App\Classes\Enums\StatusEnum::$Status_color[$user->status] }} fw-bolder">
                                            {{ beautify_slug($user->status) }}
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            Actions
                                            <span class="svg-icon svg-icon-5 m-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black"></path>
                                                </svg>
                                            </span>
                                        </a>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                            <div class="menu-item px-3">
                                                <a href="{{ route(auth()->user()->user_type.'.users.edit', $user->id) }}" class="menu-link px-3">Edit</a>
                                            </div>
                                            <div class="menu-item px-3">
                                                <a href="javascript:void(0);" data-name="{{ $user->name }}" data-id="{{ $user->id }}" class="menu-link px-3 delete-btn">Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if(!count($users))
                            <div class="text-muted text-center"> <strong>No Records Found!</strong></div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"></div>
                        <div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                            <div class="dataTables_paginate paging_simple_numbers" id="kt_table_users_paginate">
                                {!! $users->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    </div>

@endsection
