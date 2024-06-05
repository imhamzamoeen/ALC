@extends('front.layouts.master')

@section('content')
    <div class="attendance-wrapper p-4 mt-5">
        <div class="text-sb px-24 mb-3 attendance-heading">
            Haroon Mukhtar {{ __('Attendance') }}
        </div>
        <div class="d-flex justify-content-between count-wrapper mb-3">
            <div class="d-flex align-items-center">
                <div class="count present">
                    24
                </div>
                <div class="ms-2">
                    {{ __('Present') }}
                </div>
            </div>
            <div class="d-flex align-items-center">
                <div class="count absent">
                    24
                </div>
                <div class="ms-2">
                    {{ __('Absent') }}
                </div>
            </div>
            <div class="d-flex align-items-center">
                <div class="count rescheduled">
                    24
                </div>
                <div class="ms-2">
                    {{ __('Rescheduled') }}
                </div>
            </div>
        </div>
        <div>

        </div>
        <div id='calendar'></div>
    </div>

@stop
@push('after-style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
    <style>
        .fc-scrollgrid .fc-scrollgrid-section-header th {
            background: #f2f4f6;
            font-weight: 400;
            background-color: #f2f4f6;
            height: 50px;
            vertical-align: middle;
        }

        .fc-daygrid-body.fc-daygrid-body-unbalanced,
        .fc-scrollgrid-sync-table,
        .fc-col-header {
            width: 100% !important;
        }

        @media screen and (max-width:575px) {
            .attendance-wrapper {
                margin-top: 75px !important;
            }

            #calendar {
                border-top: 1px solid lightgray;
                padding-top: 10px;
            }
        }

        /* .fc-scrollgrid-sync-table {
                                                                                                                                                                                                                                                                                                                                                                                                        height: 643PX;
                                                                                                                                                                                                                                                                                                                                                                                                    } */

        .fc-scrollgrid a,
        .fc-list a {
            text-decoration: none;
            color: black;
            font-size: var(--px-14);
        }

        .fc-scrollgrid .fc-daygrid-body a {
            font-weight: 500;
        }

        .fc-scrollgrid .fc-daygrid-day {
            max-height: 100px !important;
        }

        .fc .fc-theme-standard td,
        .fc-scrollgrid th,
        .fc-theme-standard .fc-scrollgrid {
            border: 1px solid #f2f4f6 !important;
        }

        /* styling page title and count section  */
        .count-wrapper {
            max-width: 400px;
        }

        .count {
            width: 35px;
            height: 35px;
            text-align: center;
            line-height: 2.3;
            border-radius: 50%;
            color: white;
            font-weight: 500;
        }

        .count.present {
            background-color: #50BC54;
        }

        .count.absent {
            background-color: #FF3B3B;
        }

        .count.rescheduled {
            background-color: #6EC5FF;
        }

        @media screen and (max-width:575px) {
            .attendance-heading {
                font-size: var(--px-18);
            }

            .count-wrapper {
                flex-wrap: wrap;
            }

            .count-wrapper>div:nth-child(3) {
                width: 100%;
                margin-top: 15px;
            }
        }

        /* styling the header of calender  */
        .fc-header-toolbar .fc-button-group {
            width: 180px;
            justify-content: space-between;
        }

        .fc-header-toolbar .fc-button {
            width: 50px;
            background-color: transparent !important;
            color: var(--primary-color);
            flex: unset !important;
            border: 1px solid var(--primary-color);
            /* padding: .2em .35em !important; */
            box-shadow: 0px 0px 16px rgba(0, 0, 0, 0.06);
            border-radius: 6px !important;
            border: 1px solid white;
        }

        @media screen and (max-width:575px) {
            .fc-header-toolbar .fc-button-group {
                width: 120px;
            }

            .fc-header-toolbar .fc-button {
                width: 25px;
                padding: 0 !important;
            }

            .fc-header-toolbar .fc-toolbar-title {
                font-size: var(--px-18);
            }
        }

        .fc-header-toolbar .fc-button:focus,
        .fc-header-toolbar .fc-button:hover,
        .fc-header-toolbar .fc-button:active {
            box-shadow: 0px 0px 16px rgba(0, 0, 0, 0.06) !important;
            border: 1px solid transparent !important;
            color: var(--primary-color) !important;
        }

        .fc-header-toolbar .fc-today-button {
            font-family: Poppins, sans-serif;
            color: var(--primary-color) !important;
            text-transform: capitalize;
            width: 70px !important;
            border: none !important;
            font-size: 1rem;
            font-weight: 600;
            box-shadow: none !important;
        }

        .fc-header-toolbar .fc-button:disabled {
            opacity: 0.5 !important;
        }

        /* styling table cell  */
        .fc-daygrid-day-frame {
            min-height: 100px !important;
            margin-bottom: 15px;
        }

        .fc-day.fc-day-sun .fc-non-business {
            background: none;
        }

        /* styling event box wrapper  */
        .fc-daygrid-day-events {
            background-color: #FAFAFA;
            border-radius: 6px;
            max-width: 90%;
            min-height: unset !important;
            margin: 0 auto;
        }

        /* remove highlight on select for desktop */
        .fc-highlight {
            background: none !important;
        }

        /* styling event box  for desktop*/
        .fc-daygrid-event.present,
        .fc-daygrid-event.absent,
        .fc-daygrid-event.rescheduled {
            border: 1px solid transparent !important;
            background: none;
            margin: 0 !important;
        }

        .fc .fc-daygrid-event-harness:first-child {
            padding: 10px 0 0;
        }

        .fc-daygrid-event-harness .fc-daygrid-dot-event {
            display: block;
        }

        .custom-event {
            font-size: 14px;
            height: 50px;
            position: relative;
            margin-bottom: 10px;
        }

        .custom-event hr {
            border-top: 1px solid rgb(109, 108, 108);
            margin: 5px auto;
            width: 80%;
        }

        .custom-event::before {
            content: "";
            height: 50px;
            width: 4px;
            border-radius: 3px;
            position: absolute;
        }

        .custom-event .time {
            color: #ABB0BC;
            margin-left: 15px;
        }

        .custom-event .status {
            width: 80%;
            height: 20px;
            line-height: 1.5;
            border-radius: 2px;
            font-size: 14px;
            margin: 0 auto 5px;
        }

        .custom-event.present .status {
            background-color: #99FF6E29;
            color: #50BC54;
            text-align: center;
        }

        .custom-event.absent .status {
            background-color: #FF3B3B29;
            color: #FF3B3B;
            text-align: center;
        }

        .custom-event.rescheduled .status {
            background-color: #6EC5FF29;
            color: #6EC5FF;
            text-align: center;
        }

        .custom-event.present::before {
            background-color: #50BC54;
        }

        .custom-event.absent::before {
            background-color: #FF3B3B;
        }

        .custom-event.rescheduled::before {
            background-color: #6EC5FF;
        }

        /* styling event for mobile  */
        .fc .fc-list-sticky .fc-list-day>* {
            position: unset !important;
        }

        .fc .fc-list-event-graphic,
        .fc .fc-list-event-time {
            display: none;
        }

        .event-mobile {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .event-mobile .time {
            color: black;
            margin-left: 15px;
            font-weight: 600;
        }

        .event-mobile .status {
            width: 130px;
            margin: 0 0 0 10px;
            height: 25px;
            line-height: 1.8;
            border-radius: 4px;
        }

        .event-mobile {
            height: 40px;
        }

        .custom-event::before {
            height: 40px;
        }

        /* styling more button */
        .fc-daygrid-day-bottom {
            background-color: white;
            padding: 0 !important;

        }

        .fc-daygrid-more-link.fc-more-link {
            text-decoration: none;
            color: black;
            display: block;
            margin-top: 10px;
        }

        /* styling poppup on more button  */
        .fc-popover.fc-more-popover.fc-day {
            width: 250px;
        }

        .fc-popover-body {
            background-color: #FAFAFA;
            border-radius: 6px;
            max-width: 95%;
            margin: 10px auto;
            padding: 10px 0 !important;
        }
    </style>
@endpush
@push('after-script')
    <script>
        const data = [{
            title: "Present",
            start: "2022-06-07",
            className: "present",

        }, {
            title: "Absent",
            start: "2022-06-07",
            className: "absent",

        }, {
            title: "Absent",
            start: "2022-06-07 03:00",
            className: "absent",

        }, {
            title: "Rescheduled",
            start: "2022-06-07 04:30",
            className: "rescheduled",


        }, {
            title: "Absent",
            start: "2022-06-07",
            className: "absent",


        }, {
            title: "Rescheduled",
            start: "2022-06-07 07:30",
            className: "rescheduled",


        }, {
            title: "Present",
            start: "2022-06-26",
            className: "present",

        }, {
            title: "Absent",
            start: "2022-06-27",
            className: "absent",

        }, {
            title: "Absent",
            start: "2022-06-28 03:00",
            className: "absent",

        }, {
            title: "Present",
            start: "2022-06-15",
            className: "present",

        }, {
            title: "Present",
            start: "2022-06-15",
            className: "present",

        }, {
            title: "Rescheduled",
            start: "2022-06-29 04:30",
            className: "rescheduled",


        }, {
            title: "Absent",
            start: "2022-06-30",
            className: "absent",


        }, {
            title: "Rescheduled",
            start: "2022-07-01 04:30",
            className: "rescheduled",


        }];

        function LoadCalender() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                timeZone: 'UTC',
                editable: false,
                dayMaxEvents: 2, // allow "more" link when too many events
                selectable: false,
                contentHeight: 850,
                headerToolbar: {
                    center: '',
                    left: 'title',
                    right: 'prev,today,next'
                },
                events: data,
                eventContent: function(arg) {
                    const data = arg.event;
                    let event_class = data.classNames[0];
                    let title = data.title;
                    // data.classNames.length ? event_class = data.classNames[0] : event_class = '';
                    let time = arg.event.start.toLocaleTimeString();

                    // console.log(data);
                    let custom_event = document.createElement('div');
                    if (isMobile())
                        custom_event.innerHTML =
                        `<div class="custom-event event-mobile ${event_class}"><span class="time"><i class="fa fa-clock-o me-1"></i>${time}</span><div class="status">${title}</div></div>`;
                    else
                        custom_event.innerHTML =
                        `<div class="custom-event ${event_class}"><div class="status">${title}</div><span class="time"><i class="fa fa-clock-o me-1"></i>${time}</span><hr></div>`;
                    let arrayOfDomNodes = [custom_event]
                    return {
                        domNodes: arrayOfDomNodes
                    }
                }

            });
            calendar.render();
            if (isMobile()) {
                calendar.changeView('listWeek');
                calendar.setOption('contentHeight', 650);
            } else {
                calendar.changeView('dayGridMonth');
            }
        }

        $(function() {
            LoadCalender();

            console.log('loaded');
        })

        function isMobile() {
            let w = window.innerWidth;
            if (w < 756) return true
            else return false
        }
    </script>
@endpush
