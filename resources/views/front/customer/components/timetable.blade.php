@isset($teacher)
    @php
    $teacherDailySlots = [];
    $slots_selected = [];
    if ($teacher->availability) {
        $teacherDailySlots = convert_teacher_availability_to_student_timezone($student, $teacher);
    }
    // $slots = get_24_hour_timeslots($student->timezone, $teacher->availability->timezone);
    $slots = get_24_hour_timeslots($student->timezone, $teacher->timezone);
    $teacherClasses = $teacher->teacherClasses->pluck('slot_id')->toArray() ?? [];
    $studentClasses = $student->routine_classes->pluck('slot_id')->toArray() ?? [];

    $id_student = $student->id;
    // dd($updateSubscription);
    @endphp

    <div class="timetable-wrapper w-100">
        <div class="row text-center mt-0 mx-0 pe-1 w-100 timetable-days w-100">
            @foreach (get_current_week() as $key => $day)
                <div class="col p-0">
                    <h5 class="text-med px-14">{{ $day->format('D') }}</h5>
                    {{-- <h6 class="text-med px-12">{{ $day->addWeek()->format('d M, Y') }}</h6> --}}
                </div>
            @endforeach
        </div>
        {{-- {{dd($action,$student,$action_paypal,$id_student)}} --}}
        <div class="row text-center m-0 timetable-slots w-100">
            <!-- simple form -->
            <form class="" role="form" method="post"
                action="{{ route('customer.paypal.post', [app()->getLocale()]) }}" id="slots-selection-form">
                @csrf
                <input name="student_id" value="{{ $id_student }}" type="hidden" id="student_id">
                <input name="total_price" value="" type="hidden" id="total-slots-price">
            </form>

            @foreach (get_current_week() as $key => $day)
                <div class="col p-0">
                    {{-- <h5 class="text-med px-14 mb-4">Mon</h5> --}}
                    <div class="ms-2 ms-sm-0 slots-col" style="height: 100%">
                        @if (isset($teacherDailySlots[$key]))
                            {{-- @dd($teacherDailySlots[$key]) --}}
                            @foreach ($teacherDailySlots[$key] as $k => $slot)
                                @php
                                    $slotTime = $slot->studentTime->format('h:i A');
                                    // dd(in_array($slot->id, $studentClasses),in_array($slot->id, $teacherClasses));
                                @endphp
                                @if (in_array($slot->id, $studentClasses))
                                    <div class="px-14 text-med p-2 mx-auto d-flex align-items-center justify-content-center my-2 time-slot available-slot selected alreadySelected "
                                        data-slottime="{{ $day->format('D') }}[{{ $slotTime ?? '' }} - {{ $slot->studentTime->addMinutes('30')->format('h:i A') ?? '' }}]"
                                        data-slotid="{{ $slot->id }}" data-toggle="tooltip"
                                        title="This is your active subscription slot. Click to unselect this slot">
                                        {{ $slotTime ?? '' }}
                                    </div>
                                    <input type="checkbox" class="slotInput d-none alreadySelectedSlot" id="alreadySelected"
                                        name="slots[]" form="slots-selection-form" value="{{ $slot->id }}">
                                    {{-- <input type="hidden" id="" value="{{ $student->subscription->price }}"> --}}
                                @elseif (!in_array($slot->id, $teacherClasses))
                                    <div class="px-14 text-med p-2 mx-auto d-flex align-items-center justify-content-center my-2 time-slot available-slot "
                                        data-slottime="{{ $day->format('D') }}[{{ $slotTime ?? '' }} - {{ $slot->studentTime->addMinutes('30')->format('h:i A') ?? '' }}]"
                                        data-slotid="{{ $slot->id }}" data-toggle="tooltip"
                                        title="Click to select or unselect a time slot">
                                        {{ $slotTime ?? '' }}
                                    </div>
                                    <input type="checkbox" class="slotInput d-none" name="slots[]"
                                        form="slots-selection-form" value="{{ $slot->id }}">
                                @else
                                    <div class="px-14 text-med p-2 mx-auto d-flex align-items-center justify-content-center my-2 time-slot permanent-disabled"
                                        data-toggle="tooltip" title="This slot is already taken">
                                        {{ $slotTime ?? '' }}
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <div style="height: 100%;"
                                class=" d-flex align-items-center flex-column justify-content-around empty">
                                <span>No Slots</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
            {{-- <div class="col p-0"> --}}{{-- <h5 class="text-med px-14 mb-4">Tue</h5> --}}{{-- <div>
                <div class="px-14 text-med p-2 mx-auto d-flex align-items-center justify-content-center my-2">1:00
                    PM
                </div>
                <div class="px-14 text-med p-2 mx-auto d-flex align-items-center justify-content-center my-2 selected">
                    2:00 PM</div>
                <div class="px-14 text-med p-2 mx-auto d-flex align-items-center justify-content-center my-2 empty">
                    -
                </div>
                <div class="px-14 text-med p-2 mx-auto d-flex align-items-center justify-content-center my-2">4:00
                    PM
                </div>
            </div>
        </div> --}}
        </div>
    </div>
    @push('after-style')
        <style>
            .timetable-days {
                margin-bottom: 22px;
            }

            .timetable-slots {
                overflow-y: auto;
                max-height: 232px;
            }

            .timetable-wrapper {
                overflow: hidden;
            }

            .timetable-slots {
                overflow-y: auto;
            }

            .timetable-wrapper .timetable-slots .col .time-slot:first-child {
                margin-top: 0 !important;
            }

            .timetable-wrapper .timetable-slots .col .time-slot:last-child {
                margin-bottom: 0 !important;
            }

            .timetable-wrapper .timetable-slots .col .time-slot {
                height: 40px;
                cursor: default;
            }

            .timetable-wrapper .timetable-slots .col .time-slot.available-slot {
                border: 1px solid rgba(10, 92, 214, 1) !important;
                box-shadow: 0px 0px 3px 0px rgba(0, 0, 0, 0.5);

            }

            .timetable-wrapper .timetable-slots .col .time-slot:not(.empty):hover,
            .timetable-wrapper .timetable-slots .col .time-slot.selected:not(.empty) {
                background-color: var(--primary-color);
                border: 1px solid var(--primary-color);
                color: white;
                width: 90%;
            }

            .timetable-wrapper .timetable-slots .col .time-slot:not(.empty),
            .timetable-wrapper .timetable-slots .col .time-slot:not(.selected)[data-focus="focus"]:hover {
                color: #707070;
                background-color: #F3F3F3;
                border: 1px solid #D9D9D9;
                border-radius: 5px;
                width: 90%;
            }

            @media screen and (max-width:576px) {

                .timetable-wrapper>.timetable-slots,
                .timetable-wrapper>.timetable-days {
                    min-width: 800px;
                }

                .timetable-wrapper {
                    overflow-x: scroll;
                    padding-bottom: 15px;
                }
            }

            .time-slot.disabled-slots,
            .permanent-disabled {
                cursor: not-allowed !important;
                background-color: lightgrey !important;
            }

            /* .alreadySelected {
                                                                                                                                                                                                        border: 1px solid #D9D9D9 !important;
                                                                                                                                                                                                        background-color: #1b6e4c !important;
                                                                                                                                                                                                    } */

            .time-slot.disabled-slots:hover,
            .permanent-disabled:hover {
                border: 1px solid #D9D9D9 !important;
                color: #707070 !important;
            }
        </style>
    @endpush
    @push('after-script')
        <script>
            let changeCharges = 0;
            @if (isset($updateSubscription))
                changeCharges = 45;
            @endif

            let COUPON_ALREADY_CLICKED = false;

            function addNoSlotColumn() {
                let max = 0;
                $('.timetable-slots .slots-col').each(function(item) {
                    let length = $(this).children('div').length;
                    if (length > max) {
                        max = length;
                    }
                });
                if (max > 1 && max < 5) {
                    // console.log('running ', max);
                    $('.timetable-slots .empty').append('<span>No Slots</span>')
                } else if (max > 4) {
                    // console.log('running ', max);
                    $('.timetable-slots .empty').append('<span>No Slots</span><span>No Slots</span>')
                }
            }
            $(document).ready(function() {
                $('.available-slot').not('.disabled-slots').tooltip()
                $('.permanent-disabled').tooltip()
                addNoSlotColumn();
                let slots = $('.slotInput:checked').val();
                alreadySelectedSlots();

            });
            var slotLimit = '{{ settings('classes-limit', true, \App\Classes\AlQuranConfig::MaxProfiles) }}'

            @isset($select_limit)
                slotLimit = '{{ $select_limit }}'
            @endisset
            $('.timetable-wrapper .timetable-slots .available-slot').on('click', function() {
                $('.available-slot').tooltip('dispose')
                if ($(this).hasClass('selected')) {
                    $(this).attr('data-focus', 'focus');
                    setTimeout(() => {
                        $(this).removeAttr('data-focus');
                    }, 3000);
                    $(this).toggleClass('selected');
                    $(this).removeClass('alreadySelected');
                    $(this).next('input[name="slots[]"]').prop("checked", false);
                } else {
                    if ($('.available-slot.selected').length <= slotLimit - 1) {

                        $(this).toggleClass('selected');


                    }
                }
                updatePackageView()
                if ($('.discount-wrapper.success').length > 0) {
                    applyDiscount();
                }
            })

            //change subscription student slots
            function alreadySelectedSlots() {
                var selectedClasses = @json($studentClasses);
                updatePackageView()
            }

            function updatePackageView() {
                var html =
                    ' <div class="col-4 col-sm-12 col-lg-5 px-0 mb-2">Selected Slots</div><div class="col-8 col-sm-12 col-lg-7"></div>'
                var selected = $('.available-slot.selected');
                selected.each(function(i, obj) {
                    $(this).next('input[name="slots[]"]').attr("checked", true);

                    html +=
                        ' <div class="col-12 col-sm-6 selected-slots text-center"><i class="fa fa-times me-2 text-muted" style="margin-left:12px" data-slotid="' +
                        $(this).data('slotid') + '""></i><span>' +
                        '       ' + $(this).data('slottime') + '\n' +
                        '     </span></div>\n'
                });
                $('.selected-slots-view').html(html);
                $('.total-selected-slots').html(selected.length)
                $('.calculated-slots-price').html(selected.length *
                    '{{ settings('slot-price') ?? \App\Classes\AlQuranConfig::SlotPrice }}')

                let totalPrice = selected.length *
                    '{{ settings('slot-price') ?? \App\Classes\AlQuranConfig::SlotPrice }}' + changeCharges;

                $('.total-slots-price').html(totalPrice)
                $('#total-slots-price-2').val(totalPrice)
                $('.calculated-slots-price').html(totalPrice)
                /*Disabling/Enabling slots on max select*/
                if (selected.length > slotLimit - 1) {
                    $('.available-slot').not('.selected').addClass('disabled-slots')
                    $('.available-slot.disabled-slots').attr('data-bs-original-title', 'You can select maximum ' + slotLimit +
                        ' slots.').tooltip()
                } else if ($('.available-slot.selected').length < slotLimit) {
                    $('.available-slot').not('.selected').removeClass('disabled-slots')
                }
                if (selected.length > 0) {
                    $('#next').prop('disabled', false)
                    $('.discount#discount').show();
                    $(".discount-div").css('display', 'flex');
                } else {
                    $('#next').prop('disabled', true);
                    $('.discount#discount').hide();
                    $(".discount-div").css('display', 'none');
                    $(".total-slots-price").html(0);
                    $('#total-slots-price-2').val(0);
                }
            }

            //pay button for credit/debit or paypal
            $('#confirm-schedule-btn').on('click', function() {

                $('#next').prop('disabled', true)
                // if($('#card-btn').is(':checked'))
                // {

                var selectedSlots = new Array();
                let slots = $(".slotInput:checked").length;
                if (slots > 0) {
                    jQuery(".slotInput:checked").each(function() {
                        selectedSlots.push($(this).val());
                    });
                }
                $('#total-slots-price-2').val();
                $('#slots').val(selectedSlots);
                card = $('#card-tho').val();
                if (card == "true") {
                    $('#formPayment').submit();
                    $('#loader-modal').modal('show');
                } else {
                    $('#payment-form').submit();
                }

                // } else if($('#paypal-btn').is(':checked')) {

                //     let formData = $(this).serializeArray();
                //     let total_price = $('.total-slots-price').html();
                //     $('#total-slots-price').val(total_price);
                //     $('#slots-selection-form').submit();
                // }


            });

            $(document.body).on('click', '.selected-slots .fa-times', function() {
                $('.available-slot[data-slotid="' + $(this).data('slotid') + '"]').click();
            })

            // Discount Code

            function applyDiscount() {
                $('.discount-wrapper #discount').prop('disabled', true);
                $(".discount-wrapper #loader").show();
                $(".discount-wrapper .btn-apply span").hide();
                // $(".discount-wrapper ").hide();
                let voucher = $('.discount-wrapper #discount').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('customer.checkDiscount', [app()->getLocale()]) }}',
                    data: {
                        discount: voucher
                    },
                    success: function(data) {
                        if (data.success == true) {
                            $(".discount-wrapper").addClass('success');
                            $(".discount-wrapper").removeClass('failed');
                            $(".discount-wrapper .btn-outline-danger").addClass('btn-outline-primary')
                                .removeClass('btn-outline-danger');
                            let total_price = $('#total-slots-price-2').val();
                            let discount = data.data.value;
                            let discount_price = (total_price * discount / 100);
                            let deductAmount = total_price - discount_price;

                            $('#total-slots-price-2').val(deductAmount);
                            $('.total-slots-price').html(deductAmount);
                            $('.total-slots-prices').html(deductAmount);
                               $('.calculated-slots-price').html(deductAmount);
                            $('.discount-value').html(discount_price);
                            $('.coupon').prop('disabled', true);
                        } else {
                            $(".discount-wrapper").addClass('failed');
                            $(".discount-wrapper").removeClass('success');
                            $(".discount-wrapper .btn-outline-primary").addClass('btn-outline-danger')
                                .removeClass('btn-outline-primary');
                            $('.discount-wrapper #discount').prop('disabled', false);
                            COUPON_ALREADY_CLICKED = false;
                        }
                        $(".discount-wrapper .btn-apply span").show();
                        $(".discount-wrapper #loader").hide();

                    },
                    error: function() {
                        // $(".discount-wrapper").addClass('failed');
                        $('.discount-wrapper #discount').prop('disabled', false);
                        $(".discount-wrapper #loader").hide();
                        $(".discount-wrapper .btn-apply span").show();
                    }
                });
            }

            $('.coupon').on('click', function() {
                if (!COUPON_ALREADY_CLICKED) {
                    COUPON_ALREADY_CLICKED = true;
                    applyDiscount();
                }
            });
        </script>
    @endpush
@endisset
