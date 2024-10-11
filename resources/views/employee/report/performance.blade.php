@extends('employee.layout.app')
@section('title', 'Performance')
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-daterangepicker/daterangepicker.css') }}">
@endpush

@section('content')
<div class="page-content">
	<div class="container-fluid">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">{{__('Performance')}}</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">{{__('Report')}}</a>
                    </li>
                    <li class="breadcrumb-item active">{{__('Performance')}}</li>
                </ol>
            </div>
        </div>
        <form action="{{ route('employee.report.performance') }}" method="GET" id="report-form">

            {{-- {{ csrf_field() }} --}}
            <!-- /.card-header -->
            <div class="card mb-4 shadow-lg">
                <div class="card-header d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#filterOptions">
                    <h6 class="m-0 text-primary font-weight-bold">Filter Options</h6>
                    <i class="mdi mdi-align-vertical-distribute"></i>
                </div>
                <div id="filterOptions" class="collapse">
                    <div class="card-body">
                        <div class="row column-row mb-5">
                            <div class="col-md-1">
                                <div class="form-group-title">
                                    <label>Indicator</label>
                                </div>
                            </div>
                        <div class="col-md-11">
                            <div class="row">
                                <div class="form-group-column col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                    <input type="checkbox" id="student_id" name="data[student_id]" value="1"
                                        <?= in_array('Student ID', $headers) ? "checked='checked'" : '' ?>>
                                    <label for="student_id">Student ID</label>
                                </div>
                                <div class="form-group-column col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                    <input type="checkbox" id="student" name="data[student]" value="1"
                                        <?= in_array('Student', $headers) ? "checked='checked'" : '' ?>>
                                    <label for="student">Publisher</label>

                                </div>

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

                    <!-- Div closed -->
                    <br />

                    <div class="row column-row">
                        <div class="col-md-1">
                            <div class="form-group-title"><label>Statistics</label></div>
                        </div>

                        <div class="col-md-11">
                            <div class="row">
                                <div class="form-group-column col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                    <input type="checkbox" id="statistics_clicks" name="statistics[clicks]" value="1"
                                        <?= in_array('Clicks', $headers) ? "checked='checked'" : '' ?>>
                                    <label for="statistics_clicks">Clicks</label>
                                </div>
                                <div class="form-group-column col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                    <input type="checkbox" id="statistics_conversions" name="statistics[conversions]" value="1"
                                        <?= in_array('Conversions', $headers) ? "checked='checked'" : '' ?>>
                                    <label for="statistics_conversions">Conversions</label>
                                </div>
                                <div class="form-group-column col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                    <input type="checkbox" id="statistics_currency" name="statistics[currency]" value="1"
                                        <?= in_array('Currency', $headers) ? "checked='checked'" : '' ?>>
                                    <label for="statistics_currency">Currency</label>
                                </div>
                                <div class="form-group-column col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                    <input type="checkbox" id="statistics_payout" name="statistics[payout]" value="1"
                                        <?= in_array('Payout', $headers) ? "checked='checked'" : '' ?>>
                                    <label for="statistics_payout">Payout</label>
                                </div>
                                
                            
                                <div class="form-group-column col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                    <input type="checkbox" id="calculations_cr" name="calculations[cr]" value="1"
                                        <?= in_array('CR', $headers) ? "checked='checked'" : '' ?>>
                                    <label for="calculations_cr">CR</label>
                                </div>
                                <div class="form-group-column col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                    <input type="checkbox" id="calculations_cpc" name="calculations[cpc]" value="1"
                                        <?= in_array('CPC', $headers) ? "checked='checked'" : '' ?>>
                                    <label for="calculations_cpc">CPC</label>
                                </div>
                                <div class="form-group-column col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                    <input type="checkbox" id="calculations_rpc" name="calculations[rpc]" value="1"
                                        <?= in_array('RPC', $headers) ? "checked='checked'" : '' ?>>
                                    <label for="calculations_rpc">RPC</label>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

                </div>

            </div>
            <div class="row g-3 mb-4 align-items-center">
                <input type="hidden" id="report_dr" value="">
                <input type="hidden" name="download" id="download" value="false">
                <input type="hidden" name="download_format" id="download_format" value="csv">
                <input type="hidden" name="download_title" id="download_title" value="Custom Report">
                <input type="hidden" name="view" id="view" value="">

                <input type="hidden" name="sortby" id="sortby" value="">
                <input type="hidden" name="order" id="order" value="">
				<div class="col-xl-10">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input type="text" class="form-control border-0 dash-filter-picker shadow" id="daterange" name="daterange">
                                <div class="input-group-text bg-primary border-primary text-white" id="daterange" name="daterange">
                                    <i class="ri-calendar-2-line"></i>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-primary" onclick="submit_form()">
                                <i class="ri-play-circle-line align-middle me-1"></i>{{ __('Generate Report') }} 
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2">
                    <button type="button" class="btn btn-success" onclick="downloadReport()">
                        <i class="ri-download-2-fill" aria-hidden="true"></i> Download Report
                    </button>
                </div>											
		    </div>

            

            <div class="card shadow-lg border-left-dark">
                <div class="card-header">
                    <h6 class="card-title mb-0 flex-grow-1 text-primary">{{ __('Performance') }}</h6>
                </div>
                <div class="card-body">
                        @if (isset($records))
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>S.No</th>
                                            @foreach ($headers as $header)
                                                <th><strong>{{ $header }}</strong></th>
                                            @endforeach
                                        </tr>
                                        <thead>
                                            @foreach ($records as $record)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
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
        </form>

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

            function export_report() {
                var reports = [];
                var headers = [];

                $('#report tr').each(function() {
                    var th = $(this).find('th');
                    if (th.length > 0) {
                        th.each(function() {
                            headers.push($(this).text());
                        })
                        return false;
                    }
                });

                $('#report tr').each(function() {
                    var row = [];
                    var td = $(this).find('td');
                    if (td.length > 0) {
                        td.each(function() {
                            row.push($(this).text());
                        });
                        reports.push(row);
                    }
                });
                if (headers.length > 0 && reports.length > 0) {
                    var data = [];
                    data.push(headers);
                    reports.forEach(function(el) {
                        data.push(el);
                    });
                    var content = "data:text/csv;charset=utf-8,";
                    data.forEach(function(row, index) {
                        content += row.join(",") + "\n";
                    });
                    var csv = encodeURI(content);
                    var filename = "export.csv";

                    link = document.createElement('a');
                    link.setAttribute('href', csv);
                    link.setAttribute('download', filename);
                    link.click();

                }



            }
        </script>
        <script>
        function downloadReport() {
            // Set the 'download' input field to 'true'
            document.getElementById('download').value = true;
            document.getElementById('report-form').submit();
        }
    </script>
    @endpush
