@extends('admin.layout.app')
@push('page_title')
    Dashboard
@endpush
@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-daterangepicker/daterangepicker.css') }}">
    <style>
        .state {
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
        <div class="col-lg-3">
            <div class="card mb-4 shadow-lg border-left-dark">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Approve /Deny Task') }}</h6>
                </div>
                <div class="card-body row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <p class="text-muted text-center text-bold">Students: <a
                                href="{{ route('admin.students.manage') }}?status=pending">{{ $pending['student'] }}</a>
                        </p>
                        <p class="text-muted text-center text-bold">Advertisers: <a
                                href="{{ route('admin.advertisers.manage') }}?status=pending">{{ $pending['advertiser'] }}</a>
                        </p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <p class="text-muted text-center text-bold">Offer Request: <a
                                href="{{ route('admin.offerApplication.index') }}?status=pending">{{ $pending['offer_application'] }}</a>
                        </p>
                        <p class="text-muted text-center text-bold">Offers: <a
                                href="{{ route('admin.offer.index') }}?status=pending">{{ $pending['offer'] }}</a></p>
                    </div>
                </div>
            </div>
            <div class="card mb-4 shadow-lg border-left-dark">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Quick Links') }}</h6>
                </div>
                <div class="card-body">
                    <div>
                        <ul>
                            <li>
                                <a href="{{ route('admin.students.create') }}?quickAdd=true">Add Student</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.advertisers.create') }}">Add Advertiser</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.offers.create') }}">Add Offer</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.employees.create') }}">Add Employee</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card mb-4 shadow-lg border-left-dark">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Featured Offers') }}</h6>
                </div>
                <div class="card-body">
                    <div>
                        <table class="table table-responsive" id="f_offers">

                            <tbody>
                                @foreach ($featured_offers as $key => $featured)
                                    <tr id="row{{ $featured->id }}">
                                        <td width="100%">
                                            ({{ $featured->id }})
                                            - {{ $featured->name }}
                                        </td>
                                        <td>
                                            <button type="button" class="close"
                                                onclick="_delete({{ $featured->id }})">
                                                <span>×</span>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <form>

                            <div class="form-group">
                                {{-- <input type="text" id="tags" class="form-control" placeholder="Search"> --}}
                                {{-- <input type="hidden" id="tag_id"/> --}}
                                <select name="tags" id="tags" style="width: 100%"></select>
                            </div>
                            <div class="from-group" style="margin-top: 10px;">
                                <button class="btn btn-success btn-sm" onclick="_save(); return false;">Save <i
                                        class="fa fa-spinner fa-spin" id="ao-loader" style="display: none;"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card mb-4 shadow-lg border-left-dark">
                <div class="card-header" style="height: 48px">
                    <div class="float-right">
                        <form action="{{ route('admin.dashboard') }}" method="GET" id="performance-form">
                            <div class="input-group form-group">
                                {{-- <a href="javascript:void(0)" class="input-group-addon" id="daterangebtn">
                                <i class="fa fa-calendar"></i>
                            </a> --}}
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
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Quick Overview') }} </h6>

                </div>
                <div class="card-body">

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
                                <div class="state-title">Revenue</div>
                                <div class="state-body">${{ number_format($quick_stats['revenues'], 2) }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                            <div class="state">
                                <div class="state-title">Payout</div>
                                <div class="state-body">${{ number_format($quick_stats['payouts'], 2) }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                            <div class="state">
                                <div class="state-title">Profit</div>
                                <div class="state-body">${{ number_format($quick_stats['profits'], 2) }}</div>
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
                                    <th>Revenue</th>
                                    <th>Profit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($top_students as $student)
                                    <tr>
                                        <td>{{ $student->aid }}</td>
                                        <td><a
                                                href="{{ route('admin.students.manage', $student->aid) }}">{{ $student->aname }}</a>
                                        </td>
                                        <td>{{ $student->payout }} {{ config('app.currency') }}</td>
                                        <td>{{ $student->revenue }} {{ config('app.currency') }}</td>
                                        <td>{{ $student->profit }} {{ config('app.currency') }}</td>
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
                                    <th>Revenue</th>
                                    <th>Profit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($top_offers as $offer)
                                    <tr>
                                        <td>{{ $offer->oid }}</td>
                                        <td><a
                                                href="{{ route('admin.offer.show', $offer->oid) }}">{{ $offer->offer }}</a>
                                        </td>
                                        <td>{{ $offer->payout }} {{ config('app.currency') }}</td>
                                        <td>{{ $offer->revenue }} {{ config('app.currency') }}</td>
                                        <td>{{ $offer->profit }} {{ config('app.currency') }}</td>
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
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Top Advertisers') }}</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" width="100%" cellspacing="0">
                            <thead>
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
                                        <td><a
                                                href="{{ route('admin.advertisers.show', $advertiser->aid) }}">{{ $advertiser->aname }}</a>
                                        </td>
                                        <td>{{ $advertiser->payout }}</td>
                                        <td>{{ $advertiser->revenue }}</td>
                                        <td>{{ $advertiser->profit }}</td>
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
                                    <th>Revenue</th>
                                    <th>Profit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($top_countries as $country)
                                    <tr>
                                        <td>{{ $country->Country }}</td>
                                        {{-- <td>{{ $country->Clicks }}</td>
                                        <td>{{ $country->Leads }}</td> --}}
                                        <td>{{ $country->Payout }}</td>
                                        <td>{{ $country->Revenue }}</td>
                                        <td>{{ $country->Profit }}</td>
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
            var data_revenue = {{ $chart['revenue'] }};
            var data_profit = {{ $chart['profit'] }};
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
                }, {
                    name: 'Revenue',
                    data: data_revenue
                }, {
                    name: 'Profit',
                    data: data_profit
                }]
            });
        })
    </script>

    <script>
        function _save() {
            var tag = $('#tags').select2('data');
            if (tag.length === 0) {
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'You did not select any item'
                });
                return;
            }
            $('#ao-loader').show();
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.featuredOfferUpdate') }}',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: tag[0].id,
                    action: 'u'
                },
                success: function(data) {
                    $('#f_offers').append('<tr id="row' + tag[0].id + '"><td width="100%">' + tag[0].text +
                        '</td><td><button type="button" class="close"><span onclick="_delete(' + tag[0].id +
                        ')">x</span></button></td><tr>')
                    $('#tags').val('');
                    Swal.fire({
                        position: 'center',
                        type: 'success',
                        title: 'Feature offer added',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    $('#ao-loader').hide();
                }
            });
        }

        function _delete(rowid) {
            Swal.fire({
                title: 'Confirmation!',
                text: "Are you want to remove this offer from featured",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('admin.featuredOfferUpdate') }}',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            id: rowid,
                            action: 'd'
                        },
                        success: function(data) {
                            $('#row' + rowid).remove();
                            console.log($('#row' + rowid));
                            Swal.fire({
                                position: 'center',
                                type: 'success',
                                title: 'Feature offer removed',
                                showConfirmButton: false,
                                timer: 2000
                            })
                        }
                    });

                }
            })


            // $.ajax({
            //     type: 'POST',
            //     url: '{{ route('admin.featuredOfferUpdate') }}',
            //     data: {
            //         _token: $('meta[name="csrf-token"]').attr('content'),
            //         id: rowid,
            //         action: 'd'
            //     },
            //     success: function(data) {
            //         $('#row' + rowid).remove();
            //         console.log($('#row' + rowid));
            //         Swal.fire({
            //             position: 'center',
            //             icon: 'success',
            //             title: 'Feature offer removed',
            //             showConfirmButton: false,
            //             timer: 2000
            //         })
            //     }
            // });
        }
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
