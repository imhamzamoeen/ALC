<div class="card card-flush mb-6 mb-xl-9 mt-6">
    <!--begin::Card header-->
    <div class="card-header mt-6">
        <!--begin::Card title-->
        <div class="card-title flex-column">
            <h2 class="mb-1">{{ $student->name }}'s Trial Detail</h2>
        </div>
        <!--end::Card title-->
        <!--begin::Card toolbar-->
        {{-- <div class="card-toolbar">
        <button  class="btn btn-light-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_add_schedule">
            <!--SVG file not found: media/icons/duotune/art/art008.svg-->
            Add Schedule</button>
    </div> --}}
        <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body p-9 pt-4">
        <div class="pb-5 fs-6">
            <div class="row">
                <div class="col-md-6">
                    <div class="fw-bolder mt-5">Timezone</div>
                    <div class="text-gray-600">{{ $student->timezone ?? '--' }}</div>

                    <div class="fw-bolder mt-5">Course</div>
                    <div class="text-gray-600">
                        <a href="#" class="text-gray-600 text-hover-primary">{{ $student->course->title }}</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="fw-bolder mt-5">Availabilty</div>
                    <div class="text-gray-600">
                        @isset($student->trialRequest)
                            @if (count($student->trialRequest->days))
                                @foreach ($student->trialRequest->days as $day)
                                    {{ __(\App\Classes\AlQuranConfig::DaysMin[$day->day_id]) }}{!! !$loop->last ? ',' : '' !!}
                                @endforeach
                            @endif
                        @endisset
                    </div>
                    <div class="fw-bolder mt-5">Shift</div>
                    <div class="text-gray-600"> {{ __(\App\Classes\AlQuranConfig::Shifts[$student->shift_id]) ?? '--' }}
                    </div>
                </div>
            </div>
        </div>
        @if ($student->trialRequest->trialClass)
            <hr>
            <h4>Trial Class</h4>
            <div class="d-flex flex-stack position-relative mt-6">
                <!--begin::Bar-->
                <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                <!--end::Bar-->
                <!--begin::Info-->
                <div class="fw-bold ms-5">
                    <!--begin::Time-->
                    <div class="fs-7">{!! format_time(
                        convertTimeToUSERzone(@$student->trialRequest->trialClass->starts_at, @$student->timezone),
                        false,
                    ) ?? '--' !!}</div>
                    <!--end::Time-->
                    <!--begin::Title-->
                    <span class="fs-5 fw-bolder text-dark text-hover-primary mb-2">
                        <span
                            class="badge w-100 badge-{{ \App\Classes\Enums\StatusEnum::$subscription_bootstrap_colors[@$student->trialRequest->status] ?? 'primary' }}">{{ beautify_slug(@$student->trialRequest->status) }}</span>
                    </span>
                    <!--end::Title-->
                    <!--begin::User-->
                    <div class="fs-7 text-muted">
                        Teacher:
                        <a
                            href="{{ route('admin.users.view', @$student->teacher->id ?? 0) }}">{{ $student->teacher->name ?? '--' }}</a>
                    </div>
                    <!--end::User-->
                </div>
                <!--end::Info-->
                <!--begin::Action-->
                @if (@$student->trialRequest->status == \App\Classes\Enums\StatusEnum::TrialScheduled ||
                    @$student->trialRequest->status == \App\Classes\Enums\StatusEnum::TrialRescheduled)
                    <a href="{{ route('joinClassTrial', [app()->getLocale(), 'user' => auth()->user(), 'TrialClass' => $student->trialRequest->trialClass->session_key]) }}"
                        target="_blank" class="btn btn-light bnt-active-light-primary btn-sm">Join Class</a>
                @endif
                <!--end::Action-->
            </div>
        @else
            <hr>
            <div class="row">
                <h2
                    class="badge text-center badge-{{ \App\Classes\Enums\StatusEnum::$subscription_bootstrap_colors[@$student->trialRequest->status] ?? 'primary' }}">
                    {{ beautify_slug(@$student->trialRequest->status) }}</h2>
            </div>
        @endif
    </div>
    <!--end::Card body-->
</div>
