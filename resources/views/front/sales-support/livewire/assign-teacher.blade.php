<div>
    {{-- @include('front.partials.overlay-loader', ['show_status' => 'd-none', 'class' => 'full-page-loader']) --}}
    {{-- WIRE LOADER --}}
    @if ($type == 'completed_changes' || $type == 'pending_changes' || $type == 'progress_changes') {{-- if the type is about changes --}}
        <table class="vertical-table table-borderless sales-support-table">
            <thead>
                <tr>
                    <th scope="col">{{ __('Customer Name') }}</th>
                    <th scope="col">{{ __('Student Name') }}</th>
                    <th scope="col">{{ __('Phone Number') }}</th>
                    <th scope="col">{{ __('Change Type') }}</th>
                    <th scope="col">{{ __('Status') }}</th>

                    <th scope="col">{{ __('Action') }}</th>

                </tr>
            </thead>
            <tbody id="trials-list-body">
                @foreach ($changesRequests as $eachChangerequest)
                    @if (!is_null($eachChangerequest->Student) && !is_null($eachChangerequest->Student->user))
                        <tr>
                            <td data-label="Customer Name">{{ $eachChangerequest->Student->user->name }}</td>
                            {{-- <td data-label="Student Id">{{ $request->student->id }}</td> --}}
                            <td data-label="Student Name">{{ $eachChangerequest->Student->name }}</td>
                            <td data-label="Phone Number">{{ $eachChangerequest->Student->user->phone }}</td>
                          
                            <td data-label="change_type">
                                <span
                                    class="badge status-pill {{ $eachChangerequest->change_type == 'teacher_change' ? 'status-primary' : 'status-warning' }}">
                                    {{ beautify_slug($eachChangerequest->change_type) }}
                                </span>
                            </td>
                            <td data-label="Status">
                                <span
                                    class="badge status-pill {{ $eachChangerequest->status == 'completed' ? 'status-success' : 'status-warning' }}">
                                    {{ beautify_slug($eachChangerequest->status) }}
                                </span>
                            </td>
                            @if ($eachChangerequest->status != 'completed')
                                <td class="d-flex justify-content-center">

                                    <a href="#" class="btn btn-primary py-2 action-btn"
                                        wire:click="OpenChangeModal({{ $eachChangerequest }})">
                                        {{ __('Assign') }}
                                    </a>
                                </td>
                            @endif
                        </tr>
                    @endif
                @endforeach

            </tbody>

        </table>
        <div class="paginates-section">
            {{ $changesRequests->links() }}
        </div>
        @if (!empty($currentChangeRequest))

            <div class="modal fade change-request" wire:ignore.self id="change-request-{{ $type }}"
                tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="border-0 modal-content border-custom-left modal-padding">
                        <div wire:loading wire:target="submit">
                            @include('front.partials.overlay-loader')
                        </div>

                        <div class="modal-header border-bottom">
                            <h4 class="modal-title">{{ __('Change Request Details') }}</h4>

                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body pt-sm-5 pt-4 px-14 text-med">
                            <div class="row">
                                <div class="col-sm-4 col-12">
                                    <div class="d-sm-block d-flex d-sm-block justify-content-between trial-info">
                                        <p class="text-sb mb-1">Name</p>
                                        <p class="mb-3">{{ @$currentChangeRequest['student']['name'] ?? '--' }}</p>
                                    </div>

                                    <div class="d-sm-block d-flex d-sm-block justify-content-between trial-info">
                                        <p class="text-sb mb-1">Parent</p>
                                        <p class="mb-3">
                                            {{ @$currentChangeRequest['student']['user']['name'] ?? '--' }}
                                        </p>
                                    </div>

                                    <div class="d-sm-block d-flex d-sm-block justify-content-between trial-info">
                                        <p class="text-sb mb-1">Email</p>
                                        <p class="mb-3">
                                            {{ @$currentChangeRequest['student']['user']['email'] ?? '--' }}
                                        </p>
                                    </div>
                                    <div class="d-sm-block d-flex d-sm-block justify-content-between trial-info">
                                        <p class="text-sb mb-1">TimeZone</p>
                                        <p class="mb-3"> {{ @$currentChangeRequest['student']['timezone'] ?? '--' }}
                                        </p>
                                    </div>

                                </div>
                                <div class="col-sm-4 col-12 d-flex justify-content-sm-center">
                                    <div class="trial-info--wrapper">
                                        <div class="d-sm-block d-flex d-sm-block justify-content-between trial-info">
                                            <p class="text-sb mb-1">Age</p>
                                            <p class="mb-3"> {{ @$currentChangeRequest['student']['age'] ?? '--' }}
                                            </p>
                                        </div>
                                        <div class="d-sm-block d-flex d-sm-block justify-content-between trial-info">
                                            <p class="text-sb mb-1">Course</p>
                                            <p class="mb-3">
                                                {{ @$currentChangeRequest['student']['course']['title']=='Custom Course' ? @$currentChangeRequest['student']['course']['title'].' '.@$currentChangeRequest['student']['course']['description'] :  @$currentChangeRequest['student']['course']['title']  }}
                                            </p>
                                        

                                        </div>
                                        <div class="d-sm-block d-flex d-sm-block justify-content-between trial-info">
                                            <p class="text-sb mb-1">Country</p>
                                            <p class="mb-3">
                                                {{ @$currentChangeRequest['student']['user']['country'] ?? '--' }}</p>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-4 col-12 d-flex justify-content-sm-end">
                                    <div class="trial-info--wrapper">
                                        <div class="d-sm-block d-flex d-sm-block justify-content-between trial-info">
                                            <p class="text-sb mb-1">Gender</p>
                                            <p class="mb-3">
                                                {{ @$currentChangeRequest['student']['gender'] ?? '--' }}
                                            </p>
                                        </div>
                                

                                        <div class="d-sm-block d-flex d-sm-block justify-content-between trial-info">
                                            <p class="text-sb mb-1"> Teacher</p>
                                            <p class="mb-0">
                                                {{ beautify_slug($currentChangeRequest['student']['teacher']['name']) }}
                                            </p>
                                        </div>


                                    </div>
                                </div>
                            </div>
                                <div class="row">
                                    <div class="col-sm-12 col-12">
                                        <label for="reason_field">Reason For <small style="color:red">{{ beautify_slug($currentChangeRequest['change_type']) }}</small></label>
                                        <textarea id="reason_field" class="form-control " readonly>@if($currentChangeRequest['change_type']=='course_change')The Students wants to change his current course  to {{ \App\Models\Course::find($currentChangeRequest['course_id'])->title.'.' }}@endif  The reason is {{ ($currentChangeRequest['reason']) }}</textarea>
                                   
                                            
                                    </div>
                                </div>

                            <hr>
                            <form wire:submit.prevent="ChangeRequestSubmit" id="change-request-{{ $type }}-form">
                                <div class="row pb-3">

                                    
                                    <div class=" col-12  col-sm-12 ">
                                        <p class="text-sb mb-1">Status </p>
                                        <select class="form-select" aria-label="select status" type="button"
                                            id="set_status " aria-expanded="false"
                                            wire:model.lazy="CurrentOpenedChangeRequest.status">
                                            <option value=''>Choose a status</option>
                                            <option value="{{ App\Classes\Enums\StatusEnum::ChangeRequestProgress }}"  @if(@$CurrentOpenedChangeRequest['status']==App\Classes\Enums\StatusEnum::ChangeRequestProgress)
                                                selected   
                                            @endif>In Progress</option>
                                            <option value="{{ App\Classes\Enums\StatusEnum::ChangeRequestCompleted }}" @if(@$CurrentOpenedChangeRequest['status']==App\Classes\Enums\StatusEnum::ChangeRequestCompleted)
                                            selected   
                                        @endif>Completed</option>

                                        </select>
                                        @error('CurrentOpenedChangeRequest.status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    
                             

                                </div>


                                    @if($CurrentOpenedChangeRequest['status']==App\Classes\Enums\StatusEnum::ChangeRequestCompleted)
                                    @if($currentChangeRequest['change_type']=='course_change')

                                    <div class=" col-12 @if($currentChangeRequest['change_type']=='course_change') col-sm-6 @else col-sm-12 @endif">
                                            <p class="text-sb mb-1">Course</p>
                                            <select class="form-select" aria-label="select course" type="button"
                                                id="change_course_id" aria-expanded="false"
                                                wire:model.lazy="CurrentOpenedChangeRequest.course_id">
                                                <option value=''>Choose a course</option>
                                                @foreach ($courses as $course)
                                                    <option class="dropdown-item py-1 text-med"
                                                        value="{{ $course->id }}"
                                                        @if (@$currentChangeRequest['student']['course']['id'] == $course->id) selected @endif>
                                                        {{ $course->title == 'Custom Course'
                                                                ? $course->title . ' : ' . $course->description
                                                                : $course->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('CurrentOpenedChangeRequest.course_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        
                                 

                                    </div>
                                    @endif
                                    <div class=" col-12 @if($currentChangeRequest['change_type']=='teacher_change') col-sm-12 @else col-sm-6 @endif">
                                        <p class="text-sb mb-1">Teacher</p>
                                        <select class="form-select" aria-label="select course" type="button"
                                            id="change_teacher_id" aria-expanded="false"
                                            wire:model.lazy="CurrentOpenedChangeRequest.teacher_id">
                                            <option value=''>Choose a Teacher</option>
                                            @foreach ($teachers as $teacher)
                                                <option class="dropdown-item py-1 text-med"
                                                    value="{{ $teacher->id }}"
                                                    @if (@$currentChangeRequest['student']['teacher']['id'] == $teacher->id) selected @endif>
                                                    {{ $teacher->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('CurrentOpenedChangeRequest.teacher_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    
                             

                                </div>
                                @endif
                                <input type="hidden" id="current_change_type"  wire:model="CurrentOpenedChangeRequest.change_type">

                        
                                </div>
                            </form>
                            <hr>
                        </div>
                        <div class="modal-footer pt-0 pb-3 border-top-0">
                            <div class="row g-0">
                                <div class="col-4 text-muted">
                                    Last Action
                                    <br class="d-sm-none d-block">
                                    {{ format_time(
                                        convertTimeToUSERzone(@$currentChangeRequest['updated_at'], $currentChangeRequest['student']['timezone']),
                                        false,
                                    ) }}
                                </div>
                                <div class="col-8 pb-5 pb-md-0">
                                    <div class="h-100 d-flex justify-content-end align-items-center">
                                        <a href="#" class="text-dark text-decoration-none fw-bold me-3 px-14"
                                            data-bs-dismiss="modal" aria-label="Close">{{ __('Cancel') }}</a>

                                        <button class="btn btn-primary py-2 "
                                            form="change-request-{{ $type }}-form">
                                            <div wire:loading.remove>

                                                {{ __('Assign') }}
                                            </div>
                                            <div wire:loading>
                                                @include('front.partials.validator-loader')
                                            </div>
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif {{-- of above modal check whether current change request is set or not --}}
    @elseif (strpos($type, 'trial') !== false)
        {{-- if the type contains word trial --}}
        @if (count($trialRequests))
            <h4 class="mb-3 mb-md-4 text-bold">{{ beautify_slug($type) }}<span class="requests_number text-med ms-2">(
                    {{ \App\Models\TrialRequest::where('status', $type)->count() }} )</span></h4>
            @if ($type == \App\Classes\Enums\StatusEnum::TrialUnScheduled ||
                $type == \App\Classes\Enums\StatusEnum::TrialInvalid)
                <table class="vertical-table table-borderless sales-support-table">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('Customer Name') }}</th>
                            {{-- <th scope="col">{{ __('Student id') }}</th> --}}
                            <th scope="col">{{ __('Student Name') }}</th>
                            <th scope="col">{{ __('Phone Number') }}</th>
                            <th scope="col">{{ __('Status') }}</th>
                            <th scope="col">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody id="trials-list-body">
                        @foreach ($trialRequests as $request)
                            @if (!is_null($request->student) && !is_null($request->student->user))
                                <tr>
                                    <td data-label="Customer Name">{{ $request->student->user->name }}</td>
                                    {{-- <td data-label="Student Id">{{ $request->student->id }}</td> --}}
                                    <td data-label="Student Name">{{ $request->student->name }}</td>
                                    <td data-label="Phone Number">{{ $request->student->user->phone }}</td>
                                    <td data-label="Status">
                                        <span
                                            class="badge status-pill {{ $request->status == $type ? 'status-primary' : 'status-warning' }}">
                                            {{ beautify_slug($request->status) }}
                                        </span>
                                    </td>
                                    <td class="d-flex justify-content-end">
                                        <a href="#" class="btn btn-primary py-2 action-btn"
                                            wire:click="openAssignModal({{ $request }})">
                                            @if ($type == \App\Classes\Enums\StatusEnum::TrialScheduled ||
                                                $type == \App\Classes\Enums\StatusEnum::TrialRescheduled)
                                                {{ __('Update Schedule') }}
                                            @elseif($type == \App\Classes\Enums\StatusEnum::TrialUnScheduled)
                                                {{ __('Assign Teacher') }}
                                            @else
                                                {{ __('View Details') }}
                                            @endif
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @else
                <table class="vertical-table table-borderless sales-support-table">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('Day & Time') }}</th>
                            <th scope="col">{{ __('Teacher Name') }}</th>
                            <th scope="col">{{ __('Student Name') }}</th>
                            <th scope="col">{{ __('Course') }}</th>
                            <th scope="col">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody id="trials-list-body">
                        @foreach ($trialRequests as $request)
                            @isset($request->trialClass)
                                <tr>
                                    <td data-label="{{ __('Day & Time') }}">
                                        {{ format_time(convertTimeToUSERzone($request->trialClass->starts_at, $request->student->timezone), false) ??
                                            '--' }}
                                    </td>
                                    <td data-label="{{ __('Teacher Name') }}">
                                        {{ $request->student->teacher->name ?? '--' }}</td>
                                    <td data-label="{{ __('Student Name') }}">{{ $request->student->name ?? '--' }}
                                    </td>
                                    <td data-label="{{ __('Course') }}">{{ $request->student->course->title ?? '--' }}
                                    </td>
                                    <td data-label="{{ __('Status') }}"
                                        class="d-flex justify-content-sm-evenly justify-content-between align-items-center position">
                                        {{-- <a href="#" class="btn btn-primary py-2" wire:click="openAssignModal({{$request}})">
                        @if ($type == \App\Classes\Enums\StatusEnum::TrialScheduled || $type == \App\Classes\Enums\StatusEnum::TrialRescheduled)
                        {{ __('Update Schedule') }}
                        @elseif($type == \App\Classes\Enums\StatusEnum::TrialUnScheduled)
                        {{ __('Assign Teacher') }}
                        @else
                        {{ __('View Details') }}
                        @endif
                    </a> --}}
                                        {{-- <div class="d-sm-block d-flex"> --}}
                                        <span
                                            class="badge status-pill scheduled_trial-status {{ $request->status == $type ? 'status-primary' : 'status-warning' }}">
                                            {{ beautify_slug($request->status) }}
                                        </span>
                                        <div class="dropdown">
                                            <span id="moreButtonDropdown" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </span>
                                            <ul class="dropdown-menu" id="moreButton-menu"
                                                aria-labelledby="moreButtonDropdown">
                                                <li><a class="dropdown-item" href="#"
                                                        wire:click="openAssignModal({{ $request }},'reassign')">Reassign</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#"
                                                        wire:click="openAssignModal({{ $request }},'details')">View
                                                        Details</a>
                                                </li>
                                                <li><a class="dropdown-item cancelTrial" data-date="{{ $request->id }}"
                                                        href="javascript:void(0);">Cancel
                                                        Trial</a></li>
                                            </ul>
                                        </div>
                                        {{-- </div> --}}
                                    </td>
                                </tr>
                            @endisset
                        @endforeach
                    </tbody>
                </table>

            @endif
            <div class="paginates-section">
                {{ $trialRequests->links() }}
            </div>
        @else
            <div class="h-100 d-flex flex-column justify-content-center align-items-center mt-5 pt-5">
                <img src="{{ asset('images/empty-requests.svg') }}" />
                <strong>{{ __('No Trial Request Found!') }}</strong>
            </div>
        @endif
        @if (!empty($currentRequest))
            <div class="modal fade assign-teacher" wire:ignore.self id="assign-teacher-{{ $type }}"
                tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="border-0 modal-content border-custom-left modal-padding">
                        <div wire:loading wire:target="submit">
                            @include('front.partials.overlay-loader')
                        </div>

                        <div class="modal-header border-bottom">
                            <h4 class="modal-title">{{ __('Trial Details') }}</h4>
                            <div class="px-14 ms-auto me-4 d-flex">
                                <button class="btn valid-btn @if ($assign['label'] == \App\Classes\Enums\StatusEnum::TrialValid) active @endif"
                                    wire:click="$emit('UpdateLabel','{{ \App\Classes\Enums\StatusEnum::TrialValid }}')">Valid</button>
                                <button class="btn invalid-btn @if ($assign['label'] == \App\Classes\Enums\StatusEnum::TrialInvalid) active @endif"
                                    wire:click="$emit('UpdateLabel','{{ \App\Classes\Enums\StatusEnum::TrialInvalid }}')">Invalid</button>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body pt-sm-5 pt-4 px-14 text-med">
                            <div class="row">
                                <div class="col-sm-4 col-12">
                                    <div class="d-sm-block d-flex d-sm-block justify-content-between trial-info">
                                        <p class="text-sb mb-1">Name</p>
                                        <p class="mb-3">{{ @$currentRequest['student']['name'] ?? '--' }}</p>
                                    </div>
                                    <div class="d-sm-block d-flex d-sm-block justify-content-between trial-info">
                                        <p class="text-sb mb-1">Email</p>
                                        <p class="mb-3"> {{ @$currentRequest['student']['user']['email'] ?? '--' }}
                                        </p>
                                    </div>
                                    <div class="d-sm-block d-flex d-sm-block justify-content-between trial-info">
                                        <p class="text-sb mb-1">TimeZone</p>
                                        <p class="mb-3"> {{ @$currentRequest['student']['timezone'] ?? '--' }}</p>
                                    </div>
                                    <div class="d-sm-block d-flex d-sm-block justify-content-between trial-info">
                                        <p class="text-sb mb-1">Shift</p>
                                        <p> {{ __(\App\Classes\AlQuranConfig::Shifts[@$currentRequest['student']['shift_id']]) ?? '--' }}
                                        </p>
                                    </div>

                                </div>
                                <div class="col-sm-4 col-12 d-flex justify-content-sm-center">
                                    <div class="trial-info--wrapper">
                                        <div class="d-sm-block d-flex d-sm-block justify-content-between trial-info">
                                            <p class="text-sb mb-1">Age</p>
                                            <p class="mb-3"> {{ @$currentRequest['student']['age'] ?? '--' }}</p>
                                        </div>
                                        <div class="d-sm-block d-flex d-sm-block justify-content-between trial-info">
                                            <p class="text-sb mb-1">Course</p>
                                            <p class="mb-3">
                                                {{ @$currentRequest['student']['course']['title'] ?? '--' }}

                                            </p>
                                            <small>{{ @$currentRequest['student']['course']['description'] ?? '--' }}</small>


                                        </div>
                                        <div class="d-sm-block d-flex d-sm-block justify-content-between trial-info">
                                            <p class="text-sb mb-1">Country</p>
                                            <p class="mb-3">
                                                {{ @$currentRequest['student']['user']['country'] ?? '--' }}</p>
                                        </div>
                                        <div class="d-sm-block d-flex d-sm-block justify-content-between trial-info">
                                            <p class="text-sb mb-1">Teacher Preference</p>
                                            <p class="mb-3">
                                                {{ beautify_slug(@$currentRequest['teacher_preference']) ?? 'Any' }}
                                            </p>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-4 col-12 d-flex justify-content-sm-end">
                                    <div class="trial-info--wrapper">
                                        <div class="d-sm-block d-flex d-sm-block justify-content-between trial-info">
                                            <p class="text-sb mb-1">Gender</p>
                                            <p class="mb-3"> {{ @$currentRequest['student']['gender'] ?? '--' }}
                                            </p>
                                        </div>
                                        <div class="d-sm-block d-flex d-sm-block justify-content-between trial-info">
                                            <p class="text-sb mb-1">Availability</p>
                                            <p class="mb-3"> @isset($currentRequest['days'])
                                                    @if (count($currentRequest['days']))
                                                        @foreach ($currentRequest['days'] as $day)
                                                            {{ __(\App\Classes\AlQuranConfig::DaysMin[$day['day_id']]) }}{!! !$loop->last ? ',' : '' !!}
                                                        @endforeach
                                                    @endif
                                                @endisset
                                            </p>
                                        </div>
                                        @if (isset($currentRequest['student']['teacher']))
                                            <div
                                                class="d-sm-block d-flex d-sm-block justify-content-between trial-info">
                                                <p class="text-sb mb-1">Teacher</p>
                                                <p class="mb-0">
                                                    {{ beautify_slug($currentRequest['student']['teacher']['name']) }}
                                                </p>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <hr>

                            <form wire:submit.prevent="submit" id="assign-teacher-{{ $type }}-form">
                                @if ($assign['label'] != \App\Classes\Enums\StatusEnum::TrialInvalid && @$option != 'details')
                                    <div class="mb-sm-4 mb-2 row">
                                        <div class="col-6">
                                            <p class="text-sb mb-1">Course</p>
                                            <select class="form-select" aria-label="select course" type="button"
                                                id="course_id" aria-expanded="false"
                                                wire:model.lazy="assign.course_id">
                                                <option value=''>Choose a course</option>
                                                @foreach ($courses as $course)
                                                    <option class="dropdown-item py-1 text-med"
                                                        value="{{ $course->id }}"
                                                        @if (@$assign['course_id'] == $course->id) selected @endif>
                                                        {{ $course->title == 'Custom Course'
                                                                ? $course->title . ' : ' . $course->description
                                                                : $course->title
                                                             }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('assign.course_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @if (@$assign['course_id'])
                                            <div class="col-6">
                                                <div class="select-teacher ">
                                                    <p class="text-sb mb-1">Teachers</p>
                                                    <div class="teachers-container">
                                                        {{-- <select class="btn btn-secondary dropdown-toggle w-100 text-med">

                                            <option value="">Choose Teacher</option>
                                            @foreach ($teachers as $eachteacher)
                                            <option class="dropdown-item py-1 text-med" value="{{ $eachteacher->id }}">
                                                {{ $eachteacher->reg_no . ' : ' . $eachteacher->name }}
                                            </option>
                                            @endforeach
                                        </select> --}}
                                                        <select class="form-select" type="button" id="teacher_id"
                                                            aria-expanded="false" wire:model.lazy="assign.teacher_id">
                                                            <option value="">Choose Teacher</option>
                                                            @foreach ($teachers as $eachteacher)
                                                                <option class="dropdown-item py-1 text-med"
                                                                    value="{{ $eachteacher->id }}"
                                                                    @if (@$assign['teacher_id'] == $eachteacher->id) selected @endif>
                                                                    {{ $eachteacher->reg_no . ' : ' . $eachteacher->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('assign.teacher_id')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        @endif


                                    </div>
                                    <div class="row pb-3">
                                        <div class="col-sm-6 col-12">


                                            @if (@$assign['teacher_id'] && @$assign['course_id'])
                                                <p class="text-sb mb-1 d-sm-none d-block py-sm-0 py-3">Availability</p>
                                                <div class="row">
                                                    @include('front.sales-support.calender.schedule_calender')
                                                </div>


                                                {{-- <x-sales-support.teacher-schedule-component :teacher="$assign['teacher_id']"
                                    :student="$currentRequest['student']['id']" /> --}}

                                            @endif

                                        </div>
                                        <div class="col-sm-6 col-12">


                                            @if (@$assign['teacher_id'] && @$assign['course_id'] && @$assign['date'])

                                                @error('assign.slot')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <x-sales-support.teacher-slots :date="$assign['date']" :teacher="$assign['teacher_id']"
                                                    :student="$currentRequest['student']['id']" />


                                            @endif


                                        </div>
                                    </div>
                                @elseif(@$option == 'details' && $assign['label'] != \App\Classes\Enums\StatusEnum::TrialInvalid)
                                    <div class="mb-sm-4 mb-2 row">
                                        <div class="col-12">
                                            <p class="text-sb mb-1">Add Status</p>
                                            <select class="form-select" aria-label="select Status" type="button"
                                                id="status" aria-expanded="false" wire:model.lazy="assign.status">
                                                <option value=''>Choose a status</option>
                                                @foreach (\App\Classes\Enums\StatusEnum::$Valid_Trial_Status as $status)
                                                    <option class="dropdown-item py-1 text-med"
                                                        @if (@$assign['status'] == $status) selected @endif
                                                        value="{{ $status }}">
                                                        {!! beautify_slug($status) !!}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('assign.status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @if ($assign['status'] == 'trial_unsuccessful')
                                            <div class="col-12">
                                                <p class="text-sb mb-1"> Reason</p>
                                                <input type="text" class="form-control" placeholder="Reason"
                                                    name="reason" wire:model.lazy="assign.reason"
                                                    value="{{ @$assign['reason'] }}" />
                                                @error('assign.reason')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        @endif





                                    </div>
                                @endif
                            </form>

                            <hr>
                        </div>
                        <div class="modal-footer pt-0 pb-3 border-top-0">
                            <div class="row g-0">
                                <div class="col-4 text-muted px-14">
                                    {{ $type == \App\Classes\Enums\StatusEnum::TrialScheduled
                                        ? __('Assigned At')
                                        : __('Requested
                                                                                                                                                                                                                                                    At') }}
                                    <br class="d-sm-none d-block">
                                    {{ format_time(
                                        convertTimeToUSERzone(@$currentRequest['updated_at'], $currentRequest['student']['timezone']),
                                        false,
                                    ) }}
                                </div>
                                <div class="col-8 pb-5 pb-md-0">
                                    <div class="h-100 d-flex justify-content-end align-items-center">
                                        <a href="#" class="text-dark text-decoration-none fw-bold me-3 px-14"
                                            data-bs-dismiss="modal" aria-label="Close">{{ __('Cancel') }}</a>
                                        @if (@$currentRequest['status'] == \App\Classes\Enums\StatusEnum::TrialUnScheduled ||
                                            @$currentRequest['status'] == \App\Classes\Enums\StatusEnum::TrialInvalid ||
                                            @$currentRequest['status'] == \App\Classes\Enums\StatusEnum::TrialScheduled ||
                                            @$currentRequest['status'] == \App\Classes\Enums\StatusEnum::TrialRescheduled ||
                                            @$currentRequest['status'] == \App\Classes\Enums\StatusEnum::TrialSuccessful ||
                                            @$currentRequest['status'] == \App\Classes\Enums\StatusEnum::TrialUnSuccessful ||
                                            @$currentRequest['status'] == \App\Classes\Enums\StatusEnum::RescheduleRequested)
                                            <button
                                                class="btn btn-primary py-2 
                                            @if (@$assign['label'] == \App\Classes\Enums\StatusEnum::TrialInvalid &&
                                                @$currentRequest['label'] == \App\Classes\Enums\StatusEnum::TrialInvalid) d-none @endif"
                                                form="assign-teacher-{{ $type }}-form">
                                                <div wire:loading.remove>

                                                    @if (@$assign['label'] == \App\Classes\Enums\StatusEnum::TrialInvalid)
                                                        {{ __('Move') }}
                                                    @elseif(@$currentRequest['status'] == \App\Classes\Enums\StatusEnum::TrialRescheduled ||
                                                        @$currentRequest['status'] == \App\Classes\Enums\StatusEnum::TrialSuccessful ||
                                                        @$currentRequest['status'] == \App\Classes\Enums\StatusEnum::TrialScheduled ||
                                                        @$currentRequest['status'] == \App\Classes\Enums\StatusEnum::TrialUnSuccessful ||
                                                        @$currentRequest['status'] == \App\Classes\Enums\StatusEnum::RescheduleRequested)
                                                        {{ __('Update') }}
                                                    @else
                                                        {{ __('Assign teacher') }}
                                                    @endif
                                                </div>
                                                <div wire:loading>
                                                    @include('front.partials.validator-loader')
                                                </div>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <script>
                $('.invalid-btn, .valid-btn').click(function() {
                    $('.invalid-btn, .valid-btn').removeClass('active');
                    $(this).addClass('active');
                    if ($(this).hasClass('valid-btn')) {
                        $('#coursesDropdown, .time-slot, .timetable-days h5').removeClass('disabled');
                    } else {
                        $('#coursesDropdown, .time-slot, .timetable-days h5').addClass('disabled');
                    }
                })
            </script>
            <script type="text/javascript">
                $(function() {
                    $('#datetimepicker-{{ $type }}').datetimepicker({
                        minDate: new Date()
                    });
                });
            </script>
            <script type="text/javascript">
                $('.modal').modal({
                    backdrop: 'static',
                    keyboard: false
                })

                $('#datetimepicker-{{ $type }}').on("focusout", function(e) {
                    @this.set('assign.starts_at', $("#datetimepicker-{{ $type }}").data('date'))
                });
            </script>
            <script>
                $('.coursesDropdown .dropdown-item').click(function() {
                    $('.coursesDropdown .dropdown-item').removeClass('selected');
                    $(this).addClass('selected');
                    $('.select-teacher').removeClass('d-none');
                })
                $('.select-teacher .teacher').click(function() {
                    $('.select-teacher .teacher').removeClass('selected');
                    $(this).addClass('selected');
                })
            </script>
        @endif
        @if (count($trialRequests) &&
            ($type != \App\Classes\Enums\StatusEnum::TrialUnScheduled && $type != \App\Classes\Enums\StatusEnum::TrialInvalid))
            <script>
                $('.cancelTrial').on('click', function() {
                    var trial_value = ($(this).data('date'));
                    Swal.fire({
                        text: 'Are you sure you want to Cancel the trial',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Cancel!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            console.log($(this).data('date'));
                            /* here we will emit to backend for whatever we want to do */
                            swal.close()
                            console.log('Trial Cancelled');
                        }
                    })
                });
            </script>
        @endif
    @elseif($type == 'summary')
        @if (is_array($summary))

            <div class="row">

                <div class="col-md-8 col-12">
                    <div class="summary_chart shadow">
                        <div class="py-3">
                            <h4 class="d-inline text-med px-14 px-4">Total No of Trial</h4>
                        </div>
                        <hr class="my-0">
                        <div class="mt-4 px-4 chart_container">
                            <div id="trialSummary-chart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12 mt-md-0 mt-4">
                    <div class="mx-auto summary_container shadow">
                        <div class="py-3 d-flex justify-content-between px-4">
                            <h4 class="d-inline text-med px-14 mb-0 mt-1 mt-sm-0">Monthly Summary</h4>
                            <div class="text-muted px-14 month-btn">
                                <div>
                                    <i class="fa fa-angle-left text-muted pe-1 cursor-pointer left-arrow-summary"
                                        aria-hidden="true"
                                        wire:click="$emit('RefreshSummary','{{ \Carbon\Carbon::parse($current_date)->subMonth() }}')"></i>
                                    {{ \Carbon\Carbon::parse($current_date)->format('F') }}
                                    <i class="ps-1 fa fa-angle-right text-muted cursor-pointer right-arrow-summary"
                                        aria-hidden="true"
                                        wire:click="$emit('RefreshSummary','{{ \Carbon\Carbon::parse($current_date)->addMonth() }}')"
                                        data-value="{{ \Carbon\Carbon::now()->subMonth() }}"></i>
                                </div>
                            </div>
                        </div>
                        <hr class="my-0">
                        <div class="mt-4 px-4 px-14 pb-5">
                            <div class="pb-3 text-sb">
                                Total Number of Classes In {{ \Carbon\Carbon::parse($current_date)->format('F') }}
                            </div>
                            <div class="py-3 row summary_item">
                                <div class="col-6 text-start text-med">
                                    Total Trials
                                </div>
                                <div class="col-6 text-end text-sb">
                                    {{ $summary['total'] ?? '--' }}
                                </div>
                            </div>
                            @foreach (\App\Classes\Enums\StatusEnum::$Trials_With_Summary as $status)
                                @isset($summary['details'])
                                    <div class="py-3 row summary_item">
                                        <div class="col-6 text-start text-med">
                                            {!! beautify_slug($status) !!}
                                        </div>
                                        <div class="col-6 text-end text-sb">
                                            <?php $stat_count = 0;
                                            foreach ($summary['details'] as $data) {
                                                if ($status == $data['status']) {
                                                    $stat_count = $data['count'];
                                                }
                                            }
                                            ?>
                                            {!! $stat_count !!}
                                        </div>
                                    </div>
                                @endif
            @endforeach

    </div>
    </div>
    </div>
    </div>

    <script>
        const myChartFunction = (data, date) => {
            var data = data;
            var successfularray = [];
            var unsuccessfularray = [];

            data.forEach(element => {

                if (element.status == 'trial_successful') {
                    successfularray.push(element.count);
                } else if (element.status == 'trial_unsuccessful') {
                    unsuccessfularray.push(element.count);
                }
            });
            var options = {
                series: [{
                    name: 'Trial Successful',
                    data: successfularray
                }, {
                    name: 'Trial Unsuccessful',
                    data: unsuccessfularray
                }],
                chart: {
                    type: 'bar',
                    height: '100%',
                    stacked: true,
                    toolbar: {
                        show: true
                    },
                    zoom: {
                        enabled: false,
                    }
                },
                colors: ['#559739', '#FF3B3B'],
                responsive: [{
                    breakpoint: 992,
                    options: {
                        legend: {
                            position: 'bottom',
                            offsetX: -10,
                            offsetY: 8
                        }
                    }
                }],
                plotOptions: {
                    bar: {
                        horizontal: false,
                        borderRadius: 10
                    },
                },
                xaxis: {
                    type: 'category',
                    categories: date,
                },
                legend: {
                    position: 'right',
                    offsetY: 40
                },
                fill: {
                    opacity: 1
                }

            };
            $('#trialSummary-chart').html(''); // this will clear old created charts
            var myChart = new ApexCharts(document.querySelector("#trialSummary-chart"), options);
            myChart.render();
        }




        window.addEventListener('refresh-chart', (event) => {
            myChartFunction(event.detail.data, [event.detail.date]);
        })
    </script>
    <a href={{ url('/en/sales-support/dashboard') }}
        class="btn btn-outline-primary back-btn text-med float-end clearfix">Back</a>
    @endif

    @endif
    </div>
    @push('after-style')
        <style>
            hr {
                border-top: 2px solid darkgray;
            }

            .back-btn {
                width: 150px;
                height: 44px;
                margin: 49px 0;
                line-height: 2;
            }

            .chart_container {
                height: 80%;
            }

            .chart_container .apexcharts-menu {
                min-width: 112px;
            }

            #moreButtonDropdown {
                cursor: pointer;
            }

            #moreButton-menu {
                margin-top: 8px !important;
            }

            #moreButton-menu .dropdown-item:hover {
                background-color: var(--secondary-color);
            }

            #moreButton-menu .dropdown-item {
                line-height: 1.7;
                font-size: var(--px-14);
                font-weight: 500;
            }

            #moreButtonDropdown:focus {
                box-shadow: none;
            }

            /* assign-teacher modal styles start from here */
            .action-btn {
                height: 44px;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .assign-teacher .modal-footer {
                display: block;
            }

            .assign-teacher .modal-dialog {
                max-width: 970px;
            }

            .assign-teacher .modal-body,
            .assign-teacher .modal-footer {
                padding-left: 60px;
                padding-right: 60px;
            }

            /* .assign-teacher .modal-header {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        padding-left: 73px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        padding-right: 30px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } */

            .assign-teacher .modal-footer .col-3.text-muted {
                font-size: 12px;
                line-height: 1.8;
            }

            .assign-teacher .modal-header .valid-btn,
            .invalid-btn {
                width: 103px;
                height: 44px;
                border: 1px solid #cccaca;
                color: #cccaca;
            }

            .assign-teacher .modal-header .valid-btn.active {
                background: #559739;
                color: white;
                border: 1px solid #559739;
            }

            .assign-teacher .modal-header .invalid-btn.active {
                background: #e94235;
                border: 1px solid #e94235;
                color: white !important;
            }

            .assign-teacher .modal-header .valid-btn {
                border-radius: 2px 0px 0px 2px;

            }

            .assign-teacher .modal-header .invalid-btn {
                border-radius: 0px 2px 2px 0px;

            }

            .assign-teacher .modal-header .valid-btn:not(.active),
            .assign-teacher .modal-header .invalid-btn:not(.active):hover {
                margin: 0 !important;
                color: #cccaca;
            }

            .assign-teacher .modal-header .valid-btn:focus,
            .assign-teacher .modal-header .invalid-btn:focus {
                box-shadow: none;
            }


            .assign-teacher .modal-body #coursesDropdown {
                display: flex;
                justify-content: space-between;
                align-items: center;
                background: white;
                color: black;
                width: 272px;
                height: 44px;
                border: 1px solid #CCCACA;
            }

            .assign-teacher .modal-body #coursesDropdown:focus {
                box-shadow: none;
            }

            .assign-teacher .modal-body #coursesDropdown.disabled {
                background-color: #CCCACA;
                color: black !important;
            }

            .assign-teacher .modal-body .dropdown-menu .dropdown-item:hover {
                background-color: var(--secondary-color);
            }

            .assign-teacher .modal-body .dropdown-menu .dropdown-item.selected {
                background-color: var(--secondary-color);
            }

            .assign-teacher .modal-body .dropdown-menu .dropdown-item {
                line-height: 1.7;
            }

            .assign-teacher .teacher {
                cursor: pointer;
            }

            .assign-teacher .teachers-container {
                max-height: 160px;
                overflow-y: auto;
            }

            .assign-teacher .teacher {
                padding: 0px 10px;
            }

            .assign-teacher .teacher>div {
                border-bottom: 1px solid lightgray;
                padding: 7px 0;
            }

            .assign-teacher .teacher:hover,
            .assign-teacher .teacher.selected {
                background-color: var(--secondary-color);
            }

            .assign-teacher .teacher.selected {
                margin-top: 1px;
            }

            .assign-teacher .modal-header h4 {
                margin-right: 10px;
            }

            /* timetable styles start from here */
            .timetable-days {
                margin-bottom: 22px;
            }

            .timetable-days h5 {
                width: 50px;
                height: 50px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto;
                border-radius: 50%;
            }

            .timetable-days h5.disabled {
                background-color: #CCCACA !important;
            }

            .timetable-days h5.active {
                background-color: var(--secondary-color);
            }

            .timetable-wrapper {
                overflow: hidden;
            }

            .timetable-slots {
                max-height: 232px;
                overflow-y: auto;
            }

            .timetable-wrapper .timetable-slots .time-slot:first-child {
                margin-top: 0 !important;
            }

            .timetable-wrapper .timetable-slots .time-slot:last-child {
                margin-bottom: 0 !important;
            }

            .timetable-wrapper .timetable-slots .time-slot:not(.disabled) {
                height: 40px;
                cursor: pointer;
            }

            .timetable-wrapper .timetable-slots .time-slot:not(.disabled):hover,
            .timetable-wrapper .timetable-slots .time-slot:not(.disabled).selected {
                background-color: var(--primary-color);
                border: 1px solid var(--primary-color);
                color: white;
            }

            .timetable-wrapper .timetable-slots .time-slot {
                color: var(--primary-color);
                background-color: white;
                border: 1px solid var(--primary-color);
                border-radius: 5px;
                width: 90%;

            }

            .timetable-wrapper .timetable-slots .time-slot.disabled {
                color: #CCCACA;
                border: 1px solid #CCCACA;
            }

            .day:not(.wrong-month) {
                background: var(--secondary-color);
            }

            @media screen and (max-width:576px) {

                .timetable-wrapper .timetable-slots,
                .timetable-wrapper .timetable-days {
                    min-width: 800px;
                }

                .timetable-wrapper {
                    overflow-x: scroll;
                    padding-bottom: 15px;
                }

                .assign-teacher .modal-body .trial-info p:first-child {
                    font-weight: 500 !important;
                }

                .assign-teacher .modal-body .trial-info p:last-child {
                    font-weight: 600 !important;
                }

                .action-btn {
                    width: 100% !important;
                }

                .assign-teacher .modal-header .valid-btn,
                .invalid-btn {
                    width: 75px !important;
                    height: 37px !important;
                }

                .assign-teacher .modal-header h4 {
                    font-size: 14px;
                    font-weight: 600;
                    margin-right: 0;
                }

                .assign-teacher .modal-header {
                    padding-left: 25px !important;
                    padding-right: 15px !important;
                }

                .assign-teacher .modal-body,
                .assign-teacher .modal-footer {
                    padding-left: 25px !important;
                    padding-right: 25px !important;
                }

                .assign-teacher .modal-body .trial-info--wrapper {
                    width: 100%;
                }

                .scheduled_trial-status {
                    position: absolute;
                    right: 42px;
                }
            }

            .time-slot.disabled-slots {
                cursor: not-allowed !important;
                background-color: lightgrey !important;
            }

            .time-slot.disabled-slots:hover {
                border: 1px solid #D9D9D9 !important;
                color: #707070 !important;
            }

            .calendar .event-container .day:not(.wrong-month) {
                background: var(--secondary-color);
            }

            /* timetable styles end here */

            /* assign-teacher modal styles end here */
            @media screen and (min-width:1200px) {

                .summary_chart,
                .summary_container {
                    height: 520px;
                }
            }

            @media screen and (min-width:768px) and (max-width:991px) {

                .summary_chart,
                .summary_container {
                    height: 700px;
                }

                .scheduled_trial-status {
                    margin-top: 7px;
                }

                .summary_container .px-14 {
                    font-size: 12px;
                }
            }

            @media screen and (min-width:992px) and (max-width:1199px) {

                .summary_chart,
                .summary_container {
                    height: 600px;
                }
            }

            @media screen and (max-width:767px) {
                .summary_chart {
                    height: 500px;
                }
            }

            @media screen and (min-width:576px) and (max-width:991px) {
                .vertical-table .status-pill {
                    font-size: 10px;
                }
            }

            @media screen and (min-width: 576px) {
                .action-btn {
                    max-width: 200px;
                    ;
                }
            }

            @media screen and (min-width:575px) {
                .right-col {
                    width: 205px;
                }
            }

            .invalid-feedback {
                display: block;
            }
        </style>
    @endpush

    @push('after-script')
        <script>
            $(document).on('click', '.calendar .day ', function(e) {
                var date = $(this).data('date');
                Livewire.emit('sendDateForSlots', date)
                console.log('date: ', date);
                // i got the date he selected 
                //  @assign['date']=date;
            });
            $(document).on('click', '.new-send', function(e) {
                _this = $(this);
                setTimeout(() => {
                    if (_this.is(':checked')) {
                        _this.prop('checked', false);
                    } else {
                        _this.prop('checked', true);
                    }
                });
                return false;
            });
            $(document).on('click', 'span.slider',
                function() {
                    $(this).parent().find('input').click();
                })
        </script>
    @endpush
