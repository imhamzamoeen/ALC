<div class="card card-flush mb-6 mb-xl-9">
    <div class="card-header mt-6 mb-6">
        <div class="card-title flex-column">
            <h2 class="mb-1">{{ $user->name }}'s Students</h2>
            <div class="fs-6 fw-bold text-muted">{{ $user->profiles ? $user->profiles->count() : 0 }} Students</div>
        </div>
        <div class="card-toolbar">
            {{-- <button  class="btn btn-light-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_add_task">
                <i class="fas fa-user-alt"></i>Add Student
            </button> --}}
        </div>
    </div>
</div>
<div>
    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
        @if ($user->profiles)
            @foreach ($user->profiles as $key => $student)
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4 @if ($loop->first) active @endif"
                        data-bs-toggle="tab"
                        href="#user_student_profile_{{ $key }}">{{ $student->name ?? '' }}</a>
                </li>
            @endforeach
        @endif
    </ul>

    <div class="tab-content" id="myTabContent1">
        @if ($user->profiles)
            @foreach ($user->profiles as $key => $student)
                <div class="tab-pane fade @if ($loop->first) show active @endif"
                    id="user_student_profile_{{ $key }}" role="tabpanel">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-center flex-column">
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-100px symbol-circle mb-7">
                                            {!! generate_profile_picture_by_name($student->name) !!}
                                        </div>
                                        <!--end::Avatar-->
                                        <!--begin::Name-->
                                        <a href="#"
                                            class="fs-3 text-gray-800 text-hover-primary fw-bolder mb-3">{{ $student->name ?? '--' }}</a>
                                        <!--end::Name-->
                                        <!--begin::Position-->
                                        <div class="mb-9">
                                            <!--begin::Badge-->
                                            <div class="badge badge-lg badge-light-primary d-inline">Student</div>
                                            <!--begin::Badge-->
                                        </div>

                                        <div class="mb-9">
                                            <!--begin::Badge-->
                                            <div
                                                class="badge badge-lg badge-light-{{ \App\Classes\Enums\StatusEnum::$subscription_bootstrap_colors[@$student->subscription_status] ?? 'primary' }} d-inline">
                                                {{ beautify_slug($student->subscription_status) }}</div>
                                            <!--begin::Badge-->
                                        </div>
                                        <!--end::Position-->
                                        <!--begin::Info-->
                                        <!--begin::Info heading-->
                                        <div class="fw-bolder mb-3">Classes
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                data-bs-trigger="hover" data-bs-html="true"
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
                                            <div
                                                class="border border-gray-300 border-dashed rounded py-3 px-3 mx-4 mb-3">
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
                                        <!--end::Info-->
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="card mt-5">
                                <div class="card-body">
                                    <div class="d-flex flex-stack">
                                        <div class="d-flex">
                                            <i class="fas fa-plane d-flex align-items-center fs-2 me-3"></i>
                                            <div class="d-flex flex-column">
                                                <a href="javascript:void(0);" class="fs-5 text-dark text-hover-primary fw-bolder">Vacation Mode</a>
                                                <div class="fs-8 fw-bold text-muted pe-3">
                                                    @if ($student->vacation_mode == 1)
                                                        Student is currently on vacation
                                                    @else
                                                        Student is currently on schedule
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" name="google" type="checkbox" value="1" id="kt_modal_connected_accounts_google" @if ($student->vacation_mode == 1) checked="checked" @endif onclick="return false;">
                                                <span class="form-check-label fw-bold text-muted" for="kt_modal_connected_accounts_google"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        <div class="col-md-8">
                            <div class="card h-100">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h2>Details</h2>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="pb-5 fs-6">
                                        <!--begin::Details item-->
                                        <div class="fw-bolder">Student ID</div>
                                        <div class="text-gray-600">{{ $student->reg_no ?? '--' }}</div>
                                        <!--begin::Details item-->
                                        <!--begin::Details item-->
                                        <div class="fw-bolder mt-5">Registered Course</div>
                                        <div class="text-gray-600">
                                            <a href="#"
                                                class="text-gray-600 text-hover-primary">{{ $student->course->title ?? '--' }}</a>
                                        </div>
                                        <!--begin::Details item-->
                                        <!--begin::Details item-->
                                        <div class="fw-bolder mt-5">Classes/Week</div>
                                        <div class="text-gray-600">{{ $student->routine_classes->count() ?? '--' }}
                                        </div>
                                        <!--begin::Details item-->
                                        <!--begin::Details item-->
                                        <div class="fw-bolder mt-5">Classes/Month</div>
                                        <div class="text-gray-600">
                                            {{ $student->routine_classes->count() * 4 ?? '--' }}</div>

                                        <div class="fw-bolder mt-5">Subscription Fee/Month</div>
                                        <div class="text-gray-600">150 $</div>
                                        <!--begin::Details item-->
                                        <!--begin::Details item-->
                                        <div class="fw-bolder mt-5">Assigned Teacher</div>
                                        <div class="text-gray-600">{{ $student->teacher->name ?? '--' }}</div>
                                        <!--begin::Details item-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($student->is_subscribed == 0)
                        @include('admin.users.profile.customer.trial_detail')
                    @else
                        @include('admin.users.profile.customer.weekly_schedule')
                    @endif
                </div>
            @endforeach
        @endif
    </div>
</div>
