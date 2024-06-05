<!-- it will have rescheule class option -->

<!-- only student and teacher gets that notification -->

@isset($notification)
<?php
    $NotificationContent = json_decode($notification->json);
    
    ?>

@if (isset($NotificationContent->Requester))
@if ($NotificationContent->RescheduleRequest->Requestable_id == $model->id &&
$NotificationContent->RescheduleRequest->Requestable_type== get_class($model))


<!-- if logged un user has asked for the request  -->
<!-- this notification is displayed when the status of the reschedle request is pending -->
@if ($NotificationContent->RescheduleRequest->status == 'pending')
<div class="px-14 py-3 text-med container px-0">
    <div class="row">
        <div class="col-1 pe-0">
            <i class="color-primary fa-circle fa-xs fas" aria-hidden="true"></i>
        </div>
        <div class="col-11 pe-0 pe-sm-2 ps-1">
            <div class="pb-2"> A Class reschedule Request has been created for
                <strong>{{ $NotificationContent->Other_Type ?? ' '}}{{ ' '.$NotificationContent->Other_Name }} 's
                    {{ $NotificationContent->Course_Name }} </strong> Class for
                <strong>
                    {{ convertTimeToUSERzone(\Carbon\Carbon::parse($NotificationContent->WeeklyClass->class_time),
                    $timezone)->format('d
                    M, Y h:i A') }}
                </strong>
                To
                <strong>
                    {{ convertTimeToUSERzone(
                    \Carbon\Carbon::parse($NotificationContent->RescheduleRequest->reschedule_date),
                    $timezone,
                    )->addMinutes($NotificationContent->RescheduleRequest->reschedule_slot_id * 30)->format('d
                    M, Y h:i A') }}
                </strong>
            </div>
            <div class="text-muted">
                {{ $notification->created_at->diffForHumans() }}
            </div>
        </div>
    </div>
</div>
@elseif ($NotificationContent->RescheduleRequest->status == 'approved')
<div class="px-14 py-3 text-med container px-0">
    <div class="row">
        <div class="col-1 pe-0">
            <i class="color-primary fa-circle fa-xs fas" aria-hidden="true"></i>
        </div>
        <div class="col-11 pe-0 pe-sm-2 ps-1">
            <div class="pb-2">A Class Reschedule Request was approved for
                <strong>{{ $NotificationContent->Other_Type ?? ' '}}{{ ' '.$NotificationContent->Other_Name }} 's
                    {{ $NotificationContent->Course_Name }} </strong>Class
                <strong>
                    {{ convertTimeToUSERzone(
                    \Carbon\Carbon::parse($NotificationContent->old_class_time ??
                    $NotificationContent->WeeklyClass->class_time),
                    $timezone,
                    )->format('d
                    M, Y h:i A') .
                    ' to ' .
                    convertTimeToUSERzone(
                    \Carbon\Carbon::parse($NotificationContent->RescheduleRequest->reschedule_date),
                    $timezone,
                    )->addMinutes($NotificationContent->RescheduleRequest->reschedule_slot_id * 30)->format('d
                    M, Y h:i A') }}
                </strong>
            </div>
            <div class="text-muted">
                {{ $notification->created_at->diffForHumans() }}
            </div>
        </div>
    </div>

</div>
@else
<div class="px-14 py-3 text-med container px-0">
    <div class="row">
        <div class="col-1 pe-0">
            <i class="color-primary fa-circle fa-xs fas" aria-hidden="true"></i>
        </div>
        <div class="col-11 pe-0 pe-sm-2 ps-1">
            <div class="pb-2">A Class Reschedule Request was Rejected for <strong>
                    {{ $NotificationContent->Other_Type ?? ' '}}{{ ' '.$NotificationContent->Other_Name . '`s ' .
                    $NotificationContent->Course_Name }}
                </strong> Class
                <strong>
                    {{ convertTimeToUSERzone(
                    \Carbon\Carbon::parse($NotificationContent->old_class_time ??
                    $NotificationContent->WeeklyClass->class_time),
                    $timezone,
                    )->format('d
                    M, Y h:i A') .
                    ' to ' .
                    convertTimeToUSERzone(
                    \Carbon\Carbon::parse($NotificationContent->RescheduleRequest->reschedule_date),
                    $timezone,
                    )->addMinutes($NotificationContent->RescheduleRequest->reschedule_slot_id * 30)->format('d
                    M, Y h:i A') }}
                </strong>
            </div>
            <div class="text-muted">
                {{ $notification->created_at->diffForHumans() }}
            </div>
        </div>
    </div>

</div>
@endif
@else
<!-- request main n nhe ki kisi dosry n ki h -->
@if ($NotificationContent->RescheduleRequest->status == 'pending')
<div class="px-14 py-3 text-med container px-0">
    <div class="row">
        <div class="col-1 pe-0">
            <i class="color-primary fa-circle fa-xs fas" aria-hidden="true"></i>
        </div>
        <div class="col-11 pe-0 pe-sm-2 ps-1" id="{{ $NotificationContent->RescheduleRequest->id }}">
            <div class="pb-2 notification-message">The
                <strong>{{ $NotificationContent->Requester . ', ' . $NotificationContent->Requester_Name.', ' }}</strong>
                has requested to reshedule

                <strong>{{ $NotificationContent->Other_Type ?? ' '}}{{ ' '.$NotificationContent->Other_Name . '`s ' .
                    $NotificationContent->Course_Name }}</strong>
                Class for
                <strong>
                    {{ convertTimeToUSERzone(
                    \Carbon\Carbon::parse($NotificationContent->old_class_time ??
                    $NotificationContent->WeeklyClass->class_time),
                    $timezone,
                    )->format('d
                    M, Y h:i A') .
                    ' to ' .
                    convertTimeToUSERzone(
                    \Carbon\Carbon::parse($NotificationContent->RescheduleRequest->reschedule_date),
                    $timezone,
                    )->addMinutes($NotificationContent->RescheduleRequest->reschedule_slot_id * 30)->format('d
                    M, Y h:i A') }}
                </strong>
                is waiting for response
            </div>
            <div class="text-muted">
                {{ $notification->created_at->diffForHumans() }}
            </div>
            @if (auth()->user()->user_type!='teacher-coordinator')
            <!-- mltb jis ka notificaiton h khali wohi approve disaoorive kr sakta  -->
            <div class="mt-2 rescheule_request_actions">
                <div>
                    <span><a href="javascript:void(0)" data-notificationid={{ $notification->id }}
                            data-weeklyclassid="{{ $NotificationContent->WeeklyClass->id }}"
                            @if (auth()->user()->user_type == 'teacher') data-teacherid="{{ auth()->user()->id }}"
                            @elseif(!is_null(request()->route('student'))) data-studentid="{{
                            request()->route('student')->id }} " @endif
                            data-reschedulerequestid="{{ $NotificationContent->RescheduleRequest->id }}"
                            class="btn btn-primary btn-accept-reschedule-class py-2 px-4">Accept</a></span><span><a
                            href="javascript:void(0)" data-notificationid={{ $notification->id }}
                            data-weeklyclassid="{{ $NotificationContent->WeeklyClass->id }}"
                            data-reschedulerequestid="{{ $NotificationContent->RescheduleRequest->id }}"
                            @if (auth()->user()->user_type == 'teacher') data-teacherid="{{ auth()->user()->id }}"
                            @elseif(!is_null(request()->route('student'))) data-studentid="{{
                            request()->route('student')->id }} " @endif
                            class="btn btn-outline-primary btn-decline-reschedule-class py-2 px-4
                            ms-3">Decline</a></span>
                </div>
                <span class="px-12 request-timer" style="display: none"><span class="text-success request-accepted"
                        style="display: none">Request
                        Accepted</span><span class="text-danger request-rejected" style="display: none">Request
                        Rejected</span>
                    <span class="undo-btn text-decoration-underline ms-2 cursor-pointer"><i class="fa fa-undo me-1"
                            aria-hidden="true"></i>Undo</span><span class="ms-1 seconds">5</span><span>
                        Seconds</span></span>
                <!-- what we do if request has student parameter it mean student is logged in else if loggedin user is teacher then add its id to data it -->

                <!-- what we do if request has student parameter it mean student is logged in else if loggedin user is teacher then add its id to data it -->
            </div>
            @endif
        </div>
    </div>

</div>
@elseif($NotificationContent->RescheduleRequest->status == 'approved')
<div class="px-14 py-3 text-med container px-0">
    <div class="row">
        <div class="col-1 pe-0">
            <i class="color-primary fa-circle fa-xs fas" aria-hidden="true"></i>
        </div>
        <div class="col-11 pe-0 pe-sm-2 ps-1">
            <div class="pb-2">
                @if ($NotificationContent->Requester == 'Teacher-Coordinator')
                The

                <strong>{{ $NotificationContent->Requester . ' ' . $NotificationContent->Requester_Name }}
                </strong>
                has rescheduled
                <strong>
                    {{ $NotificationContent->Other_Type ?? ' ' }}{{ ' '.$NotificationContent->Other_Name . '`s ' .
                    $NotificationContent->Course_Name }}
                </strong>
                @else

                The

                <strong>{{ $NotificationContent->Other_Type ?? ' '}}{{ ' '.$NotificationContent->Other_Name }}
                </strong>
                has Approved the rescheduled request of
                <strong>
                    {{ $NotificationContent->Requester.' '.$NotificationContent->Requester_Name . '`s ' .
                    $NotificationContent->Course_Name }}
                </strong>
                @endif
                Class for
                <strong>
                    {{ convertTimeToUSERzone(
                    \Carbon\Carbon::parse($NotificationContent->old_class_time ??
                    $NotificationContent->WeeklyClass->class_time),
                    $timezone,
                    )->format('d
                    M, Y h:i A') .
                    ' to ' .
                    convertTimeToUSERzone(
                    \Carbon\Carbon::parse($NotificationContent->RescheduleRequest->reschedule_date),
                    $timezone,
                    )->addMinutes($NotificationContent->RescheduleRequest->reschedule_slot_id * 30)->format('d
                    M, Y h:i A') }}
                </strong>
            </div>
            <div class="text-muted">
                {{ $notification->created_at->diffForHumans() }}
            </div>

        </div>
    </div>

</div>
{{-- <P class=" mb-0">A Class Reschedule Request was approved by you for the class
    {{
    convertTimeToUSERzone(\Carbon\Carbon::parse($NotificationContent->WeeklyClass->class_time),$timezone)->format('d
    M, Y h:i A') }} to {{
    convertTimeToUSERzone(\Carbon\Carbon::parse($NotificationContent->RescheduleRequest->reschedule_date
    ),$timezone)->addMinutes($NotificationContent->RescheduleRequest->reschedule_slot_id*30)->format('d
    M, Y h:i A') }}</P> --}}
@else
<div class="px-14 py-3 text-med container px-0">
    <div class="row">
        <div class="col-1 pe-0">
            <i class="color-primary fa-circle fa-xs fas" aria-hidden="true"></i>
        </div>
        <div class="col-11 pe-0 pe-sm-2 ps-1">
            <div class="pb-2"> @if ($NotificationContent->Requester == 'Teacher-Coordinator')
                The

                <strong>{{ $NotificationContent->Requester . ' ' . $NotificationContent->Requester_Name }}
                </strong>
                has rescheduled
                <strong>
                    {{ $NotificationContent->Other_Type ?? ' '}}{{ ' '.$NotificationContent->Other_Name . '`s ' .
                    $NotificationContent->Course_Name }}
                </strong>
                @else

                The

                <strong>{{ $NotificationContent->Other_Type ?? ' '}}{{ ' '.$NotificationContent->Other_Name }}
                </strong>
                has Rejected the rescheduled request of
                <strong>
                    {{ $NotificationContent->Requester.' '.$NotificationContent->Requester_Name . '`s ' .
                    $NotificationContent->Course_Name }}
                </strong>
                @endif
                Class for
                <strong>
                    {{ convertTimeToUSERzone(
                    \Carbon\Carbon::parse($NotificationContent->old_class_time ??
                    $NotificationContent->WeeklyClass->class_time),
                    $timezone,
                    )->format('d
                    M, Y h:i A') .
                    ' to ' .
                    convertTimeToUSERzone(
                    \Carbon\Carbon::parse($NotificationContent->RescheduleRequest->reschedule_date),
                    $timezone,
                    )->addMinutes($NotificationContent->RescheduleRequest->reschedule_slot_id * 30)->format('d
                    M, Y h:i A') }}
                </strong>
            </div>
            <div class="text-muted">
                {{ $notification->created_at->diffForHumans() }}
            </div>

        </div>
    </div>

</div>
{{-- <P class=" mb-0">A Class Reschedule Request was Rejected by you for the class
    {{
    convertTimeToUSERzone(\Carbon\Carbon::parse($NotificationContent->WeeklyClass->class_time),$timezone)->format('d
    M, Y h:i A') }} to {{
    convertTimeToUSERzone(\Carbon\Carbon::parse($NotificationContent->RescheduleRequest->reschedule_date
    ),$timezone)->addMinutes($NotificationContent->RescheduleRequest->reschedule_slot_id*30)->format('d
    M, Y h:i A') }}</P> --}}
@endif
@endif
@endif
@endisset