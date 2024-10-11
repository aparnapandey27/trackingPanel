@extends('employee.layout.app')
@push('page_title')
    Dashboard
@endpush
@push('css')
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
    <!-- Performance --->
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4 shadow-lg border-left-dark">
                <div class="card-header">
                    <div class="float-right">
                        <form action="{{ route('employee.dashboard') }}" method="GET" id="performance-form">

                            <div class="input-group form-group">
                                {{-- <a href="javascript:void(0)" class="input-group-addon" id="daterangebtn">
                                <i class="fa fa-calendar"></i>
                            </a> --}}
                                <input type="text" style="width: 200px; float: right;" class="form-control" id="daterange"
                                    name="daterange" value="">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-success" onclick="submit_form()">
                                        <i class="fa fa-play" aria-hidden="true"></i> Generate Report
                                    </button>
                                </span>
                            </div>
                        </form>

                    </div>
                    <h6 class="m-0 text-primary font-weight-bold">Quick Stats: </h6>
                    <span>TimeFrame : {{ $from }} - {{ $to }}</span>
                </div>
                <div class="card-body">
                    {{-- {{ $sql }} --}}
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                            <div class="state">
                                <div class="state-title">Click</div>
                                <div class="state-body">{{ $quick_stats['clicks'] }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                            <div class="state">
                                <div class="state-title">Conversion</div>
                                <div class="state-body">{{ $quick_stats['conversions'] }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                            <div class="state">
                                <div class="state-title">PPC</div>
                                <div class="state-body">${{ number_format($quick_stats['ppcs'], 2) }}</div>
                            </div>
                        </div>
                       
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                            <div class="state">
                                <div class="state-title">Payout</div>
                                <div class="state-body">${{ number_format($quick_stats['payouts'], 2) }}</div>
                            </div>
                        </div>
                       
                    </div>
                    <div id="highcharts"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Offer/Student/Advertiser/Country-->
    <div class="row">
        <div class="col-lg-6">
            <div class="card mb-4 shadow-lg border-left-dark">
                <div class="card-header">
                    <h6 class="m-0 text-primary font-weight-bold">Approve /Deny Task</h6>
                </div>
                <div class="card-body row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <p class="text-muted text-center text-bold">Students: <a
                                href="{{ route('employee.student.index') }}?status=pending">{{ $pending['student'] }}</a>
                        </p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <p class="text-muted text-center text-bold">Offer Request: <a
                                href="{{ route('admin.offerApplication.index') }}?status=pending">{{ $pending['offer_application'] }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="card mb-4 shadow-lg border-left-dark">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Top Students') }}</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" width="100%" cellspacing="0">
                            <thead>
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
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12">
            <div class="card mb-4 shadow-lg border-left-dark">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Top Offers') }}</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" width="100%" cellspacing="0">
                            <thead>
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
      
        <div class="col-lg-6 col-md-12">
            <div class="card mb-4 shadow-lg border-left-dark">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Top Countries') }}</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" width="100%" cellspacing="0">
                            <thead>
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
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
    @endsection
    @push('js')
        <script src="{{ asset('assets/libs/highchartsjs/highcharts.js') }}"></script>
        <!-- SweetAlert2-->
        <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('assets/libs/moment/moment.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
        <!-- Select2 -->
        <script src="{{ asset('assets/libs/select2/select2.full.min.js') }}"></script>
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
            $(function() {

                var data_click = {{ $chart['click'] }};
                var data_lead = {{ $chart['lead'] }};
                var data_payout = {{ $chart['payout'] }};
                
                var data_date = <?php echo $chart['date']; ?>;
                $('#highcharts').highcharts({
                    chart: {
                        type: 'spline'
                    },
                    title: {
                        text: 'Performance'
                    },
                    credits: {
                        enabled: false
                    },
                    xAxis: {
                        categories: data_date
                    },
                    yAxis: {
                        title: {
                            text: 'Rate'
                        }
                    },
                    tooltip: {
                        shared: true,
                        valueSuffix: ''
                    },
                    series: [{
                        name: 'Click',
                        data: data_click
                    }, {
                        name: 'Conversion',
                        data: data_lead
                    }, {
                        name: 'Payout',
                        data: data_payout
                    }]
                });
            })
        </script>

        <script>
            $(document).ready(function() {
                $('#tags').select2({
                    ajax: {
                        url: '{{ route('admin.getFeaturedOffers') }}',
                        dataType: 'json',
                        data: function(params) {
                            return {
                                search: params.term
                            }
                        },
                        processResults: function(response) {
                            return {
                                results: response
                            }
                        },
                        cache: true,
                        width: 'resolve'

                    }
                }); // end $
            });
        </script>
    @endpush
