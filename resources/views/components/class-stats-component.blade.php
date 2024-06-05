@isset($Model)
    <div class="row">
        <div class="col-md-8 col-12">
            <div class="summary_chart shadow">
                <div class="py-3">
                    <h4 class="d-inline text-med px-14 px-4">Total No of Classes</h4>
                </div>
                <hr class="my-0">
                {{-- @include('front.customer.components.student_stats') --}}
                <div class="my-3 d-flex justify-content-sm-center justify-content-end px-14 flex-sm-nowrap flex-wrap">
                    <div class="label-chart attended me-sm-5"><span>Attended</span></div>
                    <div class="label-chart missed me-sm-5"><span>Unattended</span></div>
                   
                    <div class="label-chart unattended mt-sm-0 mt-2"><span>Scheduled</span></div>

                </div>
                <div class="container-xl px-sm-3 px-2 py-2">
                    <div class="row chart-container mx-0 justify-content-center">
                        <div class="col-sm-2 col-2 px-14 text-sb px-sm-2 px-0">
                            @forelse($Model as $key => $Months)
                                <div class="classes-slot">
                                    <span class="d-sm-none d-inline">{!! GetShortMonthName($key) !!}</span><span
                                        class="d-sm-inline d-none">{{ $key }}</span>
                                </div>

                            @empty
                                <div class="classes-slot">
                                    <span class="d-sm-none d-inline">{{ __('No records') }}</span><span
                                        class="d-sm-inline d-none">{{ __('No records') }}</span>
                                </div>
                            @endforelse
                        </div>
                        <div class="col-sm-9 col-10 px-14 chart-right-col px-0">
                            @forelse($Model as $key => $Months)
                                <div class="classes-slot px-sm-3 px-1">
                                    @forelse($Months as $keymonth => $status)
                                        @if ($keymonth != 'count')
                                            <div class="slot {{ $keymonth }}"
                                                data-value="{{ ($status->count() / $Months['count']['count']) * 100 }}">
                                                {{ $status->count() }}
                                            </div>
                                        @endif
                                    @empty
                                    @endforelse
                                </div>
                            @empty
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-12 mt-md-0 mt-4">
            <div class="mx-auto summary_container shadow">
                <div class="py-3 d-flex justify-content-between px-4">
                    <h4 class="d-inline text-med px-14 mb-0 mt-1 mt-sm-0">Monthly Summary</h4>
                    <div class="text-muted px-14"><i
                            class="fa fa-angle-left text-muted pe-1 cursor-pointer previous_month_summary"
                            aria-hidden="true"></i><strong class="month_name_short">
                            {{ \Carbon\Carbon::parse(now())->format('M') }} </strong><i
                            class="ps-1 fa fa-angle-right text-muted cursor-pointer next_month_summary "
                            aria-hidden="true"></i>
                    </div>
                </div>
                <hr class="my-0">
                <div class="mt-4 px-4 px-14 pb-5">
                    <div class="pb-3 text-sb">
                        {{-- Total Number of Classes In {{ \Carbon\Carbon::now()->subMonth()->format('F') }} --}}
                        Total Number of Classes In <strong
                            class="month_name_full">{{ \Carbon\Carbon::parse(now())->format('F') }}
                        </strong>
                    </div>
                    <div class="py-3 row summary_item">
                        <div class="col-6 text-start text-med">
                            Attended Classes
                        </div>
                        <div class="col-6 text-end text-sb attended_stats">

                            {{ isset($Model[\Carbon\Carbon::parse(now())->format('F')]['attended'])
                                ? $Model[\Carbon\Carbon::parse(now())->format('F')]['attended']->count() ?? 0
                                : 0 }}

                        </div>
                    </div>
                    <div class="py-3 row summary_item">
                        <div class="col-6 text-start text-med">
                            Unattended Classes
                        </div>
                        <div class="col-6 text-end text-sb unattended_stats">
                            {{ isset($Model[\Carbon\Carbon::parse(now())->format('F')]['unattended'])
                                ? $Model[\Carbon\Carbon::parse(now())->format('F')]['unattended']->count() ?? 0
                                : 0 }}
                        </div>
                    </div>
                    {{-- <div class="py-3 row summary_item">
                        <div class="col-6 text-start text-med">
                            Cancelled Classes
                        </div>
                        <div class="col-6 text-end text-sb cancelled_stats">
                            {{ isset($Model[\Carbon\Carbon::parse(now())->format('F')]['cancelled'])
                                ? $Model[\Carbon\Carbon::parse(now())->format('F')]['cancelled']->count() ?? 0
                                : 0 }}

                        </div>
                    </div> --}}
                    <div class="py-3 row summary_item">
                        <div class="col-6 text-start text-med">
                            Scheduled Classes
                        </div>
                        <div class="col-6 text-end text-sb scheduled_stats">
                            {{ isset($Model[\Carbon\Carbon::parse(now())->format('F')]['scheduled'])
                                ? $Model[\Carbon\Carbon::parse(now())->format('F')]['scheduled']->count() ?? 0
                                : 0 }}


                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
@endisset

{{-- <a href="javascript:void(0)" id="back-btn" data-component="timeline" data-bs-toggle="tab" data-bs-target="#timeline"
     role="tab" aria-controls="timeline" aria-selected="true"
    class="nav nav-item nav-link btn btn-outline-primary back-btn text-med float-end clearfix">Back</a> --}}

{{-- @push('after-style') --}}
<style>
    .label-chart::before {
        content: '';
        width: 14px;
        height: 14px;
        position: absolute;
        left: 0;
        top: 3px;
        border-radius: 2px;
    }

    .label-chart.attended::before {
        background-color: #559739;
    }

    /* .label-chart.reschedule::before {
        background-color: #559739;
    } */

    .label-chart.cancelled::before {
        background-color: #FFAA00;
    }

    .label-chart.missed::before {
        background-color: #FF3B3B;
    }

    .label-chart.unattended::before {
        background-color: #3AB4FF;
    }



    .label-chart {
        position: relative;
    }

    .label-chart>span {
        margin-left: 20px;
    }

    .classes-slot {
        height: 65px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
    }

    .chart-right-col .classes-slot {
        border-top: 1px solid #D9D9D972;
        border-bottom: 1px solid #D9D9D972;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
    }

    .classes-slot>div {
        padding: 5px 0;
        text-align: center;
        border-radius: 4px;
        color: white;
    }

    .chart-container>.chart-right-col {
        border-left: 1px solid #D9D9D972;
        border-right: 1px solid #D9D9D972;
    }

    .chart-right-col .attended {
        background-color: #559739;
    }
    .chart-right-col .scheduled {
        background-color: #3AB4FF;
    }

    /* .chart-right-col .reschedule {
        background-color: #559739;
    } */

    .chart-right-col .cancelled {
        background-color: #FFAA00;
    }

    .chart-right-col .missed {
        background-color: #FF3B3B;
    }

    .chart-right-col .unattended {
        background-color: #FF3B3B;
    }

    .back-btn {
        width: 150px;
        height: 44px;
        margin: 49px 0;
        line-height: 1.8;
        font-size: var(--px-14) !important;
    }

    @media screen and (min-width:768px) and (max-width:991px) {
        .summary_container .px-14 {
            font-size: 12px;
        }

        .summary_chart,
        .summary_container {
            height: 437px;
        }
    }

    @media screen and (max-width:550px) {
        .label-chart {
            width: 40%;
        }

        .classes-slot {
            font-size: 12px;
        }
    }

    @media screen and (min-width:1200px) {

        .summary_chart,
        .summary_container {
            height: 395px;
        }
    }

    @media screen and (max-width:1199px) {
        .summary_chart {
            height: 437px;
        }
    }
</style>
{{-- @endpush --}}
{{-- @push('after-script') --}}
<script>
    var date = 0; //mean this month plus one me
    var teacherid = '{{ auth()->user()->id }}';
    $(document).ready(function() {
        if ($('.classes-slot .slot').length > 1) {
            $('.classes-slot .slot').each(function() {
                let value = $(this).data('value');
                $(this).css('width', value - 1 + '%');
            })
        } else {
            const el = $('.classes-slot .slot');
            let value = $(el).data('value');
            $(el).css('width', '100%');
        }


        $('.next_month_summary').click(function(e) {
            e.preventDefault();
            if (date >= 0)
                return;
            date++;
            GetAttendaceStatsofMonth();
        });
        $('.previous_month_summary').click(function(e) {
            e.preventDefault();
            if (date <= -11)
                return;
            date--;
            GetAttendaceStatsofMonth();



        });

        // $('#back-btn').on('click', function() {
        //     // $('#timeline-sidebar-tab').parent().click();
        //     $('#timeline-sidebar-tab').click();
        //     $(this).removeClass('active');
        // })

    })

    function GetAttendaceStatsofMonth() {
        var formdate = new FormData();
        formdate.append('submonths', date);
        formdate.append('teacherid', teacherid);
        Ajax_Call_Dynamic('{{ route('teacher.GetTeacherStatsOfMonth', [app()->getLocale()]) }}', "post", formdate,
            "OneMonthStatsSuccess", 'FailedToasterResponse', '', 'False');

    }

    function OneMonthStatsSuccess(response) {


        $('.month_name_short').html(response.response.month_short);
        $('.month_name_full').html(response.response.month_full);
        if ("attended" in response.response)
            $('.attended_stats').html(response.response['attended'].length);
        else
            $('.attended_stats').html('0');
        if ("unattended" in response.response)
            $('.unattended_stats').html(response.response['unattended'].length);
        else
            $('.unattended_stats').html('0');
        if ("cancelled" in response.response)
            $('.cancelled_stats').html(response.response['cancelled'].length);
        else
            $('.cancelled_stats').html('0');
        if ("scheduled" in response.response)
            $('.scheduled_stats').html(response.response['scheduled'].length);
        else
            $('.scheduled_stats').html('0');



    }
</script>
{{-- @endpush --}}
