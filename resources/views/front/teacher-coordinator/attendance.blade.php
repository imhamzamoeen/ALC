<div class="container-xl attendance-container">
    <div id='calendar'></div>
</div>
@push('after-style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css">
    <style>
        .fc-scrollgrid .fc-scrollgrid-section-header th {
            background: #f2f4f6;
            font-weight: 400;
            background-color: #f2f4f6;
            height: 50px;
            vertical-align: middle;
        }

        .fc-scrollgrid a {
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

        .fc-theme-standard td,
        .fc-scrollgrid th,
        .fc-theme-standard .fc-scrollgrid {
            border: 1px solid #f2f4f6 !important;
        }

        .fc-header-toolbar {
            -webkit-box-pack: space-between !important;
            -ms-flex-pack: space-between !important;
            justify-content: space-between !important;
        }

        .fc-header-toolbar .fc-prev-button,
        .fc-header-toolbar .fc-next-button {
            background: white !important;
            border: 1px solid #CCCACA !important;
            padding-top: 1px !important;
            padding-bottom: 1px !important;
            padding-left: 8px !important;
            padding-right: 8px !important;
            margin-left: 4px !important;

        }

        .fc-header-toolbar .fc-prev-button>span.fc-icon,
        .fc-header-toolbar .fc-next-button>span.fc-icon {
            font-size: 0.8em;
            color: #CCCACA !important;
        }

        .fc-header-toolbar .fc-button {
            font-size: var(--px-14);
            padding-top: 2px;
            padding-bottom: 2px;
        }

        .fc-header-toolbar .fc-toolbar-chunk:first-child {
            margin-right: 15px;
        }

        .fc-header-toolbar .fc-toolbar-chunk:first-child>h2 {
            font-size: var(--px-14);
            color: #707070;
            font-weight: 400;
        }

        .fc-daygrid-day-events {
            width: 90%;
            margin: auto;
        }

        .fc-h-event {
            background-color: white;
            box-shadow: 1px 1px 1px 1px rgb(241, 237, 237);
            -webkit-box-shadow: 1px 1px 1px 1px rgb(241, 237, 237);
            border: none !important;
            margin: auto !important;
        }

        .fc-daygrid-event-harness:first-child .fc-h-event {
            margin-top: 20px !important;
        }

        .fc-event-title-container::before {
            content: '';
            height: 10px;
            width: 10px;
            position: absolute;
            border-radius: 50%;
            top: 6px;
            background-color: #559739;
        }

        .fc-daygrid-event {
            border-radius: 0 !important;
        }

        .fc-event-title-container {
            padding-left: 5px !important;
            color: #000;
        }

        .fc-event-title {
            padding-left: 15px !important;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .fc-event-title-container.fc-event-present .fc-event-title {
            color: #559739;
        }

        .fc-event-title-container.fc-event-absent .fc-event-title {
            color: #FF3B3B;
        }

        .fc-event-title-container.fc-event-dayOff .fc-event-title {
            color: #3AB4FF;
        }

        .fc-event-title-container.fc-event-dayOff::before {
            background-color: #3AB4FF;
        }

        .fc-event-title-container.fc-event-present::before {
            background-color: #559739;
        }

        .fc-event-title-container.fc-event-absent::before {
            background-color: #FF3B3B;
        }

        .fc .fc-button-primary:not(:disabled).fc-button-active,
        .fc .fc-button-primary:not(:disabled):active {
            background-color: var(--primary-color);

        }

        .fc .fc-button-primary:not(:disabled).fc-button-active,
        .fc .fc-button-primary:not(:disabled):active {
            background-color: var(--primary-color);
            border-color: var(--primary-color)
        }

        .fc .fc-button-primary:not(:disabled).fc-button-active:hover,
        .fc .fc-button-primary:not(:disabled):active:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color)
        }

        .fc .fc-button-primary {
            background-color: white;
            color: var(--gray);
            border-color: var(--gray)
        }

        .fc .fc-button-primary:hover {
            background-color: white;
            color: var(--gray);
            border-color: var(--gray)
        }

        .fc .fc-button-primary:focus {
            box-shadow: none !important;
        }

        .attendance-wrapper {
            border: 1px solid #f2f4f6;
        }

        @media screen and (max-width: 768px) {
            .attendance-wrapper {
                border: none;
            }
        }

    </style>
    <style>
        @media screen and (max-width:576px) {

            .fc-daygrid,
            .fc-timegrid,
            .fc-timeGridDay-view {
                overflow-x: scroll;
            }

            .fc-scrollgrid {
                min-width: 800px;
            }

            .attendance-container {
                padding-top: 1.5rem !important;
            }

            #calendar {
                margin: 0 auto !important;
            }

            .fc .fc-toolbar {
                justify-content: space-between;
                align-items: start;
                flex-direction: column;
                height: 125px;
            }
        }

        #calendar {
            max-width: 100%;
            height: 740px;
            margin: 40px auto;
        }

    </style>
@endpush
@push('after-script')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                timeZone: 'UTC',
                initialView: 'dayGridMonth',
                editable: false,
                selectable: true,
                contentHeight: 700,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: [{
                        title: "11:00 PM Tajweed",
                        start: "2022-06-01",
                        end: "2022-06-01"
                    }, {
                        title: "11:00 PM Tajweed",
                        start: "2022-06-04",
                        end: "2022-06-04"
                    }, {
                        title: "11:00 PM Tajweed",
                        start: "2022-06-01",
                        end: "2022-06-01"
                    }, {
                        title: "11:00 PM Tajweed",
                        start: "2022-06-04",
                        end: "2022-06-04"
                    }, {
                        title: "11:00 PM Tajweed",
                        start: "2022-06-01",
                        end: "2022-06-01"
                    }, {
                        title: "11:00 PM Tajweed",
                        start: "2022-06-04",
                        end: "2022-06-04"
                    }, {
                        title: "11:00 PM Tajweed",
                        start: "2022-6-06",
                        end: "2022-06-06"
                    }, {
                        title: "11:00 PM Tajweed",
                        start: "2022-06-12",
                        end: "2022-06-12"
                    },
                    {
                        title: "11:00 PM Tajweed",
                        start: "2022-06-15",
                        end: "2022-06-15"
                    }, {
                        title: "11:00 PM Tajweed",
                        start: "2022-06-18",
                        end: "2022-06-18"
                    }, {
                        title: "11:00 PM Tajweed",
                        start: "2022-06-20",
                        end: "2022-06-20"
                    }, {
                        title: "11:00 PM Tajweed",
                        start: "2022-06-25",
                        end: "2022-06-25"
                    }
                ]
            });

            calendar.render();

            // function addClasses() {
            //     $("div.fc-event-title-container:contains(Present)").addClass('fc-event-present');
            //     $("div.fc-event-title-container:contains(Absent)").addClass('fc-event-absent');
            //     $("div.fc-event-title-container:contains(No Class)").addClass('fc-event-dayOff');
            // }
            // addClasses();
            // $('.fc-button').on('click', addClasses);
        });
    </script>
@endpush
