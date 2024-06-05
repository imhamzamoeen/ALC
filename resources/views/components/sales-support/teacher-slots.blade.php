<div class="">

    <div class="text-start">
        <h5 class="px-18 text-sb text-start mt-4">{{ __('Select a Slot for') . ' ' . $date }}</h5>
        <p class="px-14 text-med mb-2 pt-3">
            {{ __('From below calendar you select available date and time slot for Trial class') }}
        </p>
        <div class="">
            {{-- <div class="row">
                <div class="col-sm-12 col-12"> --}}
            @isset($Model)
                <div class="timetable-wrapper w-100">
                    {{-- <div class="row text-center mt-0 mx-0 pe-1 w-100 timetable-days w-100">
                        </div> --}}
                    <div class="text-center m-0 timetable-slots w-100">
                        <!-- simple form -->

                        @if (isset($StudentTime) && $StudentTime->isNotEmpty())
                            {{-- <small>{{ $StudentTime}}</small> --}}

                            <!-- ke is day number and $day is data -->
                            <div class="py-1 px-2">
                                {{-- <h5 class="text-med px-14 mb-4">Mon</h5> --}}
                                <div class="ms-2 ms-sm-0 slots-col" style="height: 100%">

                                    @if ($StudentTime->has(\Carbon\Carbon::parse($date)->format('Y-m-d')))
                                        @forelse ($StudentTime as $key=>$val)
                                            <small>{{ 'The Date in student zone would be ' . $key }}</small>


                                            @foreach ($val as $k => $slot)
                                                @if ($slot['status'] == 'booked')
                                                    <!--- mean this slot is booked -->
                                                    <div class="px-14 text-med p-2 mx-auto d-flex align-items-center justify-content-center my-2 permanent-disabled"
                                                        data-toggle="tooltip" title="This slot is already taken">
                                                        {{ \Carbon\Carbon::parse($slot['class_time'])->format('h:i A') }}
                                                    </div>
                                                    <input type="checkbox" class="slotInput d-none" name="slot"
                                                        form="slots-selection-form" value="{{ $slot['slot'] }}">
                                                @else
                                                    {{-- <div
                                        class="px-14 text-med p-2 mx-auto d-flex align-items-center justify-content-center my-2 time-slot"
                                        data-slottime="{{ \Carbon\Carbon::parse($date)->format('D') }}[{{ $slot['slot'] ?? '' }} - ]"
                                        data-slotid="{{ $slot['slot'] }}" data-toggle="tooltip"
                                        title="Click to select or unselect a time slot">
                                        {{ \Carbon\Carbon::parse($slot['class_time'])->format('h:i A') }}
                                    </div>
                                   <label
                                       for="{{ $slot['slot'] }}">
                                            {{ \Carbon\Carbon::parse($slot['class_time'])->format('h:i A') }}
                                            <input type="radio" name="slot" value="{{ $slot['slot'] }}" wire:model="assign.slot"/>
                                        </label> --}}



                                                    <div class="d-flex align-items-center my-3">
                                                        <label class="switch" for="{{ $slot['slot'] }}">

                                                            <input type="radio" name="slot" class="d-none"
                                                                value="{{ $slot['slot'] }}" wire:model="assign.slot" />
                                                            <span
                                                                class="slider
                                                                round ms-1"></span>
                                                        </label>
                                                        <span
                                                            class="ms-1 px-14 text-sb ms-3">{{ \Carbon\Carbon::parse($slot['class_time'])->format('h:i A') }}</span>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @empty
                                            <div style="height: 100%;"
                                                class=" d-flex align-items-center flex-column justify-content-around empty">
                                                <span>No Slots</span>

                                            </div>
                                        @endforelse
                                    @else
                                        <div style="height: 100%;"
                                            class=" d-flex align-items-center flex-column justify-content-around empty">
                                            <span>No Slots</span>
                                            {{-- <span>No Slots</span>
                                        <span>No Slots</span> --}}
                                        </div>
                                    @endif

                                </div>
                            </div>
                        @else
                            <small>Sorry We could not get the Schedule for this date</small>
                        @endif


                    </div>
                </div>
            @endisset
            {{-- </div>

            </div> --}}

        </div>
    </div>
</div>
{{-- @push('after-style') --}}
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

    .timetable-wrapper .timetable-slots .col div>div:first-child {
        margin-top: 0 !important;
    }

    .timetable-wrapper .timetable-slots .col div>div:last-child {
        margin-bottom: 0 !important;
    }

    .timetable-wrapper .timetable-slots .col div>div {
        height: 40px;
        cursor: default;
    }

    .timetable-wrapper .timetable-slots .col div>div:not(.empty):hover,
    .timetable-wrapper .timetable-slots .col div>div.selected:not(.empty) {
        background-color: var(--primary-color);
        border: 1px solid var(--primary-color);
        color: white;
        width: 90%;
    }

    .timetable-wrapper .timetable-slots .col div>div:not(.empty) {
        color: #707070;
        background-color: #F3F3F3;
        border: 1px solid #D9D9D9;
        border-radius: 5px;
        width: 90%;

    }

    .switch {
        position: relative;
        display: inline-block;
        width: 34px;
        height: 14px;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        -o-transition: .4s;
        transition: .4s;
    }

    .slider.round {
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: -5px;
        top: -3px;
        background-color: white;
        -webkit-transition: .4s;
        -o-transition: .4s;
        transition: .4s;
        -webkit-box-shadow: 1px 1px 15px 2px lightgrey;
        box-shadow: 1px 1px 15px 2px lightgrey;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    .switch input:checked+.slider::before {
        background-color: var(--primary-color);
    }

    .switch input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    @media screen and (max-width:575px) {

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

    .time-slot.disabled-slots:hover,
    .permanent-disabled:hover {
        border: 1px solid #D9D9D9 !important;
        color: #707070 !important;
    }
</style>
{{-- @endpush --}}

{{-- @push('after-script') --}}
<script>
    var slotLimit = 1; //how much classses can be selected
    var datechoosen; // date for reschedule class 
    $(document).ready(function() {
        $('.time-slot').not('.disabled-slots').tooltip();
        $('.permanent-disabled').tooltip();
    })


    // })
    // var slotLimit = '{{ settings('classes-limit', true, \App\Classes\AlQuranConfig::MaxProfiles) }}'     
    // $('body').on('change', '.new-send', function(e) {

    //     // alert("ok"+ $(this).val());
    //     @this.slots= $(this).val();
    // });


    $('.timetable-wrapper .timetable-slots .time-slot').on('click', function() {
        $('.time-slot').tooltip('dispose')
        if ($(this).hasClass('selected')) {
            $(this).toggleClass('selected');
            $(this).next('input[name="slot"]').prop("checked", false);
        } else {
            if ($('.time-slot.selected').length <= slotLimit - 1) {
                $(this).toggleClass('selected');
                $(this).next('input[name="slot"]').prop("checked", true);
                datechoosen = $(this).next('input[name="slot"]').data(
                    'date'); // we are getting current day later we will add a week to it 
            }
        }
        updatePackageView()
    })

    function updatePackageView() {
        var html =
            ' <div class="col-4 col-sm-12 col-lg-5 px-0 mb-2">Selected Slots</div><div class="col-8 col-sm-12 col-lg-7"></div>'
        var selected = $('.time-slot.selected');
        selected.each(function(i, obj) {
            html +=
                ' <div class="col-12 col-sm-6 selected-slots text-center"><i class="fa fa-times me-2 text-muted" style="margin-left:12px" data-slotid="' +
                $(this).data('slotid') + '""></i><span>' +
                '       ' + $(this).data('slottime') + '\n' +
                '     </span></div>\n'
        });
        $('.selected-slots-view').html(html)
        $('.total-selected-slots').html(selected.length)
        $('.calculated-slots-price').html(selected.length *
            '{{ settings('slot-price') ?? \App\Classes\AlQuranConfig::SlotPrice }}')
        $('.total-slots-price').html(selected.length *
            '{{ settings('slot-price') ?? \App\Classes\AlQuranConfig::SlotPrice }}')

        /*Disabling/Enabling slots on max select*/
        if (selected.length > slotLimit - 1) {
            $('.time-slot').not('.selected').addClass('disabled-slots')
            $('.time-slot.disabled-slots').attr('data-bs-original-title', 'You can select maximum ' + slotLimit +
                ' slots.').tooltip()
        } else if ($('.time-slot.selected').length < slotLimit) {
            $('.time-slot').not('.selected').removeClass('disabled-slots')
        }

        if (selected.length > 0) {
            $('#confirm-schedule-btn').prop('disabled', false)
        } else {
            $('#confirm-schedule-btn').prop('disabled', true)
        }
    }


    $(document.body).on('click', '.selected-slots .fa-times', function() {
        $('.time-slot[data-slotid="' + $(this).data('slotid') + '"]').click();
    })
</script>
{{-- @endpush --}}
