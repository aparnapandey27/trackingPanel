@extends('admin.layout.app')
@section('title', 'Employee Details')
@push('style')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/icomoon/style.css') }}">
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{__('Employees')}}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{__('Employees')}}</a></li>
                                <li class="breadcrumb-item active">{{__('Manage')}}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card mb-4 shadow-lg border-left-dark">
                        <div class="card-header">
                            <h6 class="card-title mb-0 flex-grow-1 text-primary">Employee Details</h6>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><span class="text-muted">#ID:</span> {{ $employee->id ?? 'No ID available' }}</p>
                            <p class="card-text"><span class="text-muted">Name:</span> {{ $employee->name ?? 'No name available' }}</p>
                            <p class="card-text"><span class="text-muted">Email:</span>
                                @if ($employee->email)
                                    <a href="mailto:{{ $employee->email }}">{{ $employee->email }}</a>
                                @else
                                    No email available
                                @endif
                            </p>
                            <p class="card-text"><span class="text-muted">Phone:</span>
                                @if ($employee->phone)
                                    <a href="tel:{{ $employee->phone }}">{{ $employee->phone }}</a>
                                @else
                                    No phone available
                                @endif
                            </p>
                            
                            <p class="card-text"><span class="text-muted">Address :</span> {{ $employee->address ?? 'No address provided' }}</p>
                            <p class="card-text"><span class="text-muted">Country:</span> {{ $employee->country ?? 'No country provided' }}</p>
                            <p class="card-text"><span class="text-muted">Zip:</span> {{ $employee->zipcode ?? 'No ZIP code provided' }}</p>
                            <p class="card-text"><span class="text-muted">Status:</span>
                                @if ($employee->status == 1)
                                    <span class="badge bg-success-subtle text-success text-uppercase">Active</span>
                                @elseif ($employee->status == 2)
                                    <span class="badge badge-danger">Rejected</span>
                                @elseif ($employee->status == 3)
                                    <span class="badge badge-danger">Closed</span>
                                @else
                                    <span class="badge badge-danger">Pending</span>
                                @endif
                            </p>
                        </div>
                        
                    </div>

                    {{-- <div class="card mb-4 shadow-lg border-left-dark">
                        <div class="card-header">
                            <h6 class="m-0 font-wieght-bold text-primary">Tracking Link</h6>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <select class="form-control offer" data-placeholder="Choose any Offer to Generate Its Tracking Link"
                                    onchange="generateLink({{ $employee->id }})"></select>
                                <small class="help-block">To generate a tracking link, select any Offer from below. Tracking
                                    links records click for reporting.</small>
                            </div>
                            <div class="form-group">
                                <label class="text-muted">Generated Link</label>
                                <textarea class="form-control trLink mb-4" name="url"></textarea>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div> --}}
                </div>

                <div class="col-lg-6">
                    <div class="card mb-4 shadow-lg border-left-dark">
                        <div class="card-header">
                            <h6 class="card-title mb-0 flex-grow-1 text-primary">User Logs</h6>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><span class="text-muted">Singed Up:</span>
                                @if ($employee->created_at)
                                    {{ $employee->created_at->format('h:i A - d -M - Y') }}
                                @endif
                            </p>
                            <p class="card-text"><span class="text-muted">Singup IP:</span> {{ $employee->signup_ip }}
                            </p>
                            <p class="card-text"><span class="text-muted">Last Login:</span>
                                @if ($employee->last_login_at)
                                    {{ $employee->last_login_at->format('h:i A - d -M - Y') }}
                                @else
                                    <span class="text-danger">Never</span>
                                @endif
                            </p>
                            <p class="card-text"><span class="text-muted">Last Login IP:</span>
                                @if ($employee->last_login_ip)
                                    {{ $employee->last_login_ip }}
                                @else
                                    <span class="text-danger">Never</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    {{-- <div class="card mb-4 shadow-lg border-left-dark">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-priamry">Reports</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Offer</th>
                                            <th>Click</th>
                                            <th>Conv.</th>
                                            <th>Payout</th>
                                            <th>Revenue</th>
                                            <th>Profit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($reports as $offer)
                                            <tr>
                                                <td>{{ $offer->Oid }}</td>
                                                <td><a
                                                        href="{{ route('admin.offer.show', $offer->Oid) }}">{{ $offer->Offer }}</a>
                                                </td>
                                                <td>{{ $offer->Clicks }}</td>
                                                <td>{{ $offer->Leads }}</td>
                                                <td>{{ $offer->Payout }}</td>
                                                <td>{{ $offer->Revenue }}</td>
                                                <td>{{ $offer->Profit }}</td>
                                            </tr>
                                        @empty
                                            <tr>

                                                <td colspan="7">
                                                    <div style="text-align: center; font-weight: 700; font-size: 1.85rem">No Data
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $reports->links() }}
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <!-- SweetAlert2-->
    <script src="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.all.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        function generateLink(userId) {
            let offerId = $('.offer').val();
            if (offerId == null) {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please select any offer to generate tracking link',
                    timer: 5000
                })
            } else {
                let link = `http://trackinglink.test/stu=${userId}&off=${offerId}`;
                $('.trLink').val(link);
            }

        }

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
    </script>
    <!-- SweetAlert2-->
    <script src="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.all.js') }}"></script>
    <script src="{{ asset('assets/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/libs/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
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
    </script>
@endpush
