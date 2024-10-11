{{-- @extends('advertiser.layout.app')
@section('title', 'Advertiser Dashboard')
@section('content')

<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <h1>Advertiser's Dashboard</h1>
</div>

@endsection --}}


@extends('advertiser.layout.app')
@section('title', 'Dashboard')
@section('content')
 <div class="page-content">
                <div class="container-fluid"> 

                    <div class="row">
                        <div class="col">
                         <!--end row-->
                                <div class="row">
                                    <div class="col-xl-3 col-md-6 mb-4">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Clicks</p>
                                                    </div>
                                               
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">$<span class="counter-value" data-target="{{ $quick_stats['clicks'] }}">0</span></h4>
                                                        
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="flex-grow-1">
                                                            <lord-icon
                                                            src="https://cdn.lordicon.com/qgonxrut.json" trigger="loop"
                                                            colors="primary:#30e8bd,secondary:#1663c7" style="width:55px;height:55px">
                                                        </lord-icon>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->

                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                     <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Conversions</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <h5 class="text-danger fs-14 mb-0">
                                                            <!-- <i class="ri-arrow-right-down-line fs-13 align-middle"></i> {{$totalConversionToday}}  -->
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $quick_stats['conversions'] }}">0</span></h4>
                                                        
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="flex-grow-1">
                                                            <lord-icon
                                                                src="https://cdn.lordicon.com/vaeagfzc.json" trigger="loop"
                                                                colors="primary:#405189,secondary:#0ab39c" style="width:55px;height:55px">
                                                            </lord-icon>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->

                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">CPC</p>
                                                    </div>
                                                  
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{number_format( $quick_stats['cpcs'],2)}}">0</span>%</h4>
                                                        <a href="#" class="text-decoration-underline"> </a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="flex-grow-1">
                                                            <lord-icon src="https://cdn.lordicon.com/qhviklyi.json" trigger="loop" colors="primary:#405189,secondary:#0ab39c" style="width:55px;height:55px"></lord-icon>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->

                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> COST</p>
                                                    </div>
                                                   
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $quick_stats['costs'] }}">0</span></h4>
                                                        <a href="#" class="text-decoration-underline"> </a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="flex-grow-1">
                                                            <lord-icon
                                                            src="https://cdn.lordicon.com/yeallgsa.json"
                                                            trigger="loop"
                                                            colors="primary:#405189,secondary:#0ab39c"
                                                            style="width:55px;height:55px">
                                                        </lord-icon>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->
                                </div> <!-- end row-->

                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header border-0 align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Report</h4>
                                              
                                            </div><!-- end card header -->
    
                                           <!-- end card header -->
                                            <div class="card-body p-0 pb-2">
                                                <div>
                                                    <div id="projects-overview-chart" data-colors='["--vz-primary", "--vz-warning", "--vz-success"]' dir="ltr" class="apex-charts"></div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->
                                </div>

                               <!-- end row-->

                               <!-- end row-->

                            </div> <!-- end .h-100-->

                        </div> <!-- end col -->

                        <!-- end col -->
                    </div>

                </div>
                <!-- container-fluid -->
 </div>

@endsection
@push('scripts')
<script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>



{{-- <script src="{{asset('assets/js/pages/dashboard-projects.init.js')}}"></script> --}}
<script>
    function getChartColorsArray(e) {
    if (null !== document.getElementById(e)) {
       var t = document.getElementById(e).getAttribute("data-colors");
       if (t) return (t = JSON.parse(t)).map(function (e) {
          var t = e.replace(" ", "");
          return -1 === t.indexOf(",") ? getComputedStyle(document.documentElement).getPropertyValue(t) || t : 2 == (e = e.split(",")).length ? "rgba(" + getComputedStyle(document.documentElement).getPropertyValue(e[0]) + "," + e[1] + ")" : t
       });
       console.warn("data-colors Attribute not found on:", e)
    }
 }
 var data_click = {{ $chart['click'] }};
            var data_leads = {{ $chart['lead'] }};
            var data_payout = {{ $chart['cost'] }};
            var data_date = <?php echo $chart['date']; ?>;
 var options, chart, linechartcustomerColors = getChartColorsArray("projects-overview-chart"),
    isApexSeriesData = (linechartcustomerColors && (options = {
       series: [{
          name: "Clicks",
          type: "bar",
          data: data_click
       }, {
          name: "Conversion",
          type: "area",
          data: data_leads
       }, {
          name: "Earning",
          type: "bar",
          data: data_payout 
       }],
       chart: {
          height: 374,
          type: "line",
          toolbar: {
             show: !1
          }
       },
       stroke: {
          curve: "smooth",
          dashArray: [0, 3, 0],
          width: [0, 1, 0]
       },
       fill: {
          opacity: [1, .1, 1]
       },
       markers: {
          size: [0, 4, 0],
          strokeWidth: 2,
          hover: {
             size: 4
          }
       },
       xaxis: {
          categories: data_date,
          axisTicks: {
             show: !1
          },
          axisBorder: {
             show: !1
          }
       },
       grid: {
          show: !0,
          xaxis: {
             lines: {
                show: !0
             }
          },
          yaxis: {
             lines: {
                show: !1
             }
          },
          padding: {
             top: 0,
             right: -2,
             bottom: 15,
             left: 10
          }
       },
       legend: {
          show: !0,
          horizontalAlign: "center",
          offsetX: 0,
          offsetY: -5,
          markers: {
             width: 9,
             height: 9,
             radius: 6
          },
          itemMargin: {
             horizontal: 10,
             vertical: 0
          }
       },
       plotOptions: {
          bar: {
             columnWidth: "30%",
             barHeight: "70%"
          }
       },
       colors: linechartcustomerColors,
       tooltip: {
          shared: !0,
          y: [{
             formatter: function (e) {
                return void 0 !== e ? e.toFixed(0) : e
             }
          }, {
             formatter: function (e) {
                return void 0 !== e ? "" + e.toFixed(2) + "" : e
             }
          }, {
             formatter: function (e) {
                return void 0 !== e ? e.toFixed(0) : e
             }
          }]
       }
    }, (chart = new ApexCharts(document.querySelector("#projects-overview-chart"), options)).render()), {}),
    isApexSeries = document.querySelectorAll("[data-chart-series]"),
    donutchartProjectsStatusColors = (isApexSeries && Array.from(isApexSeries).forEach(function (e) {
       var t, e = e.attributes;
       e["data-chart-series"] && (isApexSeriesData.series = e["data-chart-series"].value.toString(), t = getChartColorsArray(e.id.value.toString()), t = {
          series: [isApexSeriesData.series],
          chart: {
             type: "radialBar",
             width: 36,
             height: 36,
             sparkline: {
                enabled: !0
             }
          },
          dataLabels: {
             enabled: !1
          },
          plotOptions: {
             radialBar: {
                hollow: {
                   margin: 0,
                   size: "50%"
                },
                track: {
                   margin: 1
                },
                dataLabels: {
                   show: !1
                }
             }
          },
          colors: t
       }, new ApexCharts(document.querySelector("#" + e.id.value.toString()), t).render())
    }), getChartColorsArray("prjects-status")),
    currentChatId = (donutchartProjectsStatusColors && (options = {
       series: [125, 42, 58, 89],
       labels: ["Completed", "In Progress", "Yet to Start", "Cancelled"],
       chart: {
          type: "donut",
          height: 230
       },
       plotOptions: {
          pie: {
             size: 100,
             offsetX: 0,
             offsetY: 0,
             donut: {
                size: "90%",
                labels: {
                   show: !1
                }
             }
          }
       },
       dataLabels: {
          enabled: !1
       },
       legend: {
          show: !1
       },
       stroke: {
          lineCap: "round",
          width: 0
       },
       colors: donutchartProjectsStatusColors
    }, (chart = new ApexCharts(document.querySelector("#prjects-status"), options)).render()), "users-chat");
 
 function scrollToBottom(e) {
    setTimeout(() => {
       new SimpleBar(document.getElementById("chat-conversation")).getScrollElement().scrollTop = document.getElementById("users-conversation").scrollHeight
    }, 100)
 }
 scrollToBottom(currentChatId);
</script>
@endpush