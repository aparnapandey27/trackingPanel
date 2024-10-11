{{-- @extends('student.layout.app')
@section('title', 'Student Dashboard')
@section('content')

<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <h1>Student's Dashboard</h1>
</div>

@endsection --}}


@extends('student.layout.app')
@section('title', 'Dashboard')
@section('content')
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/flag-icons/css/flag-icon.min.css?v=52475656') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
@endpush

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
                                    <form action="{{ route('student.dashboard') }}" method="GET" id="performance-form">
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
                    </div>
                    <!--end row-->

                    <div class="row">
                        <div class="col-xl-12 mb-4">
                            <div class="card crm-widget">
                                <div class="card-body p-0">
                                    <div class="row row-cols-xxl-4 row-cols-md-3 row-cols-1 g-0">
                                        <div class="col">
                                            <div class="py-4 px-3">
                                                <h5 class="text-muted text-uppercase fs-13">Click </h5>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class=" mdi mdi-cursor-default-click-outline display-6 text-muted"></i>
                                                       
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h2 class="mb-0"><span class="counter-value" data-target="{{ $quick_stats['clicks'] }}">0</span></h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end col -->
                                        <div class="col">
                                            <div class="mt-3 mt-md-0 py-4 px-3">
                                                <h5 class="text-muted text-uppercase fs-13">Conversion </h5>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="ri-pulse-line display-6 text-muted"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h2 class="mb-0"><span class="counter-value" data-target="{{ $quick_stats['conversions'] }}">0</span></h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end col -->
                                        <div class="col">
                                            <div class="mt-4 mt-md-0 py-4 px-3">
                                                <h5 class="text-muted text-uppercase fs-13">Epc</h5>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="ri-hand-coin-line display-6 text-muted"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h2 class="mb-0"><span class="counter-value" data-target="{{number_format($quick_stats['epcs'],2) }}">0</span></h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end col -->
                                        <div class="col">
                                            <div class="mt-3 mt-lg-0 py-4 px-3">
                                                <h5 class="text-muted text-uppercase fs-13">Earning</h5>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="ri-exchange-dollar-line display-6 text-muted"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h2 class="mb-0">$<span class="counter-value" data-target="{{($quick_stats['earnings']) }}">0</span></h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end col -->
                                      <!-- end col -->
                                    </div><!-- end row -->
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div> <!-- end row-->

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-header border-0 align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Revenue</h4>
                                 
                                </div><!-- end card header -->

                                <div class="card-header p-0 border-0 bg-light-subtle">
                                    <div class="row g-0 text-center">
                                        <div class="col-6 col-sm-3">
                                            <div class="p-3 border border-dashed border-start-0">
                                                <h5 class="mb-1"><span class="counter-value" data-target="{{ $quick_stats['clicks'] }}">0</span></h5>
                                                <p class="text-muted mb-0">Clicks</p>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-6 col-sm-3">
                                            <div class="p-3 border border-dashed border-start-0">
                                                <h5 class="mb-1">$<span class="counter-value" data-target="{{ $quick_stats['conversions'] }}">0</span></h5>
                                                <p class="text-muted mb-0">Conversion</p>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-6 col-sm-3">
                                            <div class="p-3 border border-dashed border-start-0">
                                                <h5 class="mb-1"><span class="counter-value" data-target="{{number_format($quick_stats['epcs'],2) }}">0</span></h5>
                                                <p class="text-muted mb-0">Epc</p>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-6 col-sm-3">
                                            <div class="p-3 border border-dashed border-start-0 border-end-0">
                                                <h5 class="mb-1 text-success"><span class="counter-value" data-target="{{($quick_stats['earnings']) }}">0</span></h5>
                                                <p class="text-muted mb-0">Earning</p>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-body p-0 pb-2">
                                    <div class="w-100">
                                        <div id="customer_impression_charts" data-colors='["--vz-primary", "--vz-success", "--vz-danger"]' class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                        
                        <!-- end col -->
                    </div>

                   <!-- end row-->

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card mb-4 shadow-lg">
                                <div class="card-header">
                                    <h6 class="m-0 text-primary font-weight-bold">{{ __('Recently Added') }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead class="text-muted table-light">
                                                <tr>
                                                    <th>Preview</th>
                                                    <th>Offer</th>
                                                    <th>Payout</th>
                                                    <th>Category</th>
                                                    <th>Countries</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($recently_added_offers as $recently_added_offer)
                                                    <tr>
                                                        <td>
                                                            <img src="{{ $recently_added_offer->thumbnail != null? asset("storage/offers/$recently_added_offer->thumbnail"): 'https://via.placeholder.com/60' }}"
                                                                style="height: 60px; width:100px" alt="" class="img-fluid">
                                                        </td>
                                                        <td>
                                                            {{ $recently_added_offer->id }} - {{ $recently_added_offer->name }}
                                                        </td>
                                                        <td>
                                                            @if ($recently_added_offer->offer_model == 'RevShare')
                                                                {{ $recently_added_offer->percent_payout }} %
                                                            @elseif ($recently_added_offer->offer_model == 'Hybrid')
                                                                {{ $recently_added_offer->default_payout }}
                                                                {{ $recently_added_offer->currency }}
                                                                +
                                                                {{ $recently_added_offer->percent_payout }} %
                                                            @elseif ($recently_added_offer->offer_model == 'Dynamic')
                                                                Dynamic
                                                            @else
                                                                {{ $recently_added_offer->default_payout }}
                                                                {{ $recently_added_offer->currency }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ $recently_added_offer->category_id != null ? $recently_added_offer->category->name : '' }}
                                                        </td>
                                                        <td>
                                                            @if ($recently_added_offer->countries->count() < 1)
                                                                <i class="flag-icon flag-icon-ww"></i> World Wide
                                                            @elseif ($recently_added_offer->countries->count() < 5)
                                                                @foreach ($recently_added_offer->countries as $country)
                                                                    <i class="flag-icon flag-icon-{{ Str::lower($country->code) }}"></i>
                                                                    {{ $country->code }},
                                                                @endforeach
                                                            @else
                                                                {{ $recently_added_offer->countries->count() }} Countries
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card mb-4 shadow-lg">
                                <div class="card-header">
                                    <h6 class="m-0 text-primary font-weight-bold">{{ __('Recently Expired') }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead class="text-muted table-light">
                                                <tr>
                                                    <th>Preview</th>
                                                    <th>Offer</th>
                                                    <th>Payout</th>
                                                    <th>Category</th>
                                                    <th>Countries</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($recently_expired_offers as $recently_expired_offer)
                                                    <tr>
                                                        <td>
                                                            <img src="{{ $recently_expired_offer->thumbnail != null? asset("storage/offers/$recently_expired_offer->thumbnail"): 'https://via.placeholder.com/60' }}"
                                                                style="height: 60px; width:100px" alt="" class="img-fluid">
                                                        </td>
                                                        <td>
                                                            {{ $recently_expired_offer->id }} - {{ $recently_aexpired_offer->name }}
                                                        </td>
                                                        <td>
                                                            @if ($recently_expired_offer->offer_model == 'RevShare')
                                                                {{ $recently_expired_offer->percent_payout }} %
                                                            @elseif ($recently_aexpiredoffer->offer_model == 'Hybrid')
                                                                {{ $recently_expired_offer->default_payout }}
                                                                {{ $recently_expired_offer->currency }}
                                                                +
                                                                {{ $recently_expired_offer->percent_payout }} %
                                                            @elseif ($recently_aexpiredoffer->offer_model == 'Dynamic')
                                                                Dynamic
                                                            @else
                                                                {{ $recently_expired_offer->default_payout }}
                                                                {{ $recently_expired_offer->currency }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ $recently_expired_offer->category_id != null ? $recently_expired_offer->category->name : '' }}
                                                        </td>
                                                        <td>
                                                            @if ($recently_expired_offer->countries->count() < 1)
                                                                <i class="flag-icon flag-icon-ww"></i> World Wide
                                                            @elseif ($recently_expired_offer->countries->count() < 5)
                                                                @foreach ($recently_expired_offer->countries as $country)
                                                                    <i class="flag-icon flag-icon-{{ Str::lower($country->code) }}"></i>
                                                                    {{ $country->code }},
                                                                @endforeach
                                                            @else
                                                                {{ $recently_expired_offer->countries->count() }} Countries
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">No Data</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                       
                    </div> <!-- end row-->

                </div> <!-- end .h-100-->

            </div> <!-- end col -->

             <!-- end col -->
        </div>
        

    </div>
    <!-- container-fluid -->
</div>
@endsection
@push('scripts')

<script src="{{asset('assets/js/pages/dashboard-ecommerce.init.js')}}"></script>

    <script type="text/javascript" src="{{ asset('assets/libs/moment/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/libs/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <!-- SweetAlert2-->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets/libs/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/libs/owlcarousel/dist/owl.carousel.min.js') }}"></script>
    <script>
     var data_click = {{ $chart['click'] }};
     var data_leads = {{ $chart['lead'] }};
     var data_payout = {{ $chart['earn'] }};
     var data_date = <?php echo $chart['date']; ?>;        
var linechartcustomerColors = getChartColorsArray("customer_impression_charts");
if (linechartcustomerColors) {
    var options = {
        series: [{
                name: "clicks",
                type: "area",
                data:  data_click
            },
            {
                name: "Conversion",
                type: "bar",
                data: data_leads
            },
            {
                name: "Earning",
                type: "line",
                data: data_payout 
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
            curve: "straight",
            dashArray: [0, 0, 8],
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
            categories: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
            ],
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
                    show: true,
                },
            },
            yaxis: {
                lines: {
                    show: false,
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
                barHeight: "70%",
            },
        },
        colors: linechartcustomerColors,
        tooltip: {
            shared: true,
            y: [{
                    formatter: function (y) {
                        if (typeof y !== "undefined") {
                            return y.toFixed(0);
                        }
                        return y;
                    },
                },
                {
                    formatter: function (y) {
                        if (typeof y !== "undefined") {
                            return "" + y.toFixed(2) + "";
                        }
                        return y;
                    },
                },
                {
                    formatter: function (y) {
                        if (typeof y !== "undefined") {
                            return y.toFixed(0) + " ₹";
                        }
                        return y;
                    },
                },
            ],
        },
    };
    var chart = new ApexCharts(
        document.querySelector("#customer_impression_charts"),
        options
    );
    chart.render();
}

</script>
<script>
    var chartDonutBasicColors = getChartColorsArray("store-visits-source");
if (chartDonutBasicColors) {
    var options = {
        series: [44, 55, 41, 17, 15],
        labels: ["Direct", "Social", "Email", "Other", "Referrals"],
        chart: {
            height: 333,
            type: "donut",
        },
        legend: {
            position: "bottom",
        },
        stroke: {
            show: false
        },
        dataLabels: {
            dropShadow: {
                enabled: false,
            },
        },
        colors: chartDonutBasicColors,
    };

    var chart = new ApexCharts(
        document.querySelector("#store-visits-source"),
        options
    );
    chart.render();
}    
</script>
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



        /**
         * Created by ouarka.dev@gmail.com
         * */
        function submit_form() {
            document.getElementById('performance-form').submit();
        }
        var owl = $('.owl-carousel');
        owl.owlCarousel({
            items: 1,
            loop: true,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true
        });
    </script>

    <script>
        $(function() {
            var data_click = {{ $chart['click'] }};
            var data_leads = {{ $chart['lead'] }};
            var data_payout = {{ $chart['earn'] }};
            var data_date = <?php echo $chart['date']; ?>;
            var options = {
                series: [{
                    name: 'Clicks',
                    data: data_click
                }, {
                    name: 'Conversions',
                    data: data_leads
                }, {
                    name: 'Earnings',
                    data: data_payout
                }],
                chart: {
                    height: 380,
                    type: 'area'
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    type: 'date',
                    categories: data_date
                },
                tooltip: {
                    x: {
                        format: 'dd/MM/yy'
                    },
                },
            };
    </script>

@endpush