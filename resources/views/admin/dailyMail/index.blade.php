@extends('admin.layout.app')
@section('title', 'Send Report')
@push('style')    
    <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-daterangepicker/daterangepicker.css') }}">    
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
@endpush

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <form method="POST" action="{{ route('admin.send.daily') }}">
            @csrf
            <div class="card mb-4 shadow-lg border-left-dark">
            <div class="card-header">
                <div class="row g-2 align-items-center">
                    <div class="col-sm-4">
                        <h6 class="card-title mb-0 flex-grow-1 text-primary">Send Report</h6>
                    </div>
                    <div class="col-sm-auto ms-auto">
                        <div class="list-grid-nav hstack gap-1">                                        
                            <div class="input-group">
                                <input type="text" class="form-control border-1 dash-filter-picker shadow" id="daterange" name="daterange">
                                <div class="input-group-text bg-primary border-primary text-white">
                                    <i class="ri-calendar-2-line"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group-column col-lg-6 col-md-6 col-sm-12">
                                <label for="student">Student</label>
                                <select class="form-control student " multiple id="student" name="students[]"></select>
                            </div>
                            <div class="form-group-column col-lg-6 col-md-6 col-sm-12">
                                <label for="offer">Offer</label>
                                <select class="form-control offer" multiple id="offer" name="offers[]">

                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-2">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ __('Send Report') }} 
                        </button>
                    </div>
                </div>
            </div>
        </div>
        </form>
        <div class="card">
            <div class="card-header">
                    <div class="row g-2 align-items-center">
                        <div class="col-sm-9">
                            <div class="list-grid-nav hstack gap-1">  
                                <h4 class="m-0 font-weight-bold text-primary">Error Logs</h4>
                            </div>
                        </div>
                        <div class="col-sm-auto ms-auto">
                            <div class="list-grid-nav hstack gap-1">
                                <form action="{{ route('admin.clearLogs') }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-primary">Clear Logs</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle" id="logs" width="100%">
                            <thead class="text-muted table-light">
                                <tr class="text-uppercase"> 
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Log</th> 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logs as $index => $log)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <?php
                                            // Regular expression to match date in log entry
                                            preg_match('/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\]/', $log, $matches);
                                        ?>
                                        <td class="{{ isset($matches[0]) ? 'text-danger fw-semibold' : '' }}">{{ $matches[0] ?? '' }}</td>
                                        <td>{{ $log }}</td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="{{ asset('assets/libs/select2/select2.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/libs/moment/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/libs/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script type="text/javascript">
            $(document).ready(function() {
                $('#dataTable').DataTable();
            });
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
                "startDate": "{{ isset($from) ? (new DateTime($from))->format('m/d/Y') : date('m/d/M', strtotime('-1 days')) }}", // ,"11/25/2019",
                "endDate": "{{ isset($to) ? (new DateTime($to))->format('m/d/Y') : date('m/d/M') }}", // "12/01/2019",
                "opens": "right",
                "drops": "down"
            }, function(start, end, label) {
                // console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
            });
        </script>
    <script>
            $('.offer').select2({
                ajax: {
                    url: '{{ route('admin.getOffers') }}',
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
            });

            $('.student').select2({
                ajax: {
                    url: '{{ route('admin.getStudents') }}',
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
            });
        </script>
@endpush
