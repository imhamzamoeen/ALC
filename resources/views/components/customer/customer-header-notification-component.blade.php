@if (isset($Model))
    @forelse ($Model->profiles as $profile)
        @forelse ($profile->notifications as $notification)
            <div class="text-sb text-capitalize">{{ $profile->name }}</div>
            @include('notifications.' . $notification->type, [
                '$notification' => $notification,
                'model' => $profile,
                'timezone' => $profile->timezone, // is timezone main sara time convert hota   mtlb abhi har class har bachy k timezone k hissab s convert hoti
            ])
        @empty
        @endforelse
    @empty
        <li class="notify_padding">
            <p class="mb-0 text-center">{{ __('No Notifications') }}</p>
        </li>
    @endforelse
@endif
