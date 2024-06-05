<div class="px-3 px-sm-4 class-stats h-100 py-3">
 
    <div class="d-flex justify-content-between">
        <div class="text-bold px-18">Class Stats</div>
        
        {{-- <div class="text-muted px-14"><i class="fa fa-angle-left text-muted pe-1 cursor-pointer" aria-hidden="true"></i>
            September <i class="ps-1 fa fa-angle-right text-muted cursor-pointer" aria-hidden="true"></i> </div> --}}
    </div>
    <div id="chart" class="pt-5"></div>
</div>

@push('after-style')
    <style>
        .class-stats {
            background-color: #f1f7ff;
        }

        .editStudent-info #chart {
            min-height: 100%;
        }

        .apexcharts-legend,
        .apexcharts-legend-series {
            display: block !important;
            padding: 0 !important;
        }

        .apexcharts-legend-text {
            margin-left: 0.4rem;
            font-weight: 500 !important;
        }

        .apexcharts-datalabels.legend-mouseover-inactive {
            opacity: 0.9 !important;
        }

        .apexcharts-datalabels text {
            font-size: 12px !important;
        }
    </style>
@endpush
@push('after-script')
    <script>
        var data=@JSON($chart_data);
       
        var attended = 0;
      
        var unattended = 0;
        var scheduled = 0;
        if ("attended" in data){
            attended=data.attended[0].count
        }
        
        if ("unattended" in data){
            unattended=data.unattended[0].count
        }
        if ("scheduled" in data){
            scheduled=data.scheduled[0].count
        }
    

        var options = {
            series: [attended,unattended,scheduled],
            legend: {
                position: "bottom",
                horizontalAlign: "left",
                fontSize: '14px',
                fontFamily: 'Poppins, Arial',
                width: '50%',
                height: '50%',
                markers: {
                    width: 8,
                    height: 8,
                }
            },
            tooltip: {
                enabled: false,
            },
            horizontalAlign: 'center',
            labels: ["Attended = " + attended,  "Unattended = " + unattended,
                "Scheduled = " +
                scheduled
            ],
            colors: ['#559739', '#FF3B3B', '#9978F6', '#FFC107'],
            chart: {
                type: 'donut',
                width: "100%",
                height: 430,

            },
            dataLabels: {
                enabled: true,
                textAnchor: 'middle',
                style: {
                    fontSize: '14px',
                    fontFamily: 'Poppins, Arial, sans-serif',
                    fontWeight: 'regular',
                },
                dropShadow: {
                    enabled: false,
                },
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        background: 'transparent',
                        labels: {
                            show: true,
                            value: {
                                show: true,
                                fontSize: '14px',
                                fontFamily: 'Poppins, Arial, sans-serif',
                                offsetY: 0,
                                formatter: function(val) {
                                    return val
                                }
                            },
                            total: {
                                show: true,
                                showAlways: true,
                                label: 'Total',
                                fontSize: '20px',
                                fontFamily: 'Poppins, Arial, sans-serif',
                                fontWeight: 500,
                                color: '#9AA1A9',
                                formatter: function(w) {
                                    return w.globals.seriesTotals.reduce((a, b) => {
                                        return a + b
                                    }, 0)
                                }
                            }
                        }
                    },
                }
            }
        }

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
@endpush
