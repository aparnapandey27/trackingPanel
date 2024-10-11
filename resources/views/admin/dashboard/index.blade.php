@extends('admin.layout.app')

@section('title', 'Dashboard')
@section('content')
@push('style')
    <link href="{{ asset('assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-daterangepicker/daterangepicker.css') }}">    
@endpush

<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<div class="h-20">
					<div class="row mb-3 pb-1">
						<div class="col-12">
							<div class="d-flex align-items-lg-center flex-lg-row flex-column">
								<div class="flex-grow-1">
									<h4 class="fs-16 mb-1">{{ auth()->user()->name }}</h4>
									<p class="text-muted mb-0">Here's what's happening today.</p>
								</div>
                <div class="mt-3 mt-lg-0">
                  <form action="{{ route('dashboard') }}" method="GET" id="performance-form">
                    <div class="input-group form-group">
                      <a href="javascript:void(0)" class="input-group-addon" id="daterangebtn">
                        <i class="fa fa-calendar"></i>
                         </a> 
                            <input type="text" style="float: right; margin-right:10px; line-height: 1; height: 30px;"
                            class="form-control" id="daterange" name="daterange" value="">
                              <span class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-sm" onclick="submit_form()">
                                  <i class="fa fa-play" aria-hidden="true"></i> {{ __('Generate Report') }}
                                </button>
                              </span>
                            </div>
                          </form>
                        </div>
                      </div><!-- end card header -->
                    </div>
                        <!--end col-->
                  </div>                    <!--end row-->

<div class="row">
	<!-- Total Clicks Card -->
	<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
	  <div class="card card-animate">
		<div class="card-body p-3">
		  <div class="row">
			<div class="col-8">
			  <div class="numbers">
				<p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Clicks</p>
				<h5 class="font-weight-bolder mb-0">
				  <span class="counter-value" data-target="{{ $quick_stats['clicks'] }}">0</span>
				  {{-- <span class="text-success text-sm font-weight-bolder">+55%</span> --}}
				</h5>
			  </div>
			</div>
			<div class="col-4 text-end">
			  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
				<i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
			  </div>
			</div>
		  </div>
		  <div class="d-flex align-items-end justify-content-between mt-4">
			<div>
			  <h5 class="text-success fs-14 mb-0">{{$todayClicks}}</h5>
			  <a href="{{ route('admin.report.click.log') }}" class="text-decoration-underline">See details</a>
			</div>
			<div class="avatar-sm flex-shrink-0">
			  <span class="avatar-title bg-success-subtle rounded fs-3">
				<i class="mdi mdi-cursor-default-click text-success"></i>
			  </span>
			</div>
		  </div>
		</div>
	  </div>
	</div>
  
	<!-- Conversion Card -->
	<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
	  <div class="card card-animate">
		<div class="card-body p-3">
		  <div class="row">
			<div class="col-8">
			  <div class="numbers">
				<p class="text-uppercase fw-medium text-muted text-truncate mb-0">Conversion</p>
				<h5 class="font-weight-bolder mb-0">
				  <span class="counter-value" data-target="{{ $quick_stats['conversions'] }}">0</span>
				  {{-- <span class="text-danger text-sm font-weight-bolder">+3%</span> --}}
				</h5>
			  </div>
			</div>
			<div class="col-4 text-end">
			  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
				<i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
			  </div>
			</div>
		  </div>
		  <div class="d-flex align-items-end justify-content-between mt-4">
			<div>
			  <h5 class="text-danger fs-14 mb-0">{{$todayConversions}}</h5>
			  <a href="{{ route('admin.report.conversion.log') }}" class="text-decoration-underline">See details</a>
			</div>
			<div class="avatar-sm flex-shrink-0">
			  <span class="avatar-title bg-info-subtle rounded fs-3">
				<i class="mdi mdi-cursor-default-click text-info"></i>
			  </span>
			</div>
		  </div>
		</div>
	  </div>
	</div>
  
	
	<!-- Total Offers Card -->
	<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
		<div class="card">
			<div class="card-body p-3">
				<div class="row">
					<div class="col-8">
						<div class="numbers">
							<p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Offers</p>
							<h5 class="font-weight-bolder mb-0">
								<span class="counter-value" data-target="{{ $total['offer'] }}">0</span>
							</h5>
						</div>
					</div>
					<div class="col-4 text-end">
						<div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
							<i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
						</div>
					</div>
				</div>
				<div class="d-flex align-items-end justify-content-between mt-4">
					<div>
						<h5 class="text-danger fs-14 mb-0">{{ $pending['offer'] }} <span class="text-danger" style="font-size: 12px;">(Pending)</span></h5>
						<a href="{{ route('admin.offers.index') }}" class="text-decoration-underline">See details</a>
					</div>
					<div class="avatar-sm flex-shrink-0">
						<span class="avatar-title bg-warning-subtle rounded fs-3">
							<i class="bx bxs-offer text-warning"></i>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	

  
	<!-- Students Card -->
	<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
		<div class="card card-animate">
		  <div class="card-body p-3">
			<div class="row">
			  <div class="col-8">
				<div class="numbers">
				  <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Students</p>
				  <h5 class="font-weight-bolder mb-0">
					<span class="counter-value" data-target="{{ $total['student'] }}">0</span>
				  </h5>
				</div>
			  </div>
			  <div class="col-4 text-end">
				<div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
				  <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
				</div>
			  </div>
			</div>
			<div class="d-flex align-items-end justify-content-between mt-4">
			  <div>
				<h5 class="text-danger fs-14 mb-0">{{ $pending['student'] }} <span class="text-danger" style="font-size: 12px;">(Pending)</span></h5>
				<a href="{{ route('admin.students.manage') }}" class="text-decoration-underline">See details</a>
			  </div>
			  <div class="avatar-sm flex-shrink-0">
				<span class="avatar-title bg-primary-subtle rounded fs-3">
				  <i class="la la-users text-primary"></i>
				</span>
			  </div>
			</div>
		  </div>
		</div>
	</div>
	
  </div>
  

  </div>

  <div class="row">
    <div class="col-xl-8">
        <div class="card mb-4">
            <div class="card-header border-0 align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Balance Review</h4>
            </div>
            <!-- end card header -->
            <div class="card-header p-0 border-0 bg-light-subtle">
                <div class="row g-0 text-center">
                    <div class="col-6 col-sm-3">
                        <div class="p-3 border border-dashed border-start-0">
                            <h5 class="mb-1">
                                <i class="la la-rupee-sign"></i>
                                <span class="counter-value" data-target="{{ $quick_stats['revenues'] }}">0</span>
                            </h5>
                            <p class="text-muted mb-0">Revenue</p>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-6 col-sm-3">
                        <div class="p-3 border border-dashed border-start-0">
                            <h5 class="mb-1">
                                <i class="la la-rupee-sign"></i>
                                <span class="counter-value" data-target="{{ number_format($quick_stats['profits'], 2) }}">0</span>
                            </h5>
                            <p class="text-muted mb-0">Profit</p>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-6 col-sm-3">
                        <div class="p-3 border border-dashed border-start-0">
                            <h5 class="mb-1">
                                <i class="la la-rupee-sign"></i>
                                <span class="counter-value" data-target="{{ $quick_stats['payouts'] }}">0</span>
                            </h5>
                            <p class="text-muted mb-0">Payout</p>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-6 col-sm-3">
                        <div class="p-3 border border-dashed border-start-0 border-end-0">
                            <h5 class="mb-1 text-success">
                                <span class="counter-value" data-target="{{ number_format($quick_stats['crs'], 2) }}">0</span>%
                            </h5>
                            <p class="text-muted mb-0">Conversion Ratio</p>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
            </div>
            <!-- end card header -->
            <div class="card-body p-0 pb-2">
                <div class="w-100">
                    <div class="chart">
                        <canvas id="balance-chart" class="chart-canvas" height="120"></canvas>
                    </div>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>

    <div class="col-xl-4">
        <!-- card -->
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Offer Visits by Device</h4>									
            </div>
            <!-- end card header -->
            <div class="card-body">
                <div class="chart">
                    <canvas id="offer-visits-device-chart" class="chart-canvas" height="300"></canvas>
                </div>
            </div>
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->


<div class="row my-4">
    <!-- Top Offers Card -->
    <div class="col-lg-6 col-md-6 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Top Offers</h4>
            </div>
            <!-- end card header -->
            <div class="card-body">
                <div class="table-responsive table-card">
                    <table class="table table-centered table-hover align-middle table-nowrap mb-0">
                        <thead class="text-muted table-light">
                            <tr>
                                <th>ID</th>
                                <th>Offer</th>
                                <th>Payout</th>
                                <th>Revenue</th>
                                <th>Profit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($top_offers as $offer)
                                <tr>
                                    <td>{{ $offer->oid }}</td>
                                    <td><a href="{{ route('admin.offers.show', $offer->oid) }}">{{ $offer->offer }}</a></td>
                                    <td>{{ $offer->payout }} {{ config('app.currency') }}</td>
                                    <td>{{ $offer->revenue }} {{ config('app.currency') }}</td>
                                    <td class="{{ $offer->profit < 0 ? 'text-danger' : 'text-success' }}">
                                        {{ $offer->profit }} {{ config('app.currency') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-lg">No data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- end table -->
            </div>
        </div>
    </div>
    <!-- .col -->

    <!-- Top Advertisers Card -->
    <div class="col-lg-6 col-md-6 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Top Advertisers</h4>
            </div>
            <!-- end card header -->
            <div class="card-body">
                <div class="table-responsive table-card">
                    <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                        <thead class="text-muted table-light">
                            <tr>
                                <th>ID</th>
                                <th>Advertiser</th>
                                <th>Payout</th>
                                <th>Revenue</th>
                                <th>Profit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($top_advertisers as $advertiser)
                                <tr>
                                    <td>{{ $advertiser->aid }}</td>
                                    <td>
                                        <a href="{{ route('admin.advertiser.show', $advertiser->aid) }}">
                                            {{ $advertiser->aname }}
                                        </a>
                                    </td>
                                    <td>{{ $advertiser->payout }} {{ config('app.currency') }}</td>
                                    <td>{{ $advertiser->revenue }} {{ config('app.currency') }}</td>
                                    <td class="{{ $advertiser->profit < 0 ? 'text-danger' : 'text-success' }}">
                                        {{ $advertiser->profit }} {{ config('app.currency') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-lg">No data</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <!-- end tbody -->
                    </table>
                    <!-- end table -->
                </div>
            </div>
        </div>
        <!-- .card -->
    </div>
    <!-- .col -->
</div>

<div class="row my-4">
    <div class="col-xl-6">
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
                                <th>Payout</th>
                                <th>Revenue</th>
                                <th>Profit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($top_countries as $country)
                                <tr>
                                    <td>{{ $country->Country }}</td>
                                    <td>{{ $country->Payout }}</td>
                                    <td>{{ $country->Revenue }}</td>
                                    <td>{{ $country->Profit }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-lg">No data</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <!-- end tbody -->
                    </table>
                    <!-- end table -->
                </div>
            </div>
        </div>
        <!-- .card -->
    </div>
    <!-- .col-xl-6 -->

    <div class="col-xl-6">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Top Students</h4>
            </div>
            <!-- end card header -->
            <div class="card-body">
                <div class="table-responsive table-card">
                    <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                        <thead class="text-muted table-light">
                            <tr>
                                <th>ID</th>
                                <th>Student</th>
                                <th>Payout</th>
                                <th>Revenue</th>
                                <th>Profit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($top_students as $student)
                                <tr>
                                    <td>{{ $student->id }}</td>
                                    <td>
                                        <a href="{{ route('admin.students.manage', $student->id) }}">{{ $student->name }}</a>
                                    </td>
                                    <td>{{ $student->payout }} {{ config('app.currency') }}</td>
                                    <td>{{ $student->revenue }} {{ config('app.currency') }}</td>
                                    <td class="{{ $student->profit < 0 ? 'text-danger' : 'text-success' }}">
                                        {{ $student->profit }} {{ config('app.currency') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-lg">No data</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <!-- end tbody -->
                    </table>
                    <!-- end table -->
                </div>
            </div>
        </div>
        <!-- .card -->
    </div>
    <!-- .col-xl-6 -->
</div>
<!-- end row -->


		

@endsection
@push('scripts')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://momentjs.com/downloads/moment.min.js"></script>
    <script src="{{ asset('assets/libs/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script>
      $(document).ready(function() {
          $('#daterange').daterangepicker({
              opens: 'left'
          });
      });
      
      function submit_form() {
          $('#performance-form').submit();
      }
  </script>
  <script>
    window.onload = function() {
      var ctx = document.getElementById("chart-bars").getContext("2d");

      new Chart(ctx, {
        type: "bar",
        data: {
          labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [{
            label: "Sales",
            tension: 0.4,
            borderWidth: 0,
            borderRadius: 4,
            borderSkipped: false,
            backgroundColor: "#fff",
            data: [450, 200, 100, 220, 500, 100, 400, 230, 500],
            maxBarThickness: 6
          }, ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false,
            }
          },
          interaction: {
            intersect: false,
            mode: 'index',
          },
          scales: {
            y: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false,
              },
              ticks: {
                suggestedMin: 0,
                suggestedMax: 500,
                beginAtZero: true,
                padding: 15,
                font: {
                  size: 14,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
                color: "#fff"
              },
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false
              },
              ticks: {
                display: false
              },
            },
          },
        },
      });


      var ctx2 = document.getElementById("chart-line").getContext("2d");

      var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

      gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
      gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

      var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

      gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
      gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

      new Chart(ctx2, {
        type: "line",
        data: {
          labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [{
              label: "Mobile apps",
              tension: 0.4,
              borderWidth: 0,
              pointRadius: 0,
              borderColor: "#cb0c9f",
              borderWidth: 3,
              backgroundColor: gradientStroke1,
              fill: true,
              data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
              maxBarThickness: 6

            },
            {
              label: "Websites",
              tension: 0.4,
              borderWidth: 0,
              pointRadius: 0,
              borderColor: "#3A416F",
              borderWidth: 3,
              backgroundColor: gradientStroke2,
              fill: true,
              data: [30, 90, 40, 140, 290, 290, 340, 230, 400],
              maxBarThickness: 6
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false,
            }
          },
          interaction: {
            intersect: false,
            mode: 'index',
          },
          scales: {
            y: {
              grid: {
                drawBorder: false,
                display: true,
                drawOnChartArea: true,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                padding: 10,
                color: '#b2b9bf',
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                color: '#b2b9bf',
                padding: 20,
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
          },
        },
      });
    }
  </script>

  <!-- Include your charting library script here (e.g., Chart.js) -->
<script>
    // Assuming you are using Chart.js
    var ctx = document.getElementById('balance-chart').getContext('2d');
    var balanceChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June'], // Replace with dynamic labels if needed
            datasets: [{
                label: 'Balance Over Time',
                data: [0, 0, 0, 0, 0, 0], 
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                fill: true,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<script>
    // Assuming you are using Chart.js
    var ctx = document.getElementById('offer-visits-device-chart').getContext('2d');
    var offerVisitsDeviceChart = new Chart(ctx, {
        type: 'bar', 
        data: {
            labels: ['Desktop', 'Mobile', 'Tablet'], 
            datasets: [{
                label: 'Visits',
                data: [0, 0, 0], // Replace with actual visit data
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endpush

