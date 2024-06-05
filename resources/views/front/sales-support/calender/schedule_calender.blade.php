@error('assign.date')
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
<div wire:ignore id="container" class="calendar-container"></div>
{{-- @push('after-style') --}}
<style>
    .calendar {
        position: relative;
        overflow: hidden;
        text-transform: capitalize;
        text-align: center;
        font: 12px inherit;
    }

    @media screen and (max-width:340px) {
        .calendar {
            overflow-x: scroll;

        }
    }

    .calendar a {
        text-decoration: none;
        color: inherit;
    }

    .calendar header .notification-calendar-btn {
        display: inline-block;
        position: absolute;
        width: 30px;
        height: 30px;
        text-align: center;
        line-height: 30px;
        color: #D9D9D9;
        border-radius: 50%;
        border: 2px solid #D9D9D9;
    }

    .calendar header .notification-calendar-btn:hover {
        background: #D9D9D9;
        color: white;
    }

    .calendar header .notification-calendar-btn:before {
        content: "";
        position: absolute;
        top: 9px;
        left: 8px;
        width: 8px;
        height: 8px;
        border-style: solid;
        border-width: 3px 3px 0 0;
        transform: rotate(45deg);
        transform-origin: center center;
    }

    .calendar header .btn-prev {
        top: 0;
        left: 0;
        transform: rotate(-180deg);
    }

    .calendar header .btn-next {
        top: 0;
        right: 0;
    }

    .calendar header .btn-next:before {
        transform: rotate(45deg);
    }

    .calendar header .month {
        padding: 0;
        margin: 0;
        font-size: var(--px-14);
    }

    .calendar header .month .year {
        font-size: var(--px-14);
        font-weight: 500;
    }

    .calendar table {
        width: 100%;
        margin: 20px 0;
        border-spacing: 0px;
    }

    .calendar thead {
        font-size: var(--px-14);
        font-weight: 600;
    }

    .calendar td {
        padding: 0.3em 0.1em;
    }

    .calendar .day {
        position: relative;
        display: inline-block;
        width: 2.8em;
        height: 2.8em;
        line-height: 2.5em;
        border-radius: 50%;
        border: 2px solid transparent;
        font-size: 12px;
        cursor: pointer;
    }

    .calendar .wrong-month {
        pointer-events: none;

    }

    .calendar .day:hover {
        border: 2px solid #6691cc;
    }

    .calendar .day.today {
        background: var(--primary-color);
        color: white;
    }

    .calendar .day.today.has-event {
        background: var(--primary-color);
    }


    .calendar .day.wrong-month {
        color: #D9D9D9;
    }

    .calendar .day.has-event {
        background-color: #D9D9D9;
    }

    .calendar .day.wrong-month:hover {
        border: 2px solid transparent;
    }

    .calendar .day.disabled:hover {
        border: 2px solid transparent;
    }

    .calendar .event-container {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        padding: 70px;
        background: #545a5c;
        box-sizing: border-box;
    }

    .calendar .event-container .event-wrapper {
        overflow-y: auto;
        max-height: 100%;
    }

    .calendar .event-container .close {
        position: absolute;
        width: 30px;
        height: 30px;
        top: 20px;
        right: 20px;
        cursor: pointer;
    }

    .calendar .event-container .close:before,
    .calendar .event-container .close:after {
        content: "";
        position: absolute;
        top: 0;
        left: 50%;
        width: 2px;
        height: 100%;
        background-color: #cbd1d2;
    }

    .calendar .event-container .close:before {
        transform: rotate(45deg);
    }

    .calendar .event-container .close:after {
        transform: rotate(-45deg);
    }

    .calendar .event-container .event {
        position: relative;
        width: 100%;
        padding: 1em;
        margin-bottom: 1em;
        background: #6691cc;
        border-radius: 4px;
        box-sizing: border-box;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06), 0 1px 2px rgba(0, 0, 0, 0.12);
        text-align: left;
        color: white;
    }

    .calendar .event-container .event-date {
        margin-bottom: 1em;
    }

    .calendar .event-container .event-hour {
        float: right;
    }

    .calendar .event-container .event-summary {
        font-weight: 600;
    }

    .calendar .filler {
        position: absolute;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: #545a5c;
        transform: translate(-50%, -50%);
    }
</style>
{{-- @endpush --}}
{{-- @push('after-script') --}}
<script>
    var $calendar;
    var user_type = "{{ auth()->user()->user_type }}";
    console.log(user_type);
    $(document).ready(function() {
        let container = $("#container").simpleCalendar({
            fixedStartDay: 0, // begin weeks by sunday
            disableEmptyDetails: true,
        });
        container.data("plugin_simpleCalendar");
    });


    (function($, window, document, undefined) {

        "use strict";

        // Create the defaults once
        var pluginName = "simpleCalendar",
            defaults = {
                months: ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september',
                    'october', 'november', 'december'
                ], //string of months starting from january
                days: ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday',
                    'saturday'
                ], //string of days starting from sunday
                displayYear: true, // display year in header
                fixedStartDay: true, // Week begin always by monday or by day set by number 0 = sunday, 7 = saturday, false = month always begin by first day of the month
                events: [], // List of event
                onInit: function(calendar) {}, // Callback after first initialization
                onMonthChange: function(month, year) {}, // Callback on month change
                onDateSelect: function(date, events) {}, // Callback on date selection
                onDayCreate: function($el, d, m,
                    y
                ) {} // Callback fired when an HTML day is created   - see $(this).data('today'), .data('todayEvents')
            };

        // The actual plugin constructor
        function Plugin(element, options) {
            this.element = element;
            this.settings = $.extend({}, defaults, options);
            this._defaults = defaults;
            this._name = pluginName;
            this.currentDate = new Date();
            this.init();
        }

        // Avoid Plugin.prototype conflicts
        $.extend(Plugin.prototype, {
            init: function() {
                var container = $(this.element);
                var todayDate = this.currentDate;

                var calendar = $('<div class="calendar"></div>');
                var header = $('<header>' +
                    '<h2 class="month"></h2>' +
                    '<a class="notification-calendar-btn btn-prev" style="display:none" href="#"></a>' +
                    '<a class="notification-calendar-btn btn-next" href="#"></a>' +
                    '</header>');

                this.updateHeader(todayDate, header);
                calendar.append(header);

                this.buildCalendar(todayDate, calendar);
                container.append(calendar);

                this.bindEvents();
                this.settings.onInit(this);

            },

            //Update the current month header
            updateHeader: function(date, header) {
                var monthText = this.settings.months[date.getMonth()];
                monthText += this.settings.displayYear ? ' <div class="year">' + date.getFullYear() :
                    '</div>';
                header.find('.month').html(monthText);
            },

            //Build calendar of a month from date
            buildCalendar: function(fromDate, calendar) {
                var plugin = this;

                calendar.find('table').remove();

                var body = $('<table></table>');
                var thead = $('<thead></thead>');
                var tbody = $('<tbody></tbody>');

                //setting current year and month
                var y = fromDate.getFullYear(),
                    m = fromDate.getMonth();

                //first day of the month
                var firstDay = new Date(y, m, 1);
                //last day of the month
                var lastDay = new Date(y, m + 1, 0);
                // Start day of weeks
                var startDayOfWeek = firstDay.getDay();

                if (this.settings.fixedStartDay !== false) {
                    // Backward compatibility
                    startDayOfWeek = this.settings.fixedStartDay === true ? 1 : this.settings
                        .fixedStartDay;

                    // If first day of month is different of startDayOfWeek
                    while (firstDay.getDay() !== startDayOfWeek) {
                        firstDay.setDate(firstDay.getDate() - 1);
                    }
                    // If last day of month is different of startDayOfWeek + 7
                    while (lastDay.getDay() !== ((startDayOfWeek + 6) % 7)) {
                        lastDay.setDate(lastDay.getDate() + 1);
                    }
                }

                //Header day in a week ( (x to x + 7) % 7 to start the week by monday if x = 1)
                for (var i = startDayOfWeek; i < startDayOfWeek + 7; i++) {
                    thead.append($('<td>' + this.settings.days[i % 7].substring(0, 3) + '</td>'));
                }
                //For firstDay to lastDay
                for (var day = firstDay; day <= lastDay; day.setDate(day.getDate())) {
                    var tr = $('<tr></tr>');
                    //For each row
                    for (var i = 0; i < 7; i++) {
                        var td = $('<td><div class="day" data-date="' + day.toLocaleDateString(
                            'en-US') +
                            '">' + day
                            .getDate() + '</div></td>');

                        var $day = td.find('.day');
                        if (user_type === 'sales-support') {

                            var lowerLimit = new Date();
                            var upperLimit = new Date(lowerLimit.getFullYear(), lowerLimit.getMonth() +
                                1,
                                lowerLimit.getDate() - 16);
                            //if today is this day
                            // if (day.toDateString() === (new Date).toDateString()) {
                            //     $day.addClass("today");
                            // }

                            //if day is not in this month
                            if ((day.getMonth() != fromDate.getMonth()) || (day > upperLimit) || (day <
                                    lowerLimit)) {
                                $day.addClass("wrong-month");
                            }
                        } else if (user_type === 'teacher-coordinator') {

                            var upperLimit = new Date();
                            var lowerLimit = new Date(upperLimit.getFullYear(), upperLimit.getMonth() -
                                1,
                                upperLimit.getDate() + 1);
                            //if today is this day
                            if (day.toDateString() === (new Date).toDateString()) {
                                $day.addClass("today");
                            }

                            //if day is not in this month
                            if ((day.getMonth() != fromDate.getMonth()) || (day > upperLimit) || (day <
                                    lowerLimit)) {
                                $day.addClass("wrong-month");
                            }

                        }
                        // filter today's events
                        var todayEvents = plugin.getDateEvents(day);

                        if (todayEvents.length && plugin.settings.displayEvent) {
                            $day.addClass(plugin.settings.disableEventDetails ? "has-event disabled" :
                                "has-event");
                        } else {
                            $day.addClass(plugin.settings.disableEmptyDetails ? "disabled" : "");
                        }

                        // associate some data available from the onDayCreate callback
                        $day.data('todayEvents', todayEvents);

                        // simplify further customization
                        this.settings.onDayCreate($day, day.getDate(), m, y);

                        tr.append(td);
                        day.setDate(day.getDate() + 1);
                    }
                    tbody.append(tr);
                }

                body.append(thead);
                body.append(tbody);

                var eventContainer = $(
                    '<div class="event-container"><div class="close"></div><div class="event-wrapper"></div></div>'
                );

                calendar.append(body);
                calendar.append(eventContainer);
            },
            changeMonth: function(value) {
                this.currentDate.setMonth(this.currentDate.getMonth() + value, 1);
                this.buildCalendar(this.currentDate, $(this.element).find('.calendar'));
                this.updateHeader(this.currentDate, $(this.element).find('.calendar header'));
                this.settings.onMonthChange(this.currentDate.getMonth(), this.currentDate.getFullYear())
                console.log(user_type);
                if (user_type === 'sales-support') {
                    console.log('running');
                    if (value === 1) {
                        $('.notification-calendar-btn.btn-prev').css('display', 'inline-block');
                        $('.notification-calendar-btn.btn-next').css('display', 'none');
                    } else {
                        $('.notification-calendar-btn.btn-prev').css('display', 'none');
                        $('.notification-calendar-btn.btn-next').css('display', 'inline-block');

                    }
                } else if (user_type === 'teacher-coordinator') {
                    if (value === 1) {
                        $('.notification-calendar-btn.btn-prev').css('display', 'inline-block');
                        $('.notification-calendar-btn.btn-next').css('display', 'none');
                    } else {
                        $('.notification-calendar-btn.btn-prev').css('display', 'none');
                        $('.notification-calendar-btn.btn-next').css('display', 'inline-block');
                    }
                }
            },
            //Init global events listeners
            bindEvents: function() {
                var plugin = this;

                //Remove previously created events
                $(plugin.element).off();

                //Click previous month
                $(plugin.element).on('click', '.btn-prev', function(e) {
                    plugin.changeMonth(-1)
                    e.preventDefault();
                });

                //Click next month
                $(plugin.element).on('click', '.btn-next', function(e) {
                    plugin.changeMonth(1);
                    e.preventDefault();
                });

                //Binding day event
                $(plugin.element).on('click', '.day', function(e) {
                    var date = new Date($(this).data('date'));
                    var events = plugin.getDateEvents(date);
                    if (!$(this).hasClass('disabled')) {
                        plugin.fillUp(e.pageX, e.pageY);
                        plugin.displayEvents(events);
                    }
                    plugin.settings.onDateSelect(date, events);
                });

                //Binding event container close
                $(plugin.element).on('click', '.event-container .close', function(e) {
                    plugin.empty(e.pageX, e.pageY);
                });
            },
            getDateEvents: function(d) {
                var plugin = this;
                return plugin.settings.events.filter(function(event) {
                    return plugin.isDayBetween(new Date(d), new Date(event.startDate), new Date(
                        event.endDate));
                });
            },

        });

        $.fn[pluginName] = function(options) {
            return this.each(function() {
                if (!$.data(this, "plugin_" + pluginName)) {
                    $.data(this, "plugin_" + pluginName, new Plugin(this, options));
                }
            });
        };
    })(jQuery, window, document);
</script>
<script>
    $(document).on('click', '.day:not(.wrong-month)', function() {
        $('.day.today').removeClass('today');
        $(this).addClass('today');
    });
</script>
{{-- @endpush --}}
