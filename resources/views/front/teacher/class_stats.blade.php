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
                <div class="label-chart reschedule me-sm-5"><span>Reschedule</span></div>
                <div class="label-chart cancelled me-sm-5 mt-sm-0 mt-2"><span>Cancelled</span></div>
                <div class="label-chart unattended mt-sm-0 mt-2"><span>Unattended</span></div>
            </div>
            <div class="container-xl px-sm-3 px-2 py-2">
                <div class="row chart-container mx-0">
                    <div class="col-sm-3 col-2 px-14 text-sb px-sm-2 px-0">
                        <div class="classes-slot">
                            <span class="d-sm-none d-inline">Sep</span><span class="d-sm-inline d-none">September</span>
                        </div>
                        <div class="classes-slot">
                            <span class="d-sm-none d-inline">Aug</span><span class="d-sm-inline d-none">August</span>
                        </div>
                        <div class="classes-slot">
                            <span class="d-sm-none d-inline">Jun</span><span class="d-sm-inline d-none">June</span>
                        </div>
                        <div class="classes-slot">
                            <span class="d-sm-none d-inline">Jul</span><span class="d-sm-inline d-none">July</span>
                        </div>
                    </div>
                    <div class="col-sm-9 col-10 px-14 chart-right-col px-0">
                        <div class="classes-slot px-sm-3 px-1">
                            <div class="slot attended" data-value="20">
                                20
                            </div>
                            <div class="slot reschedule" data-value="40">
                                40
                            </div>
                            <div class="slot cancelled" data-value="30">
                                30
                            </div>
                            <div class="slot unattended" data-value="10">
                                10
                            </div>
                        </div>
                        <div class="classes-slot px-sm-3 px-1">
                            <div class="slot attended" data-value="25">
                                25
                            </div>
                            <div class="slot reschedule" data-value="50">
                                50
                            </div>
                            <div class="slot cancelled" data-value="10">
                                10
                            </div>
                            <div class="slot unattended" data-value="15">
                                15
                            </div>
                        </div>
                        <div class="classes-slot px-sm-3 px-1">
                            <div class="slot attended" data-value="50">
                                50
                            </div>
                            <div class="slot reschedule" data-value="30">
                                30
                            </div>
                            <div class="slot cancelled" data-value="15">
                                15
                            </div>
                            <div class="slot unattended" data-value="5">
                                5
                            </div>
                        </div>
                        <div class="classes-slot px-sm-3 px-1">
                            <div class="slot attended" data-value="15">
                                15
                            </div>
                            <div class="slot reschedule" data-value="30">
                                30
                            </div>
                            <div class="slot cancelled" data-value="25">
                                25
                            </div>
                            <div class="slot unattended" data-value="30">
                                30
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-12 mt-md-0 mt-4">
        <div class="mx-auto summary_container shadow">
            <div class="py-3 d-flex justify-content-between px-4">
                <h4 class="d-inline text-med px-14 mb-0 mt-1 mt-sm-0">Monthly Summary</h4>
                <div class="text-muted px-14"><i class="fa fa-angle-left text-muted pe-1 cursor-pointer"
                        aria-hidden="true"></i> October <i class="ps-1 fa fa-angle-right text-muted cursor-pointer"
                        aria-hidden="true"></i>
                </div>
            </div>
            <hr class="my-0">
            <div class="mt-4 px-4 px-14 pb-5">
                <div class="pb-3 text-sb">
                    {{-- Total Number of Classes In {{ \Carbon\Carbon::now()->subMonth()->format('F') }} --}}
                    Total Number of Classes In October
                </div>
                <div class="py-3 row summary_item">
                    <div class="col-6 text-start text-med">
                        Attended Classes
                    </div>
                    <div class="col-6 text-end text-sb">
                        {{-- {{ $summary['total'] ?? '--' }} --}}
                        44
                    </div>
                </div>
                <div class="py-3 row summary_item">
                    <div class="col-6 text-start text-med">
                        Unattended Classes
                    </div>
                    <div class="col-6 text-end text-sb">
                        3
                    </div>
                </div>
                <div class="py-3 row summary_item">
                    <div class="col-6 text-start text-med">
                        Cancelled Classes
                    </div>
                    <div class="col-6 text-end text-sb">
                        2
                    </div>
                </div>
                <div class="py-3 row summary_item">
                    <div class="col-6 text-start text-med">
                        Scheduled Classes
                    </div>
                    <div class="col-6 text-end text-sb">
                        9
                    </div>
                </div>

            </div>
            {{-- @foreach (\App\Classes\Enums\StatusEnum::$Trials_With_Summary as $status)
                    @isset($summary['details'])
                        <div class="py-3 row summary_item">
                            <div class="col-6 text-start text-med">
                                {!! beautify_slug($status) !!}
                            </div>
                            <div class="col-6 text-end text-sb">
                                @php $stat_count = 0;
                              foreach($summary['details'] as $data){
                                if($status == $data->status){
                                    $stat_count = $data->count;
                                }
                              }
                                @endphp
                                {!! $stat_count !!}
                            </div>
                        </div>
                    @endif
               @endforeach --}}

        </div>
    </div>
</div>
<a href="javascript:void(0)" id="back-btn" data-component="timeline" data-bs-toggle="tab" data-bs-target="#timeline"
    role="tab" aria-controls="timeline" aria-selected="true"
    class="nav nav-item nav-link btn btn-outline-primary back-btn text-med float-end clearfix">Back</a>
@push('after-style')
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
            background-color: #3AB4FF;
        }

        .label-chart.reschedule::before {
            background-color: #559739;
        }

        .label-chart.cancelled::before {
            background-color: #FFAA00;
        }

        .label-chart.unattended::before {
            background-color: #FF3B3B;
        }

        .label-chart.unattended::before {
            background-color: #FF3B3B;
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
            background-color: #3AB4FF;
        }

        .chart-right-col .reschedule {
            background-color: #559739;
        }

        .chart-right-col .cancelled {
            background-color: #FFAA00;
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
@endpush
@push('after-script')
    <script>
        $(document).ready(function() {
            $('.classes-slot .slot').each(function() {
                let value = $(this).data('value');
                $(this).css('width', value - 1 + '%')
            })
            // $('#back-btn').on('click', function() {
            //     console.log('running');
            //     // $('#timeline-sidebar-tab').parent().click();
            //     $('#timeline-sidebar-tab').click();
            //     $(this).removeClass('active');
            // })
        })
    </script>
@endpush
