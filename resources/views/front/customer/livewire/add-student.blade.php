<div>
    @include('front.customer.livewire.add-student-modal')

    @if (!$user->profiles()->count())
        <div class="h-100 d-flex justify-content-center mt-5 pt-5 align-items-center flex-column ">
            <img src="{{ asset('images/empty-state.svg') }}" class="cursor-pointer" data-id="add-student"
                wire:click="$emit('resetStudentForm')" />
            <p class="d-md-none d-block">{{ __('No students Added so far') }}</p>
            <p class="d-md-none d-block">{{ __('Click to add students') }}</p>
            <p class="d-md-block d-none">{{ __('No students Added so far. Click to add students') }}</p>
        </div>
    @else
        <table class="vertical-table table-borderless student-list">
            <thead class="table-header">
                <tr>
                    <th scope="col" class="align-middle">{{ __('Student Name') }}</th>
                    <th scope="col">{{ __('Courses') }}</th>
                    <th scope="col" class="align-middle">{{ __('Status') }}</th>

                    {{-- todo: We will use this in mvp 2 --}}
                    <th scope="col">{{ __('Action') }}</th>
                    <th scope="col">{{ __('Settings') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $key => $student)
                    <tr>
                        <td data-label="Student Name">
                            <a href="{{ route('customer.user.profile', [app()->getLocale(), 'child' => $student]) }}"
                                style=" text-decoration: none; color: inherit;">
                                <div class="row">
                                    <div class="col-lg-2 col-md-3 d-none d-md-inline-block ">

                                        {!! generate_profile_picture_by_name(@$student->name, 45) !!}
                                    </div>
                                    <div class="col-12 col-lg-10 col-md-9 align-self-center pe-0 ps-0 ps-md-4"
                                        style="text-transform: capitalize">
                                        {{ @$student->name }}</div>
                                </div>
                            </a>
                            {{-- <span class=" d-none d-md-inline-block "> {!! generate_profile_picture_by_name(@$student->name,
                        50) !!}</span> {{ @$student->name }} --}}
                        </td>
                        <td data-label="Courses">{{ @$student->course->title }}</td>
                        <td data-label="Status">
                            <p class="mt-0 mb-0"> <span
                                    class="badge status-pill {{ \App\Classes\Enums\StatusEnum::$Subscription_status_color[@$student->subscription_status] ?? 'status-primary' }}">{{ beautify_slug(@$student->subscription_status) }}</span>
                            </p>
                        </td>
                        {{-- <td data-label="Subscriptions">
                    <button class="btn btn-outline-primary"></button>
                </td> --}}
                        {{-- todo: We will use this in mvp 2 --}}

                        <td data-label="Action" id="subscription-action-{{ $student->id }}">
                            @if ($student->subscription_status == \App\Classes\Enums\StatusEnum::TrialSuccessful)
                                @if (!$student->trialRequest->trialClass->trialReview)
                                    @include('front.customer.partials.submit-review-btn')
                                @else
                                    @include('front.customer.partials.buy-subscription-btn', [
                                        'student' => $student->id,
                                    ])
                                @endif
                            @elseif($student->subscription_status == \App\Classes\Enums\StatusEnum::SubscriptionExtend ||
                                $student->subscription_status == \App\Classes\Enums\StatusEnum::SubscriptionEnd)
                                @include('front.customer.partials.buy-subscription-btn', [
                                    'student' => $student->id,
                                ])
                            @elseif($student->subscription_status == \App\Classes\Enums\StatusEnum::TrialRescheduled ||
                                $student->subscription_status == \App\Classes\Enums\StatusEnum::TrialScheduled ||
                                $student->subscription_status == \App\Classes\Enums\StatusEnum::TrialRequested)
                                <button class="btn btn-outline-primary viewDetails-btn action-btn py-2"
                                    data-bs-toggle="modal"
                                    data-bs-target="#trial-details-modal-{{ @$student->id }}">{{ __('View Details') }}</button>
                            @else
                                --
                            @endif
                        </td>
                        {{-- <td data-label="Subscription">

                    @if ($loop->first)
                    <button class="btn btn-outline-primary py-2 px-4"
                        onclick="location.href = '/en/customer/change-subscription';">{{ __('Buy Subscriptions')
                        }}</button>

                    @elseif($loop->iteration == 2)
                    <button class="btn btn-outline-danger border-0 bg-transparent py-2 text-sm-center text-end"
                        onclick="location.href = '/en/customer/change-subscription';"><i class="fa fa-times me-1"></i>
                        {{ __('Delete Request') }}</button>
                    @else
                    <button class="btn btn-outline-primary py-2" data-bs-toggle="modal"
                        data-bs-target="#review-trial-modal">{{ __('Review Trial') }}</button>
                    @endif
                </td> --}}
                        <td data-label="Settings">

                            {{-- <a href="#" class="cursor-pointer custom-link" data-bs-toggle="modal"
                        data-bs-target="#trial-details-modal-{{@$student->id}}">{{ __('Edit Settings') }}</a> --}}
                            @if ($student->subscription_status == \App\Classes\Enums\StatusEnum::SubscriptionExtend ||
                                $student->subscription_status == \App\Classes\Enums\StatusEnum::SubscriptionActive ||
                                $student->subscription_status == \App\Classes\Enums\StatusEnum::SubscriptionEnd)
                                <a {{-- id="toolTipsettings" --}} class="toolTipsettings text-decoration-none color-primary"
                                    href="{{ route('customer.user.profile', [app()->getLocale(), 'child' => $student]) }}"
                                    data-title="Edit Settings"
                                    class="cursor-pointer custom-link">{{ __('Edit Settings') }}</a>
                            @else
                                --
                            @endif
                            {{-- todo: We will use this in mvp 2 --}}
                            {{-- <div class="dropdown">
                        <a class="text-decoration-none fw-bold cursor-pointer color-primary"
                            data-bs-toggle="dropdown">Edit Setting </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="#">Schedule Change</a></li>
                            <li><a class="dropdown-item" href="#">Package Change</a></li>
                            <li><a class="dropdown-item" href="#">Vocation Change</a></li>
                            <li><a class="dropdown-item" href="#">Cancellation Request</a></li>
                            <li><a class="dropdown-item" href="#">Course Change</a></li>
                        </ul>
                    </div> --}}
                        </td>


                    </tr>
                @endforeach
            </tbody>
        </table>

        @foreach ($students as $student)
            @include('front.customer.components.trial-detail-modal', [
                'student' => $student,
            ])
        @endforeach


        @include('front.customer.components.review_trial_modal')
    @endif
</div>

@push('after-style')
    <style>
        .student-list .btn-outline-danger:hover {
            color: #DC3545 !important;
        }

        /* .review-trial-action,
                                    .viewDetails-btn {
                                        width: 150px;
                                        height: 40px;
                                    }
                                    .buySubscription-btn {
                                        width: 100%;
                                        max-width: 185px;
                                    } */
        .action-btn {
            width: 100%;
            max-width: 184px;
            height: 44px;
            padding: 0;
            line-height: 1.8;
        }

        @media screen and (min-width: 576px) and (max-width: 767px) {
            .vertical-table .action-btn {
                max-width: 150px;
            }
        }
    </style>
@endpush

@push('after-script')
    <script>
        $(document).ready(function() {
            $('.review-trial-action').on('click', function() {
                var trialClassId = $(this).data('trialclassid');
                var studentId = $(this).data('studentid');
                $('input[data-id="trial_class_id_inp"]').val(trialClassId)
                $('input[data-id="trial_class_student_inp"]').val(studentId)
                $('#review-trial-modal').modal('toggle');
            })

            $('#review-trial-form').on('submit', function(e) {
                e.preventDefault();

                var form = $(this);
                var fillableId = 'subscription-action-' + $('input[data-id="trial_class_student_inp"]')
                    .val()
                var url = form.attr('action'); //get submit url [replace url here if desired]
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(), // serializes form input
                    success: function(data) {
                        if (data.fillableData !== '') {
                            $('#' + fillableId).html(data.fillableData)
                        }
                        $('#review-trial-modal').modal('toggle');
                        Toast.fire({
                            icon: data.status,
                            title: data.message,
                            timer: 1500
                        })
                    },
                    error: function(data) {
                        $('#review-trial-modal').modal('toggle');
                        Toast.fire({
                            icon: 'error',
                            title: 'Something went wrong! Please try again.',
                            timer: 1500
                        })
                    },
                    complete: function() {
                        $('.fa-star').toggleClass('fa-star-o');
                        $('.rating-value').val(0);


                    }
                });
            })

            $('#review-trial-request-form').on('submit', function(e) {
                e.preventDefault();

                var form = $(this);
                var fillableId = 'subscription-action-' + $('input[data-id="trial_class_student_inp"]')
                    .val()
                var url = form.attr('action'); //get submit url [replace url here if desired]
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(), // serializes form input
                    success: function(data) {
                        if (data.fillableData !== '') {
                            $('#' + fillableId).html(data.fillableData)
                        }
                        $('#review-trial-modal').modal('toggle');
                        Toast.fire({
                            icon: data.status,
                            title: data.message,
                            timer: 1500
                        })
                    },
                    error: function(data) {
                        $('#review-trial-modal').modal('toggle');
                        if (data.responseJSON !== 'undefined') {
                            if (data.responseJSON.message !== 'undefined') {
                                Toast.fire({
                                    icon: 'error',
                                    title: data.responseJSON.message,
                                    timer: 1500
                                })
                            } else {
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Something went wrong! Please try again.',
                                    timer: 1500
                                })
                            }
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: 'Something went wrong! Please try again.',
                                timer: 1500
                            })
                        }
                    }
                });
            })
        })
    </script>
@endpush
