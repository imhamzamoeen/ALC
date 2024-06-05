@isset($notification)
    <?php
    $NotificationContent = json_decode($notification->json, true); // we have stored that as an toArray()
    ?>
    {{-- <li class="dropdown-item text-wrap">
       
        <div class="d-flex justify-content-start">
            <small class="pe-3 pt-1"><i class="fas fa-circle color-primary fa-xs"></i></small>
            <P class=" mb-0">{{ $NotificationContent['WeeklyClass']['student']['name'].'`s '.$NotificationContent['WeeklyClass']['student']['course']['title'] }} is going to start at {{ convertTimeToUSERzone($NotificationContent['WeeklyClass']['class_time'],$timezone)->format('d M, Y h:i A') }}</P>
        </div>

    </li> --}}

    <div class="px-14 py-3 text-med container px-0">
        <div class="row">
            <div class="col-1 pe-0">
                <i class="color-primary fa-circle fa-xs fas" aria-hidden="true"></i>
            </div>
            <div class="col-11 pe-0 pe-sm-2 ps-1">
                <div class="pb-2">
                    {{ $NotificationContent['WeeklyClass']['student']['name'] . '`s ' . $NotificationContent['WeeklyClass']['student']['course']['title']}}
                   `s class is going to start at
                    {{ convertTimeToUSERzone($NotificationContent['WeeklyClass']['class_time'], $timezone)->format('d M, Y h:i A') }}

                </div>
                <div class="text-muted">
                    {{ \Carbon\Carbon::parse($NotificationContent['created_at'])->diffForHumans() }}
                </div>
            </div>
        </div>

    </div>
@endisset
