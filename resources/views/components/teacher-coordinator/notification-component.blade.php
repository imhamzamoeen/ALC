<div class="tab-content" id="tab-content">

    <div class="tab-pane fade show active" id="teachers-notifications" role="tabpanel" aria-labelledby="teachers-tab">
        <div class="border rounded p-sm-0 mx-auto notifications">
            <div class="py-4 px-sm-4 px-3 timeline-box">


                @forelse ($Model->Teacher as $Teacher)
                    <ul> <strong>{{ ucwords($Teacher->name) }} </strong>
                        @foreach ($Teacher->notifications as $notification)
                            @include('notifications.' . $notification->type, [
                                'notification' => $notification,
                                'model' => $Teacher,
                                'timezone' => $Teacher->timezone,
                            ])
                        @endforeach

                    </ul>
                @empty
                    <div class="py-2">
                        <h5 class="px-14 fw-bold py-1 mb-0 text-center">{{ __('No Notifications to show!') }}</h5>
                    </div>
                @endforelse




            </div>
        </div>
    </div>
    <div class="tab-pane fade show" id="students-notifications" role="tabpanel" aria-labelledby="students-tab">

        <div class="border rounded p-sm-0 mx-auto notifications">
            <div class="py-4 px-sm-4 px-3 timeline-box">

                @forelse ($Model->Teacher as $Teacher)
                    @foreach ($Teacher->Students as $Student)
                        <ul> <strong>{{ ucwords($Student->name) }} </strong>
                            @foreach ($Student->notifications as $notification)
                                @include('notifications.' . $notification->type, [
                                    'notification' => $notification,
                                    'model' => $Student,
                                    'timezone' => $Student->timezone,
                                ])
                            @endforeach
                        </ul>
                    @endforeach

                @empty
                    <div class="py-2">
                        <h5 class="px-14 fw-bold py-1 mb-0 text-center">{{ __('No Notifications to show!') }}</h5>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</div>
@push('after-script')
    <script></script>
@endpush
