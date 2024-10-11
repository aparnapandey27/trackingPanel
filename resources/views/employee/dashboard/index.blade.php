{{-- @extends('employee.layout.app')
@section('title', 'Employee Dashboard')
@section('content')

<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <h1>Employee's Dashboard</h1>
</div>

@endsection --}}


@extends('employee.layout.app')
@section('title', 'Dashboard')
@push('style')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-daterangepicker/daterangepicker.css') }}">
    <style>
        state {
            padding: 7px;
            margin-bottom: 1.50rem;
        }

        .state-title {
            text-align: center;
            font-size: 1rem;
            font-weight: 600;
        }

        .state-body {
            text-align: center;
            font-size: 1.50rem;
            font-weight: 600;
        }

    </style>
@endpush
@section('content')
<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<div class="h-100">
					<div class="row mb-3 pb-1">
						<div class="col-12">
							<div class="d-flex align-items-lg-center flex-lg-row flex-column">
								<div class="flex-grow-1">
									<h4 class="fs-16 mb-1">{{ auth()->user()->name }}</h4>
									<p class="text-muted mb-0">Here's what's happening today.</p>
								</div>
								<div class="mt-3 mt-lg-0">
									<form action="{{ route('employee.dashboard') }}" method="GET" id="performance-form">
										<div class="row g-3 mb-0 align-items-center">
											<div class="col-sm-auto">
												<div class="input-group">
													<input type="text" class="form-control border-0 dash-filter-picker shadow" id="daterange" name="daterange">
													<div class="input-group-text bg-primary border-primary text-white" id="daterange" name="daterange">
														<i class="ri-calendar-2-line"></i>
													</div>
												</div>
											</div>
											<!--end col-->
											<div class="col-auto">
												<button type="button" class="btn btn-primary" onclick="submit_form()">
													<i class="ri-play-circle-line align-middle me-1"></i>{{ __('Generate Report') }} </button>
											</div>											
										</div>
										<!--end row-->
									</form>
								</div>
							</div>
							<!-- end card header -->
						</div>
						<!--end col-->
					</div>
					<div class="row">
                        <div class="col-xl-12 mb-4">
                            <div class="card crm-widget">
                                <div class="card-body p-0">
                                    <div class="row row-cols-xxl-5 row-cols-md-3 row-cols-1 g-0">
                                        <div class="col">
                                            <div class="py-4 px-3">
                                                <h5 class="text-muted text-uppercase fs-13">Campaign 
                                                </h5>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="ri-space-ship-line display-6 text-muted"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h2 class="mb-0">
                                                            <span class="counter-value" data-target="{{ $total['offer'] }}">0</span>
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end col -->
                                        <div class="col">
                                            <div class="mt-3 mt-md-0 py-4 px-3">
                                                <h5 class="text-muted text-uppercase fs-13">Students 
                                                </h5>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="la la-users display-6 text-muted"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h2 class="mb-0"><span class="counter-value" data-target="{{ $total['student'] }}">0</span></h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end col -->
                                        <div class="col">
                                            <div class="mt-3 mt-md-0 py-4 px-3">
                                                <h5 class="text-muted text-uppercase fs-13">Clicks
                                                </h5>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="mdi mdi-cursor-default-click display-6 text-muted"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h2 class="mb-0">
                                                            <span class="counter-value" data-target="{{ $quick_stats['clicks'] }}">0</span>
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end col -->
                                        <div class="col">
                                            <div class="mt-3 mt-lg-0 py-4 px-3">
                                                <h5 class="text-muted text-uppercase fs-13">Conversions
                                                </h5>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="ri-pulse-line display-6 text-muted"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h2 class="mb-0"><span class="counter-value" data-target="{{ $quick_stats['conversions'] }}">0</span>
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col">
                                            <div class="mt-3 mt-lg-0 py-4 px-3">
                                                <h5 class="text-muted text-uppercase fs-13">Payout
                                                </h5>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="ri-exchange-dollar-line display-6 text-muted"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h2 class="mb-0"><span class="counter-value" data-target="{{ number_format($quick_stats['payouts'], 2) }}">0</span>
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                        
                                    </div>
                                    <!-- end row -->
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>					
					<div class="row">
						<div class="col-xl-12">
							<div class="card">
								<div class="card-header border-0 align-items-center d-flex">
									<h4 class="card-title mb-0 flex-grow-1">Balance Review</h4>									
								</div>								
								<div class="card-body p-0 pb-2">
									<div class="w-100">
										<div id="customer_impression_charts" data-colors='["--vz-primary", "--vz-success", "--vz-danger"]' class="apex-charts" dir="ltr"></div>
									</div>
								</div>
								<!-- end card body -->
							</div>
							<!-- end card -->
						</div>						
					</div>
					<div class="row my-4">
						
						<div class="col-xl-4 mb-4">
							<div class="card card-height-100 ">
								<div class="card-header align-items-center d-flex">
									<h4 class="card-title mb-0 flex-grow-1">Top Student</h4>
									
								</div>
								<!-- end card header -->
								<div class="card-body">
									<div class="table-responsive table-card">
										<table class="table table-centered table-hover align-middle table-nowrap mb-0">
											<thead class="text-muted table-light">
												<tr>
													<th>ID</th>
                                                    <th>Student</th>
                                                    <th>Payout</th>
												</tr>
											</thead>
											<tbody>
												@forelse ($top_students as $student)
                                                    <tr>
                                                        <td>{{ $student->aid }}</td>
                                                        <td><a
                                                                href="{{ route('employee.student.show', $student->aid) }}">{{ $student->aname }}</a>
                                                        </td>
                                                        <td>{{ $student->payout }} {{ config('app.currency') }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center text-lg">No data</td>
                                                    </tr>
                                                @endforelse
											</tbody>
										</table>
										<!-- end table -->
									</div>									
								</div>
								<!-- .card-body-->
							</div>
							<!-- .card-->
						</div>
						<div class="col-xl-4">
							<div class="card">
								<div class="card-header align-items-center d-flex">
									<h4 class="card-title mb-0 flex-grow-1">Top Countries</h4>									
								</div>
								<!-- end card header -->
								<div class="card-body">
									<div class="table-responsive table-card">
										<table class="table table-borderless table-centered align-middle table-nowrap mb-0">
											<thead class="text-muted table-light">
												<tr>
													<th>Country</th>
                                                    {{-- <th>Click</th>
                                                    <th>Conv.</th> --}}
                                                    <th>Payout</th>
												</tr>
											</thead>
											<tbody>
												@forelse ($top_countries as $country)
                                                    <tr>
                                                        <td>{{ $country->Country }}</td>
                                                        {{-- <td>{{ $country->Clicks }}</td>
                                                        <td>{{ $country->Leads }}</td> --}}
                                                        <td>{{ $country->Payout }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center text-lg">No data</td>
                                                    </tr>
                                                @endforelse
											</tbody>
											<!-- end tbody -->
										</table>
										<!-- end table -->
									</div>
								</div>                
							</div>
							<!-- .card-->
						</div>
                        <div class="col-xl-4">
                            
							<div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Top Offers</h4>	
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table class="table table-centered table-hover align-middle table-nowrap mb-0">
                                            <thead class="text-muted table-light">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Offer</th>
                                                    <th>Payout</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($top_offers as $offer)
                                                    <tr>
                                                        <td>{{ $offer->oid }}</td>
                                                        <td><a
                                                                href="{{ route('employee.offer.show', $offer->oid) }}">{{ $offer->offer }}</a>
                                                        </td>
                                                        <td>{{ $offer->payout }} {{ config('app.currency') }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center text-lg">No data</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>								
							</div>
						</div>
					</div>
				</div>
				<!-- end .h-100-->
			</div>			
		</div>
	</div>
	<!-- container-fluid -->
</div>    

    
@endsection
@push('scripts')
        <!-- apexcharts -->
    <script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
   

    <!--Swiper slider js-->
    <script src="{{asset('assets/libs/swiper/swiper-bundle.min.js')}}"></script>

    <!-- Dashboard init -->
    <script src="{{asset('assets/js/pages/dashboard-ecommerce.init.js')}}"></script>
	

	<script src="{{ asset('assets/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-daterangepicker/daterangepicker.js') }}"></script>  
       

    <script>
        $('#daterange').daterangepicker({
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                    'month')]
            },
            "alwaysShowCalendars": true,
            "startDate": "{{ isset($from) ? (new DateTime($from))->format('m/d/Y') : date('m/d/M', strtotime('-6 days')) }}", // ,"11/25/2019",
            "endDate": "{{ isset($to) ? (new DateTime($to))->format('m/d/Y') : date('m/d/M') }}", // "12/01/2019",
            "opens": "left",
            "drops": "down"
        }, function(start, end, label) {
            // console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });

        function submit_form() {
            document.getElementById('performance-form').submit();
        }
    
        var data_click = {{ $chart['click'] }};
            var data_lead = {{ $chart['lead'] }};
            var data_payout = {{ $chart['payout'] }};                
            var data_date = <?php echo $chart['date']; ?>;
            var linechartcustomerColors = getChartColorsArray("customer_impression_charts");
            if (linechartcustomerColors) {
                var options = {
                    series: [{
                            name: "Click",
                            type: "area",
                            data: data_click,
                        },
                        {
                            name: "Conversion",
                            type: "bar",
                            data: data_lead,
                        },
                        {
                            name: "Payout",
                            type: "line",
                            data: data_payout,
                        },
                    ],
                    chart: {
                        height: 370,
                        type: "line",
                        toolbar: {
                            show: false,
                        },
                    },
                    stroke: {
                        curve: "smooth",
                        
                        width: [2, 0, 2.2],
                    },
                    fill: {
                        opacity: [0.1, 0.9, 1],
                    },
                    markers: {
                        size: [0, 0, 0],
                        strokeWidth: 2,
                        hover: {
                            size: 4,
                        },
                    },
                    xaxis: {
                        categories: data_date,
                        axisTicks: {
                            show: false,
                        },
                        axisBorder: {
                            show: false,
                        },
                    },
                    grid: {
                        show: true,
                        xaxis: {
                            lines: {
                                show: false,
                            },
                        },
                        yaxis: {
                            lines: {
                                show: true,
                            },
                        },
                        padding: {
                            top: 0,
                            right: -2,
                            bottom: 15,
                            left: 10,
                        },
                    },
                    legend: {
                        show: true,
                        horizontalAlign: "center",
                        offsetX: 0,
                        offsetY: -5,
                        markers: {
                            width: 9,
                            height: 9,
                            radius: 6,
                        },
                        itemMargin: {
                            horizontal: 10,
                            vertical: 0,
                        },
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: "30%",
                            barHeight: "50%",
                        },
                    },
                    colors: linechartcustomerColors,
                    yaxis: {
                        title: {
                            text: 'Rates',
                        },
                        min: 0
                    },
                    tooltip: {
                        shared: true,
                        intersect: false,
                        y: {
                            formatter: function (y) {
                                if (typeof y !== "undefined") {
                                    return y.toFixed(0);
                                }
                                return y;

                            }
                        }
                    },
                };
                var chart = new ApexCharts(
                    document.querySelector("#customer_impression_charts"),
                    options
                );
                chart.render();
            }

        
    </script>
@endpush
