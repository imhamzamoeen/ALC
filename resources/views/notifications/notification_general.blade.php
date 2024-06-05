@isset($notification)
    <?php
    $NotificationContent = json_decode($notification->json);
    ?>
    <li class="dropdown-item text-wrap">
        <div class="d-flex justify-content-start">
            <small class="pe-3 pt-1"><i class="fas fa-circle color-primary fa-xs"></i></small>
            <P class=" mb-0">A trial class has been Scheduled against you</P>
        </div>

        {{-- <p class="text-muted" style="padding-left: 26px;">
            {{ convertTimeToUSERzone(\Carbon\Carbon::parse($NotificationContent->trialClass->starts_at), $model->timezone)->format('d
                                M, Y h:i A') }}
        </p> --}}
    </li>
@endisset
