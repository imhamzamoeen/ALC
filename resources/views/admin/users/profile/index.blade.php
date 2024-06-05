@extends('admin.layouts.admin_master', ['page' => 'users', 'action' => ''])

@section('content')

<div class="d-flex flex-column flex-xl-row">
    <!--begin::Sidebar-->
    <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
        <!--begin::Card-->
        <div class="card mb-5 mb-xl-8">
            <!--begin::Card body-->
            <div class="card-body">

                <!--begin::Summary-->
                <!--begin::User Info-->
                <div class="d-flex flex-center flex-column py-5">
                    <!--begin::Avatar-->
                    <div class="symbol symbol-100px symbol-circle mb-7">
                        {!! generate_profile_picture_by_name($user->name) !!}
                    </div>
                    <!--end::Avatar-->
                    <!--begin::Name-->
                    <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bolder mb-3">{{ $user->name ?? '--'
                        }}</a>
                    <!--end::Name-->
                    <!--begin::Position-->
                    <div class="mb-9">
                        <!--begin::Badge-->
                        <div
                            class="badge badge-lg badge-light-{{ \App\Classes\Enums\UserTypesEnum::$USER_TYPE_COLOR[@$user->getRoleNames()[0] ?? 'customer'] ?? 'primary' }} d-inline">
                            {{ beautify_slug($user->getRoleNames()[0]) ?? '--' }}</div>
                        <!--begin::Badge-->
                    </div>
                    <!--end::Position-->
                    <!--begin::Info-->
                    <!--begin::Info heading-->
                    @if (@$user->getRoleNames()[0] == \App\Classes\Enums\UserTypesEnum::Teacher)
                    <div class="fw-bolder mb-3">Classes
                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover" data-bs-trigger="hover"
                            data-bs-html="true"
                            data-bs-content="Number of total classes assigned, missed and taken."></i>
                    </div>
                    <!--end::Info heading-->
                    <div class="d-flex flex-wrap flex-center">
                        <!--begin::Stats-->
                        <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3">
                            <div class="fs-4 fw-bolder text-gray-700">
                                <span class="w-75px">0</span>
                                @include('admin.partials.arrow-up-success')
                            </div>
                            <div class="fw-bold text-muted">Total</div>
                        </div>
                        <!--end::Stats-->
                        <!--begin::Stats-->
                        <div class="border border-gray-300 border-dashed rounded py-3 px-3 mx-4 mb-3">
                            <div class="fs-4 fw-bolder text-gray-700">
                                <span class="w-50px">0</span>
                                @include('admin.partials.arrow-down-danger')
                            </div>
                            <div class="fw-bold text-muted">Missed</div>
                        </div>
                        <!--end::Stats-->
                        <!--begin::Stats-->
                        <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3">
                            <div class="fs-4 fw-bolder text-gray-700">
                                <span class="w-50px">0</span>
                                @include('admin.partials.arrow-up-success')
                            </div>
                            <div class="fw-bold text-muted">Taken</div>
                        </div>
                        <!--end::Stats-->
                    </div>
                    @endif
                    <!--end::Info-->
                </div>
                <!--end::User Info-->
                <!--end::Summary-->
                <!--begin::Details toggle-->
                @can('view-users')
                <div class="d-flex flex-stack fs-4 py-3">
                    <div class="fw-bolder rotate collapsible" data-bs-toggle="collapse" href="#kt_user_view_details"
                        role="button" aria-expanded="false" aria-controls="kt_user_view_details">Details
                        @include('admin.partials.arrow-dropdown')
                    </div>
                    @can('edit-users')
                    <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Edit user details">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-light-primary">Edit</a>
                    </span>
                    @endcan
                </div>
                <!--end::Details toggle-->
                <div class="separator"></div>
                <!--begin::Details content-->
                <div id="kt_user_view_details" class="collapse show">
                    <div class="pb-5 fs-6">
                        <!--begin::Details item-->
                        @if ($user->hasRole(\App\Classes\Enums\UserTypesEnum::Teacher))
                        <div class="fw-bolder mt-5">Teacher ID</div>
                        <div class="text-gray-600">{{ $user->reg_no }}</div>
                        @endif
                        <!--begin::Details item-->
                        <!--begin::Details item-->
                        <div class="fw-bolder mt-5">Email</div>
                        <div class="text-gray-600">
                            <a href="#" class="text-gray-600 text-hover-primary">{{ $user->email ?? '--' }}</a>
                        </div>
                        <!--begin::Details item-->
                        <!--begin::Details item-->
                        <div class="fw-bolder mt-5">Country</div>
                        <div class="text-gray-600">{{ $user->country ?? '--' }}</div>
                        <!--begin::Details item-->
                        <!--begin::Details item-->
                        <div class="fw-bolder mt-5">Phone</div>
                        <div class="text-gray-600">{{ $user->phone ?? '--' }}</div>

                        <div class="fw-bolder mt-5">Status</div>
                        <div class="text-gray-600"><span class="badge badge-primary">{{ beautify_slug($user->status) ??
                                '--' }}</span> | <span
                                class="badge badge-{{ $user->verified ? 'success' : 'danger' }}">{{
                                beautify_slug($user->verified ? 'verified' : 'unverified') ?? '--' }}</span>
                        </div>
                        <!--begin::Details item-->
                        <!--begin::Details item-->
                        <div class="fw-bolder mt-5">IP</div>
                        <div class="text-gray-600">{{ $user->ip ?? '--' }}</div>
                        <!--begin::Details item-->
                    </div>
                </div>
                @endcan
                <!--end::Details content-->
            </div>
            <!--end::Card body-->
        </div>

        @if ($user->hasRole(\App\Classes\Enums\UserTypesEnum::Customer))
        <div class="card">
            <div class="card-body">
                <a href="javascript:void(0);" class="btn btn-light-linkedin w-100 reset-pin-btn"> <i
                        class="fas fa-lock"></i> Reset Customer Console Pin</a>
            </div>
        </div>
        @endif
    </div>
    <!--end::Sidebar-->
    <!--begin::Content-->
    <div class="flex-lg-row-fluid ms-lg-15">
        <!--begin:::Tabs-->
        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
            <!--begin:::Tab item-->
            <li class="nav-item">
                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                    href="#kt_user_view_overview_tab">Overview</a>
            </li>
            @if ($user->hasRole(\App\Classes\Enums\UserTypesEnum::Teacher))
            <li class="nav-item">
                <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab"
                    href="#kt_user_view_overview_security">Availability & Assignments</a>
            </li>
            @endif

            @if ($user->hasRole(\App\Classes\Enums\UserTypesEnum::TeacherCoordinator))
            <li class="nav-item">
                <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab"
                    href="#kt_user_view_overview_security">Availability</a>
            </li>
            @endif

            @if ($user->hasRole(\App\Classes\Enums\UserTypesEnum::Customer))
            <li class="nav-item">
                <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab"
                    href="#kt_user_view_overview_profiles">Student Profiles</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab"
                    href="#kt_user_view_refunds">Refund</a>
            </li>
            @endif
            {{-- <li class="nav-item">
                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                    href="#kt_user_view_overview_events_and_logs_tab">Events &amp; Logs</a>
            </li> --}}
        </ul>

        <div class="tab-content" id="myTabContent">
            @if ($user->hasRole(\App\Classes\Enums\UserTypesEnum::Customer))
            <div class="tab-pane fade" id="kt_user_view_overview_profiles" role="tabpanel">
                @include('admin.users.profile.customer.students_list')
            </div>
            <div class="tab-pane fade" id="kt_user_view_refunds" role="tabpanel">
                @include('admin.users.profile.customer.refund')
            </div>
            @endif
            <!--begin:::Tab pane-->
            <div class="tab-pane fade show active" id="kt_user_view_overview_tab" role="tabpanel">
                <!--begin::Card-->
                @if ($user->hasRole(\App\Classes\Enums\UserTypesEnum::Teacher))
                @include('admin.users.profile.teacher.weekly_schedule')
                @endif

                <!--end::Card-->
                <!--begin::Tasks-->
                <div class="card card-flush mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header mt-6">
                        <?php
                            $current = '';
                            $notifications = $user->notifications;
                            ?>
                        <!--begin::Card title-->
                        <div class="card-title flex-column">
                            <h2 class="mb-1">{{ $user->first_name }}'s Activity</h2>
                            <div class="fs-6 fw-bold text-muted">Total {{ count($notifications) }} activities</div>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body d-flex flex-column">
                        <!--begin::Item-->
                        @if (count($notifications))
                        @foreach ($notifications as $notification)
                        <div class="d-flex align-items-center position-relative mb-7">
                            <div class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px">
                            </div>
                            <div class="fw-bold ms-5">
                                {!! $notification->html !!}
                                @if ($notification->student)
                                <div class="fs-7 ms-4 text-muted">Student
                                    <a href="#">{{ $notification->student->name }}</a>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="row"><span class="text-center text-muted mt-10 mb-5">No Activity
                                found!</span></div>
                        @endif
                        {{-- <div class="d-flex align-items-center position-relative mb-7">
                            <div class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px"></div>
                            <div class="fw-bold ms-5">
                                <a href="#" class="fs-5 fw-bolder text-dark text-hover-primary">Create FureStibe
                                    branding logo</a>
                                <div class="fs-7 text-muted">Due in 1 day
                                    <a href="#">Karina Clark</a>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Tasks-->
            </div>
            <!--end:::Tab pane-->
            <!--begin:::Tab pane-->
            @if ($user->hasRole(\App\Classes\Enums\UserTypesEnum::Teacher))
            <div class="tab-pane fade" id="kt_user_view_overview_security" role="tabpanel">

                @include('admin.users.profile.teacher.manage_availability')

                @include('admin.users.profile.teacher.assign_course')

                @include('admin.users.profile.teacher.assign_coordinator')

                @include('admin.users.profile.teacher.assign_library')

            </div>
            @elseif($user->hasRole(\App\Classes\Enums\UserTypesEnum::TeacherCoordinator))
            <div class="tab-pane fade" id="kt_user_view_overview_security" role="tabpanel">

                @include('admin.users.profile.teacher.manage_availability')



            </div>
            @endif
            <!--end:::Tab pane-->
            <!--begin:::Tab pane-->
            <div class="tab-pane fade" id="kt_user_view_overview_events_and_logs_tab" role="tabpanel">
                <!--begin::Card-->
                <div class="card pt-4 mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>Login Sessions</h2>
                        </div>
                        <!--end::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Filter-->
                            <button class="btn btn-sm btn-flex btn-light-primary" id="kt_modal_sign_out_sesions">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr077.svg-->
                                <span class="svg-icon svg-icon-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <rect opacity="0.3" x="4" y="11" width="12" height="2" rx="1" fill="black" />
                                        <path
                                            d="M5.86875 11.6927L7.62435 10.2297C8.09457 9.83785 8.12683 9.12683 7.69401 8.69401C7.3043 8.3043 6.67836 8.28591 6.26643 8.65206L3.34084 11.2526C2.89332 11.6504 2.89332 12.3496 3.34084 12.7474L6.26643 15.3479C6.67836 15.7141 7.3043 15.6957 7.69401 15.306C8.12683 14.8732 8.09458 14.1621 7.62435 13.7703L5.86875 12.3073C5.67684 12.1474 5.67684 11.8526 5.86875 11.6927Z"
                                            fill="black" />
                                        <path
                                            d="M8 5V6C8 6.55228 8.44772 7 9 7C9.55228 7 10 6.55228 10 6C10 5.44772 10.4477 5 11 5H18C18.5523 5 19 5.44772 19 6V18C19 18.5523 18.5523 19 18 19H11C10.4477 19 10 18.5523 10 18C10 17.4477 9.55228 17 9 17C8.44772 17 8 17.4477 8 18V19C8 20.1046 8.89543 21 10 21H19C20.1046 21 21 20.1046 21 19V5C21 3.89543 20.1046 3 19 3H10C8.89543 3 8 3.89543 8 5Z"
                                            fill="#C4C4C4" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->Sign out all sessions
                            </button>
                            <!--end::Filter-->
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0 pb-5">
                        <!--begin::Table wrapper-->
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed gy-5" id="kt_table_users_login_session">
                                <!--begin::Table head-->
                                <thead class="border-bottom border-gray-200 fs-7 fw-bolder">
                                    <!--begin::Table row-->
                                    <tr class="text-start text-muted text-uppercase gs-0">
                                        <th class="min-w-100px">Location</th>
                                        <th>Device</th>
                                        <th>IP Address</th>
                                        <th class="min-w-125px">Time</th>
                                        <th class="min-w-70px">Actions</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fs-6 fw-bold text-gray-600">
                                    <tr>
                                        <!--begin::Invoice=-->
                                        <td>Australia</td>
                                        <!--end::Invoice=-->
                                        <!--begin::Status=-->
                                        <td>Chome - Windows</td>
                                        <!--end::Status=-->
                                        <!--begin::Amount=-->
                                        <td>207.40.22.271</td>
                                        <!--end::Amount=-->
                                        <!--begin::Date=-->
                                        <td>23 seconds ago</td>
                                        <!--end::Date=-->
                                        <!--begin::Action=-->
                                        <td>Current session</td>
                                        <!--end::Action=-->
                                    </tr>
                                    <tr>
                                        <!--begin::Invoice=-->
                                        <td>Australia</td>
                                        <!--end::Invoice=-->
                                        <!--begin::Status=-->
                                        <td>Safari - iOS</td>
                                        <!--end::Status=-->
                                        <!--begin::Amount=-->
                                        <td>207.41.26.78</td>
                                        <!--end::Amount=-->
                                        <!--begin::Date=-->
                                        <td>3 days ago</td>
                                        <!--end::Date=-->
                                        <!--begin::Action=-->
                                        <td>
                                            <a href="#" data-kt-users-sign-out="single_user">Sign out</a>
                                        </td>
                                        <!--end::Action=-->
                                    </tr>
                                    <tr>
                                        <!--begin::Invoice=-->
                                        <td>Australia</td>
                                        <!--end::Invoice=-->
                                        <!--begin::Status=-->
                                        <td>Chrome - Windows</td>
                                        <!--end::Status=-->
                                        <!--begin::Amount=-->
                                        <td>207.23.17.353</td>
                                        <!--end::Amount=-->
                                        <!--begin::Date=-->
                                        <td>last week</td>
                                        <!--end::Date=-->
                                        <!--begin::Action=-->
                                        <td>Expired</td>
                                        <!--end::Action=-->
                                    </tr>
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Table wrapper-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
                <!--begin::Card-->
                <div class="card pt-4 mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>Logs</h2>
                        </div>
                        <!--end::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Button-->
                            <button class="btn btn-sm btn-light-primary">
                                <!--begin::Svg Icon | path: icons/duotune/files/fil021.svg-->
                                <span class="svg-icon svg-icon-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <path opacity="0.3"
                                            d="M19 15C20.7 15 22 13.7 22 12C22 10.3 20.7 9 19 9C18.9 9 18.9 9 18.8 9C18.9 8.7 19 8.3 19 8C19 6.3 17.7 5 16 5C15.4 5 14.8 5.2 14.3 5.5C13.4 4 11.8 3 10 3C7.2 3 5 5.2 5 8C5 8.3 5 8.7 5.1 9H5C3.3 9 2 10.3 2 12C2 13.7 3.3 15 5 15H19Z"
                                            fill="black" />
                                        <path d="M13 17.4V12C13 11.4 12.6 11 12 11C11.4 11 11 11.4 11 12V17.4H13Z"
                                            fill="black" />
                                        <path opacity="0.3"
                                            d="M8 17.4H16L12.7 20.7C12.3 21.1 11.7 21.1 11.3 20.7L8 17.4Z"
                                            fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->Download Report
                            </button>
                            <!--end::Button-->
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body py-0">
                        <!--begin::Table wrapper-->
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fw-bold text-gray-600 fs-6 gy-5"
                                id="kt_table_users_logs">
                                <!--begin::Table body-->
                                <tbody>
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Badge=-->
                                        <td class="min-w-70px">
                                            <div class="badge badge-light-warning">404 WRN</div>
                                        </td>
                                        <!--end::Badge=-->
                                        <!--begin::Status=-->
                                        <td>POST /v1/customer/c_616d17f4a285a/not_found</td>
                                        <!--end::Status=-->
                                        <!--begin::Timestamp=-->
                                        <td class="pe-0 text-end min-w-200px">10 Mar 2021, 8:43 pm</td>
                                        <!--end::Timestamp=-->
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Badge=-->
                                        <td class="min-w-70px">
                                            <div class="badge badge-light-success">200 OK</div>
                                        </td>
                                        <!--end::Badge=-->
                                        <!--begin::Status=-->
                                        <td>POST /v1/invoices/in_1451_4301/payment</td>
                                        <!--end::Status=-->
                                        <!--begin::Timestamp=-->
                                        <td class="pe-0 text-end min-w-200px">15 Apr 2021, 10:30 am</td>
                                        <!--end::Timestamp=-->
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Badge=-->
                                        <td class="min-w-70px">
                                            <div class="badge badge-light-success">200 OK</div>
                                        </td>
                                        <!--end::Badge=-->
                                        <!--begin::Status=-->
                                        <td>POST /v1/invoices/in_2415_8023/payment</td>
                                        <!--end::Status=-->
                                        <!--begin::Timestamp=-->
                                        <td class="pe-0 text-end min-w-200px">25 Jul 2021, 11:30 am</td>
                                        <!--end::Timestamp=-->
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Badge=-->
                                        <td class="min-w-70px">
                                            <div class="badge badge-light-warning">404 WRN</div>
                                        </td>
                                        <!--end::Badge=-->
                                        <!--begin::Status=-->
                                        <td>POST /v1/customer/c_616d17f4a2857/not_found</td>
                                        <!--end::Status=-->
                                        <!--begin::Timestamp=-->
                                        <td class="pe-0 text-end min-w-200px">05 May 2021, 11:30 am</td>
                                        <!--end::Timestamp=-->
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Badge=-->
                                        <td class="min-w-70px">
                                            <div class="badge badge-light-success">200 OK</div>
                                        </td>
                                        <!--end::Badge=-->
                                        <!--begin::Status=-->
                                        <td>POST /v1/invoices/in_1131_9330/payment</td>
                                        <!--end::Status=-->
                                        <!--begin::Timestamp=-->
                                        <td class="pe-0 text-end min-w-200px">20 Jun 2021, 5:30 pm</td>
                                        <!--end::Timestamp=-->
                                    </tr>
                                    <!--end::Table row-->
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Table wrapper-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
                <!--begin::Card-->
                <div class="card pt-4 mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>Events</h2>
                        </div>
                        <!--end::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Button-->
                            <button class="btn btn-sm btn-light-primary">
                                <!--begin::Svg Icon | path: icons/duotune/files/fil021.svg-->
                                <span class="svg-icon svg-icon-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <path opacity="0.3"
                                            d="M19 15C20.7 15 22 13.7 22 12C22 10.3 20.7 9 19 9C18.9 9 18.9 9 18.8 9C18.9 8.7 19 8.3 19 8C19 6.3 17.7 5 16 5C15.4 5 14.8 5.2 14.3 5.5C13.4 4 11.8 3 10 3C7.2 3 5 5.2 5 8C5 8.3 5 8.7 5.1 9H5C3.3 9 2 10.3 2 12C2 13.7 3.3 15 5 15H19Z"
                                            fill="black" />
                                        <path d="M13 17.4V12C13 11.4 12.6 11 12 11C11.4 11 11 11.4 11 12V17.4H13Z"
                                            fill="black" />
                                        <path opacity="0.3"
                                            d="M8 17.4H16L12.7 20.7C12.3 21.1 11.7 21.1 11.3 20.7L8 17.4Z"
                                            fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->Download Report
                            </button>
                            <!--end::Button-->
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body py-0">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 text-gray-600 fw-bold gy-5"
                            id="kt_table_customers_events">
                            <!--begin::Table body-->
                            <tbody>
                                <!--begin::Table row-->
                                <tr>
                                    <!--begin::Event=-->
                                    <td class="min-w-400px">Invoice
                                        <a href="#"
                                            class="fw-bolder text-gray-900 text-hover-primary me-1">#LOP-45640</a>has
                                        been
                                        <span class="badge badge-light-danger">Declined</span>
                                    </td>
                                    <!--end::Event=-->
                                    <!--begin::Timestamp=-->
                                    <td class="pe-0 text-gray-600 text-end min-w-200px">15 Apr 2021, 8:43 pm</td>
                                    <!--end::Timestamp=-->
                                </tr>
                                <!--end::Table row-->
                                <!--begin::Table row-->
                                <tr>
                                    <!--begin::Event=-->
                                    <td class="min-w-400px">
                                        <a href="#" class="text-gray-600 text-hover-primary me-1">Sean
                                            Bean</a>has made payment to
                                        <a href="#" class="fw-bolder text-gray-900 text-hover-primary">#XRS-45670</a>
                                    </td>
                                    <!--end::Event=-->
                                    <!--begin::Timestamp=-->
                                    <td class="pe-0 text-gray-600 text-end min-w-200px">25 Oct 2021, 2:40 pm</td>
                                    <!--end::Timestamp=-->
                                </tr>
                                <!--end::Table row-->
                                <!--begin::Table row-->
                                <tr>
                                    <!--begin::Event=-->
                                    <td class="min-w-400px">Invoice
                                        <a href="#"
                                            class="fw-bolder text-gray-900 text-hover-primary me-1">#WER-45670</a>is
                                        <span class="badge badge-light-info">In Progress</span>
                                    </td>
                                    <!--end::Event=-->
                                    <!--begin::Timestamp=-->
                                    <td class="pe-0 text-gray-600 text-end min-w-200px">25 Jul 2021, 5:20 pm</td>
                                    <!--end::Timestamp=-->
                                </tr>
                                <!--end::Table row-->
                                <!--begin::Table row-->
                                <tr>
                                    <!--begin::Event=-->
                                    <td class="min-w-400px">
                                        <a href="#" class="text-gray-600 text-hover-primary me-1">Sean
                                            Bean</a>has made payment to
                                        <a href="#" class="fw-bolder text-gray-900 text-hover-primary">#XRS-45670</a>
                                    </td>
                                    <!--end::Event=-->
                                    <!--begin::Timestamp=-->
                                    <td class="pe-0 text-gray-600 text-end min-w-200px">20 Dec 2021, 6:43 am</td>
                                    <!--end::Timestamp=-->
                                </tr>
                                <!--end::Table row-->
                                <!--begin::Table row-->
                                <tr>
                                    <!--begin::Event=-->
                                    <td class="min-w-400px">Invoice
                                        <a href="#"
                                            class="fw-bolder text-gray-900 text-hover-primary me-1">#DER-45645</a>status
                                        has changed from
                                        <span class="badge badge-light-info me-1">In Progress</span>to
                                        <span class="badge badge-light-primary">In Transit</span>
                                    </td>
                                    <!--end::Event=-->
                                    <!--begin::Timestamp=-->
                                    <td class="pe-0 text-gray-600 text-end min-w-200px">20 Jun 2021, 8:43 pm</td>
                                    <!--end::Timestamp=-->
                                </tr>
                                <!--end::Table row-->
                                <!--begin::Table row-->
                                <tr>
                                    <!--begin::Event=-->
                                    <td class="min-w-400px">
                                        <a href="#" class="text-gray-600 text-hover-primary me-1">Brian
                                            Cox</a>has made payment to
                                        <a href="#" class="fw-bolder text-gray-900 text-hover-primary">#OLP-45690</a>
                                    </td>
                                    <!--end::Event=-->
                                    <!--begin::Timestamp=-->
                                    <td class="pe-0 text-gray-600 text-end min-w-200px">25 Jul 2021, 10:10 pm</td>
                                    <!--end::Timestamp=-->
                                </tr>
                                <!--end::Table row-->
                                <!--begin::Table row-->
                                <tr>
                                    <!--begin::Event=-->
                                    <td class="min-w-400px">Invoice
                                        <a href="#"
                                            class="fw-bolder text-gray-900 text-hover-primary me-1">#KIO-45656</a>status
                                        has changed from
                                        <span class="badge badge-light-succees me-1">In Transit</span>to
                                        <span class="badge badge-light-success">Approved</span>
                                    </td>
                                    <!--end::Event=-->
                                    <!--begin::Timestamp=-->
                                    <td class="pe-0 text-gray-600 text-end min-w-200px">20 Jun 2021, 8:43 pm</td>
                                    <!--end::Timestamp=-->
                                </tr>
                                <!--end::Table row-->
                                <!--begin::Table row-->
                                <tr>
                                    <!--begin::Event=-->
                                    <td class="min-w-400px">
                                        <a href="#" class="text-gray-600 text-hover-primary me-1">Melody
                                            Macy</a>has made payment to
                                        <a href="#" class="fw-bolder text-gray-900 text-hover-primary">#XRS-45670</a>
                                    </td>
                                    <!--end::Event=-->
                                    <!--begin::Timestamp=-->
                                    <td class="pe-0 text-gray-600 text-end min-w-200px">25 Jul 2021, 10:30 am</td>
                                    <!--end::Timestamp=-->
                                </tr>
                                <!--end::Table row-->
                                <!--begin::Table row-->
                                <tr>
                                    <!--begin::Event=-->
                                    <td class="min-w-400px">Invoice
                                        <a href="#"
                                            class="fw-bolder text-gray-900 text-hover-primary me-1">#LOP-45640</a>has
                                        been
                                        <span class="badge badge-light-danger">Declined</span>
                                    </td>
                                    <!--end::Event=-->
                                    <!--begin::Timestamp=-->
                                    <td class="pe-0 text-gray-600 text-end min-w-200px">10 Mar 2021, 2:40 pm</td>
                                    <!--end::Timestamp=-->
                                </tr>
                                <!--end::Table row-->
                                <!--begin::Table row-->
                                <tr>
                                    <!--begin::Event=-->
                                    <td class="min-w-400px">
                                        <a href="#" class="text-gray-600 text-hover-primary me-1">Max
                                            Smith</a>has made payment to
                                        <a href="#" class="fw-bolder text-gray-900 text-hover-primary">#SDK-45670</a>
                                    </td>
                                    <!--end::Event=-->
                                    <!--begin::Timestamp=-->
                                    <td class="pe-0 text-gray-600 text-end min-w-200px">15 Apr 2021, 10:30 am</td>
                                    <!--end::Timestamp=-->
                                </tr>
                                <!--end::Table row-->
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end:::Tab pane-->
        </div>
        <!--end:::Tab content-->
    </div>
    <!--end::Content-->
</div>
@endsection
@push('after-css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--single {
        height: 100% !important;
    }

    .select2-selection--multiple:before {
        content: "";
        position: absolute;
        right: 15px;
        top: 42%;
        border-top: 5px solid #888;
        border-left: 4px solid transparent;
        border-right: 4px solid transparent;
    }

    .select2-selection--multiple:before,
    .select2-selection--single:before {
        content: "";
        position: absolute;
        right: 15px;
        top: 42%;
        border-top: 5px solid #888;
        border-left: 4px solid transparent;
        border-right: 4px solid transparent;
    }

    .apply-icon {
        transform: rotate(-90deg);
    }

    small.pe-3.pt-1 {
        display: none;
    }

    p.text-muted {
        padding-left: 0 !important;
        margin-bottom: 0 !important;
    }

    li.dropdown-item.text-wrap p.mb-0 {
        font-weight: 500;
        font-size: 16px;
    }

    li.dropdown-item.text-wrap p.text-muted {
        color: #009ef7 !important;
    }
</style>
@endpush
@push('after-script')
<script>
    $(document).ready(function() {
            $('.select2-multiple').select2({
                placeholder: 'Select Time Slots',
                closeOnSelect: false,

                initSelection: function(element, callback) {}

            });
            $('.select3-multiple').select2({
                placeholder: 'Select courses to assign',
                closeOnSelect: false,

                initSelection: function(element, callback) {}

            });
            $('.select2-single').select2({
                placeholder: 'Select Timezone',
                closeOnSelect: true,
            });

            $(".days-check").change(function() {
                var select = $(this).data('select');
                if (this.checked) {
                    $('.' + select).prop('disabled', false)
                    $('.' + select + '-apply').show()
                } else {
                    $('.' + select).prop('disabled', true).val("").trigger("change");
                    $('.' + select + '-apply').hide()
                }
            });

            $('#submit-availability').on('click', function() {
                console.log('Values: ' + $('select2-1').select2('val'));
            })

            $('.apply-icon').on('click', function() {
                var select = $(this).data('select');

                var values = $('.' + select).select2('val')

                if (values.length) {
                    $('.days-check').each(function() {
                        var sel = $(this).data('select');
                        if (this.checked) {
                            $('.' + sel).val(values).change();
                        }
                    });
                }
            })
        });
</script>

<script>
    $('.reset-pin-btn').on('click', function() {
            Swal.fire({
                text: 'Are you sure you want to reset customer pin?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, reset & notify!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace("{{ route('admin.users.customers.resetPin', $user) }}")
                }
            })
        })
</script>
<script>
    $('.refund-student').on('change',function(){
        console.log(this.value);
        let student_id = this.value;
        if(student_id == ""){
            $('.total_price_student').css('display','none');
        }
        $.ajax({
            type: 'POST',
            url: '{{ url('admin/users/getStudentPrice') }}',
            headers: {
            'X-CSRF-Token': '{{ csrf_token() }}',
            },
            data: {
                student_id: student_id
            },
            success: function(data) {
               
                if (data.success == true) {
                    $('.total_price_student').css('display','block');
                    $('.total_price').val(data.price);
                    console.log('price',data.price);
                } else {
                    
                }

            },
            error: function() {
            }
        });
    });
</script>
@endpush