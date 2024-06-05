@isset($notification)
<?php
    $NotificationContent = json_decode($notification->json);
    ?>

<div class="px-14 py-3 text-med container px-0">
    <div class="row">
        <div class="col-1 pe-0">
            <i class="color-primary fa-circle fa-xs fas" aria-hidden="true"></i>
        </div>
        <div class="col-11 pe-0 pe-sm-2 ps-1">
            <div class="pb-2">

                @if (!is_null($NotificationContent))
                    @if (auth()->user()->user_type == 'customer')
                        A Subscription has been updated against  {{$NotificationContent->subscription_updated->studentName . '`s child '}}
                    @endif
                @endif

            </div>
        </div>
    </div>

</div>

@endisset