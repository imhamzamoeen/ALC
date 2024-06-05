<div class="calendar">
    <div class="headline">
        <span class="click-left"><i class="octicon octicon-triangle-left"></i></span>
        <span class="month">JANUARY</span>
        <span class="divider">&nbsp;&nbsp;<i class="octicon octicon-primitive-dot"></i>&nbsp;&nbsp;</span>
        <span class="year">2015</span>
        <span class="click-right"><i class="octicon octicon-triangle-right"></i></span>
    </div>
    <div class="weekdays">
        <div class="day">MON</div>
        <div class="day">TUE</div>
        <div class="day">WED</div>
        <div class="day">THU</div>
        <div class="day">FRI</div>
        <div class="day">SAT</div>
        <div class="day">SUN</div>
    </div>
    <div class="days">
    </div>
</div>
@push('after-style')
    <style>
        $background-gray: #222;
        $my-green: #ad0;
        $light-gray: #bbb;
        $dark-gray: #555;

        * {
            box-sizing: border-box;
        }

        body {
            background-color: $background-gray;
            font-family: sans-serif;
            font-size: 0.9em;
        }

        .calendar {
            width: 400px;
            min-height: 300px;
            border: 1px solid #666;
        }

        .headline {
            padding: 10px 0;
            text-align: center;
            position: relative;
            color: $dark-gray;
            border-bottom: 1px solid $light-gray;

            .month {}

            .divider {
                color: $my-green;
            }

            .year {
                color: $light-gray;
            }

            .click-left,
            .click-right {
                cursor: pointer;
                position: absolute;
            }

            .click-left {
                left: 5px;
            }

            .click-right {
                right: 5px;
            }
        }

        .weekdays,
        .days {
            text-align: center;
            margin: 0 auto;
        }

        .weekdays * {
            width: 40px;
            margin: 10px 6px;
            color: $light-gray;
            display: inline-block;
        }

        .date {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            border: 1px solid $background-gray; //Hack to prevent 1px offset animation
            margin: 2px 8px;
            color: $light-gray;

            &.out-of-scope {
                color: $dark-gray;
            }

            &.selected {
                color: $my-green;
                border: 1px solid $my-green;
            }
        }

    </style>
@endpush
@push('after-script')
    <script>
        var currentMonth = 0,
            currentYear = 2015,
            monthMap = ['JANUARY', 'FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE', 'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER',
                'NOVEMBER', 'DECEMBER'
            ];
        $dayList = $('.days');

        var addDayElement = function(date, $container) {
            var element = $(document.createElement('div')).addClass('date');
            if (date.getMonth() !== currentMonth) {
                element.addClass('out-of-scope');
            }
            element.text(date.getDate());
            $container.append(element);
        };

        var getFirstLastDates = function(date) {
            var startDate, endDate;
            //First, find the first Monday prior to the beginning of the current month.
            startDate = new Date(date.getFullYear(), date.getMonth(), 1);
            while (startDate.getDay() !== 1) {
                startDate.setDate(startDate.getDate() - 1);
            }
            //Now, find the Sunday nearest the last day of the current month.
            endDate = new Date(date.getFullYear(), date.getMonth() + 1, 0);
            while (endDate.getDay() !== 0) {
                endDate.setDate(endDate.getDate() + 1);
            }
            return [startDate, endDate];
        };

        var renderDays = function(dateRange) {
            $dayList.empty();
            var startDate = dateRange[0],
                endDate = dateRange[1],
                currentDate = startDate;

            while (currentDate <= endDate) {
                addDayElement(currentDate, $dayList);
                currentDate.setDate(currentDate.getDate() + 1);
            }
        }

        var loadCalendar = function(date) {
            $('.headline .month').text(monthMap[currentMonth]);
            $('.headline .year').text(currentYear);
            renderDays(getFirstLastDates(date));
        };

        //start us off on the current month & date;
        loadCalendar(new Date());

        $('.days').on('click', '.date', function(e) {
            $('.date').removeClass('selected');
            $(this).addClass('selected');
        });

        $('.click-left').on('click', function(e) {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            loadCalendar(new Date(currentYear, currentMonth));
        });

        $('.click-right').on('click', function(e) {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            loadCalendar(new Date(currentYear, currentMonth));
        });
    </script>
@endpush
