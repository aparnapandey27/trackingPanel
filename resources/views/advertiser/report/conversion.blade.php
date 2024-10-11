@extends('advertiser.layout.app')
@section('title', 'Conversion')
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-daterangepicker/daterangepicker.css') }}">
@endpush
@section('content')

<div class="page-content">
    <div class="container-fluid"> 

    <form action="{{ route('advertiser.report.conversion') }}" method="GET" id="report-form">

        {{-- {{ csrf_field() }} --}}

        <div class="card mb-4 shadow-lg border-left-dark">
            <div class="card-header">
                <h6 class="m-0 text-primary font-weight-bold">Report Options</h6>
            </div>
            <div class="card-body">
                <div class="row column-row">
                    <div class="col-md-1">
                        <div class="form-group-title"><label>Indicator</label></div>
                    </div>

                    <div class="col-md-11">
                        <div class="row">

                            <div class="form-group-column col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                <input type="checkbox" id="offer_id" name="data[offer_id]" value="1"
                                    <?= in_array('Offer ID', $headers) ? "checked='checked'" : '' ?>>
                                <label for="offer_id">Offer ID</label>

                            </div>
                            <div class="form-group-column col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                <input type="checkbox" id="offer" name="data[offer]" value="1"
                                    <?= in_array('Offer', $headers) ? "checked='checked'" : '' ?>>
                                <label for="offer">Offer</label>
                            </div>
                            <div class="form-group-column col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                <input type="checkbox" id="country" name="data[country]" value="1"
                                    <?= in_array('Country', $headers) ? "checked='checked'" : '' ?>>
                                <label for="country">Country</label>
                            </div>
                            <div class="form-group-column col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                <input type="checkbox" id="category" name="data[category]" value="1"
                                    <?= in_array('Category', $headers) ? "checked='checked'" : '' ?>>
                                <label for="category">Category</label>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Div closed -->
                <br />

                <div class="row column-row">
                    <div class="col-md-1">
                        <div class="form-group-title"><label>Statistics</label></div>
                    </div>

                    <div class="col-md-11">
                        <div class="row">
                            <div class="form-group-column col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                <input type="checkbox" id="goal" name="data[goal]" value="1"
                                    <?= in_array('Event Name', $headers) ? "checked='checked'" : '' ?>>
                                <label for="goal">Event Name</label>
                            </div>
                            <div class="form-group-column col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                <input type="checkbox" id="statistics_currency" name="statistics[currency]" value="1"
                                    <?= in_array('Currency', $headers) ? "checked='checked'" : '' ?>>
                                <label for="statistics_currency">Currency</label>
                            </div>
                            <div class="form-group-column col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                <input type="checkbox" id="statistics_cost" name="statistics[cost]" value="1"
                                    <?= in_array('Cost', $headers) ? "checked='checked'" : '' ?>>
                                <label for="statistics_cost">Cost</label>
                            </div>
                            <div class="form-group-column col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                <input type="checkbox" id="statistics_transaction_id" name="statistics[transaction_id]"
                                    value="1" <?= in_array('Transaction ID', $headers) ? "checked='checked'" : '' ?>>
                                <label for="statistics_transaction_id">Transaction ID</label>
                            </div>
                            <div class="form-group-column col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                <input type="checkbox" id="statistics_session" name="statistics[session_ip]" value="1"
                                    <?= in_array('Session IP', $headers) ? "checked='checked'" : '' ?>>
                                <label for="statistics_session">Session IP</label>
                            </div>
                            <div class="form-group-column col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                <input type="checkbox" id="statistics_conversion_ip" name="statistics[conversion_ip]"
                                    value="1" <?= in_array('Conversion IP', $headers) ? "checked='checked'" : '' ?>>
                                <label for="statistics_conversion_ip">Conversion IP</label>
                            </div>
                            <div class="form-group-column col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                <input type="checkbox" id="device" name="data[device]" value="1"
                                    <?= in_array('Device', $headers) ? "checked='checked'" : '' ?>>
                                <label for="device">Device</label>
                            </div>
                            <div class="form-group-column col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                <input type="checkbox" id="os" name="data[os]" value="1"
                                    <?= in_array('Operating System', $headers) ? "checked='checked'" : '' ?>>
                                <label for="os">Operating System</label>
                            </div>
                            <div class="form-group-column col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                <input type="checkbox" id="browser" name="data[browser]" value="1"
                                    <?= in_array('Browser', $headers) ? "checked='checked'" : '' ?>>
                                <label for="browser">Browser</label>
                            </div>
                            <div class="form-group-column col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                <input type="checkbox" id="subid1" name="data[subid1]" value="1"
                                    <?= in_array('Sub ID 1', $headers) ? "checked='checked'" : '' ?>>
                                <label for="subid1">Sub ID 1</label>
                            </div>
                            <div class="form-group-column col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                <input type="checkbox" id="subid2" name="data[subid2]" value="1"
                                    <?= in_array('Sub ID 2', $headers) ? "checked='checked'" : '' ?>>
                                <label for="subid2">Sub ID 2</label>
                            </div>
                            <div class="form-group-column col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                <input type="checkbox" id="subid3" name="data[subid3]" value="1"
                                    <?= in_array('Sub ID 3', $headers) ? "checked='checked'" : '' ?>>
                                <label for="subid3">Sub ID 3</label>
                            </div>
                            <div class="form-group-column col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                <input type="checkbox" id="subid4" name="data[subid4]" value="1"
                                    <?= in_array('Sub ID 4', $headers) ? "checked='checked'" : '' ?>>
                                <label for="subid4">Sub ID 4</label>
                            </div>
                            <div class="form-group-column col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                <input type="checkbox" id="subid5" name="data[subid5]" value="1"
                                    <?= in_array('Sub ID 5', $headers) ? "checked='checked'" : '' ?>>
                                <label for="subid5">Sub ID 5</label>
                            </div>

                        </div>
                    </div>

                </div>
            </div>



        </div>

        <!-- /.card-header -->
        <div class="card-card">
            <div class="form-inline align-items-center justify-content-between">
                <div class="form-group">

                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </span>
                        <input type="text" style="width: 200px" class="form-control" id="daterange" name="daterange"
                            value="">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-success" onclick="submit_form()">
                                <i class="fa fa-play" aria-hidden="true"></i> Generate Report
                            </button>
                        </span>
                    </div>

                    <input type="hidden" id="report_dr" value="">
                    <input type="hidden" name="download" id="download" value="false">
                    <input type="hidden" name="download_format" id="download_format" value="csv">
                    <input type="hidden" name="download_title" id="download_title" value="Custom Report">
                    <input type="hidden" name="view" id="view" value="">

                    <input type="hidden" name="sortby" id="sortby" value="">
                    <input type="hidden" name="order" id="order" value="">

                </div>

            </div>
        </div>

        <div class="card" style="margin-top: 30px;">
            <div class="row">
                {{-- @isset($sql)
                    <div style="padding: 30px; color: red;  font-size: 18px; font-weight: bold;">
                        {{ $sql }}
                    </div>
                    @endif --}}
                <div class="col-md-12">
                    @if (isset($records))
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="table table-dark table-striped">
                                    <tr>
                                        @foreach ($headers as $header)
                                            <th><strong>{{ $header }}</strong></th>
                                        @endforeach
                                    </tr>
                                    <thead>
                                        @foreach ($records as $record)
                                            <tr>
                                                @foreach (get_object_vars($record) as $key)
                                                    <td>{{ $key }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ asset('assets/libs/moment/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/libs/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
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
            "opens": "right",
            "drops": "down"
        }, function(start, end, label) {
            // console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });


        function submit_form() {
            document.getElementById('download').value = false;
            document.getElementById('report-form').submit();
        }
    </script>
@endpush
