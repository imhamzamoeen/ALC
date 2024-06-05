@extends('admin.layouts.admin_master', ['page' => 'Class Schedule', 'action' => ''])
@section('content')
    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
        <!--begin:::Tab item-->
        <li class="nav-item">
            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                href="#kt_user_view_overview_events_and_logs_tab">Live Classes</a>
        </li>
        <!--end:::Tab item-->
        <!--begin:::Tab item-->
        <li class="nav-item">
            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_user_view_overview_tab">Previous
                Classes</a>
        </li>
        <!--end:::Tab item-->
    </ul>
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
                    <input form="filter-form" name="name" type="text" data-kt-user-table-filter="search"
                        class="form-control form-control-solid w-250px ps-14" placeholder="Search user"
                        value="{{ request()->get('name') }}">
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end align-items-center">
                    {{-- @include('admin.partials.bulk-actions') --}}
                </div>
            </div>
        </div>
        <div class="flex-lg-row-fluid ms-lg-15">
            <!--begin:::Tabs-->

            <!--end:::Tabs-->
            <!--begin:::Tab content-->
            <div class="tab-content" id="myTabContent">

                <!--begin:::Tab pane-->
                <div class="tab-pane fade active show" id="kt_user_view_overview_events_and_logs_tab" role="tabpanel">
                    <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer"
                                id="kt_table_users">
                                <thead>
                                    <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-50px" tabindex="0" rowspan="1" colspan="1"
                                            aria-label="Id: activate to sort column ascending" style="width: 130px;">
                                            Date & Time
                                        </th>
                                        <th class="min-w-50px sorting" tabindex="0" rowspan="1" colspan="1"
                                            aria-label="User: activate to sort column ascending" style="width: 130px;">
                                            Teacher Name
                                        </th>
                                        <th class="min-w-50px sorting" tabindex="0" rowspan="1" colspan="1"
                                            aria-label="User Type: activate to sort column ascending"
                                            style="width: 145.25px;">
                                            Student Name
                                        </th>
                                        {{-- <th class="min-w-50px sorting" tabindex="0" rowspan="1" colspan="1"
                                            aria-label="Phone: activate to sort column ascending" style="width: 130px;">
                                            Student Number
                                        </th> --}}
                                        <th class="min-w-50px sorting" tabindex="0" rowspan="1" colspan="1"
                                            aria-label="Phone: activate to sort column ascending" style="width: 130px;">
                                            Student Reg No
                                        </th>
                                        <th class="min-w-50px sorting" tabindex="0" rowspan="1" colspan="1"
                                            aria-label="Status: activate to sort column ascending" style="width: 130px;">
                                            Course
                                        </th>
                                        <th class="min-w-50px sorting" tabindex="0" rowspan="1" colspan="1"
                                            aria-label="Status: activate to sort column ascending" style="width: 200px;">
                                            Attendance
                                        </th>

                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 fw-bold">
                                    <tr class="odd">
                                        <td>
                                            {{-- <div class="text-sb me-2">{{ $class->class_time->format('D d M') }}</div>
                                                            <div>{{ $class->class_time->format('h:i A') }}</div> --}}
                                            <div class="text-sb me-2">22 June 2022</div>
                                            <div>11:30 PM</div>
                                        </td>
                                        <td>
                                            <div>
                                                Noman Ali
                                            </div>
                                        </td>
                                        <td class="d-flex align-items-center">
                                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                <a href="">
                                                    <div class="symbol-label">
                                                        HM
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <a href="" class="text-gray-800 text-hover-primary mb-1">Haroon
                                                    Mukhtar</a>
                                                <span>haroon@gmail.com</span>
                                            </div>
                                        </td>
                                        {{-- <td>
                                            <div>
                                                03066661223
                                            </div>
                                        </td> --}}
                                        <td>
                                            <div>
                                                FA17-BCS-161
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                Tajweed
                                            </div>
                                        </td>
                                        <td>
                                            <div class="attendance attended ps-8"><span></span>Teacher
                                                Attended</div>
                                            <div class="attendance unattended ps-8"><span></span>Student
                                                UnAttended</div>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="row">
                            <div
                                class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start">
                            </div>
                            <div
                                class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                                <div class="dataTables_paginate paging_simple_numbers" id="kt_table_users_paginate">
                                    fasdf
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end:::Tab pane-->
                <!--begin:::Tab pane-->
                <div class="tab-pane fade" id="kt_user_view_overview_tab" role="tabpanel">

                    <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer"
                                id="kt_table_users">
                                <thead>
                                    <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-50px" tabindex="0" rowspan="1" colspan="1"
                                            aria-label="Id: activate to sort column ascending" style="width: 130px;">
                                            Date & Time
                                        </th>
                                        <th class="min-w-50px sorting" tabindex="0" rowspan="1" colspan="1"
                                            aria-label="User: activate to sort column ascending" style="width: 130px;">
                                            Teacher Name
                                        </th>
                                        <th class="min-w-50px sorting" tabindex="0" rowspan="1" colspan="1"
                                            aria-label="User Type: activate to sort column ascending"
                                            style="width: 145.25px;">
                                            Student Name
                                        </th>
                                        {{-- <th class="min-w-50px sorting" tabindex="0" rowspan="1" colspan="1"
                                            aria-label="Phone: activate to sort column ascending" style="width: 130px;">
                                            Student Number
                                        </th> --}}
                                        <th class="min-w-50px sorting" tabindex="0" rowspan="1" colspan="1"
                                            aria-label="Phone: activate to sort column ascending" style="width: 130px;">
                                            Student Reg No
                                        </th>
                                        <th class="min-w-50px sorting" tabindex="0" rowspan="1" colspan="1"
                                            aria-label="Status: activate to sort column ascending" style="width: 130px;">
                                            Course
                                        </th>
                                        <th class="min-w-50px sorting" tabindex="0" rowspan="1" colspan="1"
                                            aria-label="Status: activate to sort column ascending" style="width: 130px;">
                                            Duration
                                        </th>
                                        <th class="min-w-50px sorting" tabindex="0" rowspan="1" colspan="1"
                                            aria-label="Status: activate to sort column ascending" style="width: 200px;">
                                            Status
                                        </th>

                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 fw-bold">
                                    <tr class="odd">
                                        <td>
                                            {{-- <div class="text-sb me-2">{{ $class->class_time->format('D d M') }}</div>
                                            <div>{{ $class->class_time->format('h:i A') }}</div> --}}
                                            <div class="text-sb me-2">22 June 2022</div>
                                            <div>11:30 PM</div>
                                        </td>
                                        <td>
                                            <div>
                                                Noman Ali
                                            </div>
                                        </td>
                                        <td class="d-flex align-items-center">
                                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                <a href="">
                                                    <div class="symbol-label">
                                                        HM
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <a href="" class="text-gray-800 text-hover-primary mb-1">Haroon
                                                    Mukhtar</a>
                                                <span>haroon@gmail.com</span>
                                            </div>
                                        </td>
                                        {{-- <td>
                                            <div>
                                                03066661223
                                            </div>
                                        </td> --}}
                                        <td>
                                            <div>
                                                FA17-BCS-161
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                Tajweed
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                11:00:00
                                            </div>
                                        </td>
                                        <td>
                                            <div class="badge badge-light-success fw-bolder">
                                                Attended
                                            </div>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="row">
                            <div
                                class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start">
                            </div>
                            <div
                                class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                                <div class="dataTables_paginate paging_simple_numbers" id="kt_table_users_paginate">
                                    fasdf
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end:::Tab pane-->
            </div>
            <!--end:::Tab content-->
        </div>
    </div>
@endsection
@push('after-css')
    <style>
        .attendance {
            position: relative;
        }

        .attendance>span {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #CCCACA;
            position: absolute;
            left: 15px;
            top: 5px;
        }

        .attendance.attended {
            color: #559739;
        }

        .attendance.unattended {
            color: #FF3B3B;
        }

        .attendance.attended>span {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #559739;
            position: absolute;
            left: 15px;
            top: 5px;
        }

        .attendance.unattended>span {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #FF3B3B;
            position: absolute;
            left: 15px;
            top: 5px;
        }
    </style>
@endpush
