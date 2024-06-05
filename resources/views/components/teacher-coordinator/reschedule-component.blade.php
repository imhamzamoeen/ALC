<div>
    <h4 class="px-24 text-sb">{{ __('MakeUp Class') }}</h4>
    <p class="px-14 text-med mb-0 mb-sm-4 pt-3">
        {{ __('From below calendar you select available date and time slot for reschedule your class') }}
    </p>
    <p class="px-14 text-med d-sm-none d-block text-danger mt-1 pb-3">{{ __('Scroll left to view more days') }}</p>
    <div class="container">
        <div class="row">

            <div class="col-sm-12 col-12">

                @isset($Model)
                    <!-- simple form -->
                    <form class="" role="form" method="post"
                        action="{{ route('teacher-coordinator.MakeRescheduleRequest', [app()->getLocale()]) }}"
                        id="slots-selection-form">@csrf </form>
                    <div class="timetable-wrapper w-100">
                        <div class="row text-center mt-0 mx-0 pe-1 w-100 timetable-days w-100">
                            @foreach (get_current_week() as $key => $day)
                                <div class="col p-0">

                                    <h5 class="text-med px-14">{{ $day->format('D') }}</h5>
                                    <h6 class="text-med px-12">{{ $day->addWeek()->format('d M, Y') }}</h6>
                                    <!-- class can only be rescheduled to next week so we are displaying Days of a week and next dates of that week -->
                                </div>
                            @endforeach
                        </div>
                        <div class="row text-center m-0 timetable-slots w-100">

                            @if (isset($CoordinatorSlots) && $CoordinatorSlots->isNotEmpty())
                                @foreach (get_current_week() as $key => $day)
                                    <!-- ke is day number and $day is data -->
                                    <div class="col p-0">
                                        {{-- <h5 class="text-med px-14 mb-4">Mon</h5> --}}
                                        <div class="ms-2 ms-sm-0 slots-col" style="height: 100%">
                                            @if ($CoordinatorSlots->has(\Carbon\Carbon::parse($day)->format('Y-m-d')))
                                                @foreach ($CoordinatorSlots[\Carbon\Carbon::parse($day)->format('Y-m-d')] as $k => $slot)
                                                    @if ($slot['status'] == 'booked')
                                                        <!--- mean this slot is booked -->


                                                        <div class="px-14 text-med p-2 mx-auto d-flex align-items-center justify-content-center my-2 permanent-disabled"
                                                            data-toggle="tooltip" title="This slot is already taken">
                                                            {{ \Carbon\Carbon::parse($slot['class_time'])->format('h:i A') }}
                                                        </div>
                                                        <input type="checkbox" class="slotInput d-none" name="slot"
                                                            form="slots-selection-form" value="{{ $slot['slot'] }}">
                                                    @else
                                                        <div class="px-14 text-med p-2 mx-auto d-flex align-items-center justify-content-center my-2 time-slot"
                                                            data-slottime="{{ $day->format('D') }}[{{ $slot['slot'] ?? '' }} - ]"
                                                            data-slotid="{{ $slot['slot'] }}" data-toggle="tooltip"
                                                            data-student_time="{{ $slot['student_time'] }}"
                                                            title="Click to select or unselect a time slot">
                                                            {{ \Carbon\Carbon::parse($slot['class_time'])->format('h:i A') }}
                                                        </div>
                                                        <input type="checkbox" class="slotInput d-none" name="slot"
                                                            data-date={{ $day }} form="slots-selection-form"
                                                            value="{{ $slot['slot'] }}">
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
                            @endif


                        </div>
                    </div>
                @endisset


            </div>

        </div>
        <div class="row">
            <div class="col-sm-9 col-12 mt-3">
                <div class="alert alert-info teacher_to_student_time" style="display: none" role="alert">
                    Selected Time For Student is <span class="time">Saturday 2:00 PM</span>
                </div>
                <div class="alert alert-danger teacher_to_student_time" style="display: none" role="alert">
                    Selected Time For Student is <span class="time">Sunday 2:00 PM</span>
                </div>
            </div>
            <div class="col-sm-3 col-12 mt-3 text-sm-end text-center">
                <button type="submit" form="slots-selection-form"
                    class="btn btn-primary px-5 py-3 mt-3 mt-sm-0 reschedule-btn">
                    Submit
                </button>
            </div>
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

    .teacher_to_student_time.alert-info::before {
        content: '';
        position: absolute;
        width: 10px;
        height: 10px;
        background-color: #055160;
        border-radius: 50%;
        top: 40%;
        left: 15px;
    }

    .teacher_to_student_time.alert-danger::before {
        content: '';
        position: absolute;
        width: 10px;
        height: 10px;
        background-color: #842029;
        border-radius: 50%;
        top: 40%;
        left: 15px;
    }

    .teacher_to_student_time.alert-info {
        /* color: var(--primary-color) !important;
        background-color: var(--secondary-color) !important;
        border-color: var(--secondary-color) !important; */
        position: relative;
        padding-left: 30px !important;
    }

    .teacher_to_student_time.alert-danger {
        position: relative;
        padding-left: 30px !important;
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
    // var formcheck=false;
    $(document).ready(function() {
        $('.time-slot').not('.disabled-slots').tooltip()
        $('.permanent-disabled').tooltip()
    })
    // var slotLimit = '{{ settings('classes-limit', true, \App\Classes\AlQuranConfig::MaxProfiles) }}'     



    $('.timetable-wrapper .timetable-slots .time-slot').on('click', function() {


        $('.time-slot').tooltip('dispose')
        if ($(this).hasClass('selected')) {
            $(this).toggleClass('selected');
            $(this).next('input[name="slot"]').prop("checked", false);
            const time = 'Sunday 5:00 PM';
            console.log('if');
            TeacherTOStudentTime(time, 'hide');
        } else {
            if ($('.time-slot.selected').length <= slotLimit - 1) {
                var student_time = $(this).attr('data-student_time');
                $(this).toggleClass('selected');
                $(this).next('input[name="slot"]').prop("checked", true);
                datechoosen = $(this).next('input[name="slot"]').data(
                    'date'); // we are getting current day later we will add a week to it 
                console.log('else if');
                const time = student_time;
                TeacherTOStudentTime(time, 'info');
                // if(student_time.includes('Sunday')){         //we uncomment this code if sunday ko class nhe rkhni student k 
                //     formcheck=false;
                //     $('.reschedule-btn').addClass('permanent-disabled');
                // TeacherTOStudentTime(time, 'danger');  
                // }else{
                //     formcheck=true;
                //     $('.reschedule-btn').removeClass('permanent-disabled');
                // TeacherTOStudentTime(time, 'info');

                // }
            }
        }
        updatePackageView()
    })

    function TeacherTOStudentTime(time, status) {
        console.log('function TeacherTOStudentTime');
        if (status == 'hide') {
            console.log('if: ', status);
            $('.teacher_to_student_time').css('display', 'none');
        } else {
            console.log('else: ', status);
            $('.teacher_to_student_time.alert-' + status).css('display', 'block');
            $('.teacher_to_student_time.alert-' + status + ' .time').html(time);
        }
    }

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
            $('.time-slot:not(.selected)').addClass('disabled-slots')
            $('.time-slot.disabled-slots').attr('data-bs-original-title', 'You can select maximum ' + slotLimit +
                ' slots.');
            $('.time-slot').tooltip()

        } else if ($('.time-slot.selected').length < slotLimit) {
            $('.time-slot:not(.selected)').removeClass('disabled-slots')
            $('.time-slot:not(.permanent-disabled.selected)').attr('data-bs-original-title',
                'Click to select or unselect a time slot').tooltip();
        }

        if (selected.length > 0) {
            $('#confirm-schedule-btn').prop('disabled', false)
        } else {
            $('#confirm-schedule-btn').prop('disabled', true)
        }
    }

    $('#slots-selection-form').on('submit', function(e) {
        // if(formcheck==false){
        //     toaster('info','Cannot reschedule a class on Sunday');
        //     return ;
        // }

        e.preventDefault();
        var formdata = new FormData($(this)[0]);


        formdata.append('student_id', StudentChoosenForClassChange);
        formdata.append('teacher_id', TeacherChoosenForClassChange);
        formdata.append('weekly_class_id', WeeklyClassChoosenForClassChange);
        formdata.append('reschedule_date', datechoosen);



        Ajax_Call_Dynamic($(this).attr('action'), "post", formdata, "RequestRescheduleSentSuccess",
            'FailedToasterResponse', '.pinCode-modal .overlay-loader', 'False');
    })

    function RequestRescheduleSentSuccess(response) {
        console.log(response.response);
        toaster('success', response.message);
        $('#change_schedule_modal').modal('hide');
    }

    $(document.body).on('click', '.selected-slots .fa-times', function() {
        $('.time-slot[data-slotid="' + $(this).data('slotid') + '"]').click();
    })
</script>
{{-- @endpush --}}
