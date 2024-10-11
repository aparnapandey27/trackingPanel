@extends('admin.layout.app')
@section('title', 'Student Details')
@push('style')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/icomoon/style.css') }}">
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{__('Students')}}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{__('Students')}}</a></li>
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
                            <h6 class="card-title mb-0 flex-grow-1 text-primary">Students Details</h6>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                <span class="text-muted">#ID:</span>
                                @if ($student->id)
                                    {{ $student->id }}
                                @else
                                    No ID available
                                @endif
                            </p>
                            <p class="card-text">
                                <span class="text-muted">Name:</span>
                                @if ($student->name)
                                    {{ $student->name }}
                                @else
                                    No name available
                                @endif
                            </p>
                            
                            <p class="card-text">
                                <span class="text-muted">Email:</span>
                                @if ($student->email)
                                    <a href="mailto:{{ $student->email }}">{{ $student->email }}</a>
                                @else
                                    No email available
                                @endif
                            </p>
                            
                            <p class="card-text">
                                <span class="text-muted">Phone:</span>
                                @if ($student->phone)
                                    {{ $student->phone }}
                                @else
                                    No phone available
                                @endif
                            </p>
                            
                            
                            <p class="card-text">
                                <span class="text-muted">Address :</span>
                                @if ($student->address)
                                    {{ $student->address }}
                                @else
                                    No address provided
                                @endif
                            </p>
                            
                            
                            
                            <p class="card-text">
                                <span class="text-muted">Country:</span>
                                @if ($student->country)
                                    {{ $student->country }}
                                @else
                                    No country specified
                                @endif
                            </p>
                            
                            <p class="card-text">
                                <span class="text-muted">Zip:</span>
                                @if ($student->zipcode)
                                    {{ $student->zipcode }}
                                @else
                                    No ZIP code provided
                                @endif
                            </p>
                            
                            <p class="card-text"><span class="text-muted">Status:</span>
                                @if ($student->status == 1)
                                    <span class="badge" style="background-color: black">Active</span>
                                @elseif ($student->status == 2)
                                    <span class="badge badge-danger">Rejected</span>
                                @elseif ($student->status == 3)
                                    <span class="badge badge-danger">Closed</span>
                                @else
                                    <span class="badge badge-danger">Pending</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="card mb-4 shadow-lg border-left-dark">
                        <div class="card-header">
                            <h6 class="card-title mb-0 flex-grow-1 text-primary">Addition Questions</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Question</th>
                                            <th>Answer</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($student->signup_answers as $answer)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $answer->title }}</td>
                                                <td>{{ $answer->answer }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4 border-left-dark shadow-lg">
                        <div class="card-header">
                            <h6 class="card-title mb-0 flex-grow-1 text-primary">User Logs</h6>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><span class="text-muted">Singed Up:</span>
                                @if ($student->created_at)
                                    {{ $student->created_at->format('h:i A - d -M - Y') }}
                                @endif
                            </p>
                            <p class="card-text"><span class="text-muted">Singup IP:</span> {{ $student->signup_ip }}
                            </p>
                            <p class="card-text"><span class="text-muted">Last Login:</span>
                                @if ($student->last_login_at)
                                    {{ $student->last_login_at->format('h:i A - d -M - Y') }}
                                @else
                                    <span class="text-danger">Never</span>
                                @endif
                            </p>
                            <p class="card-text"><span class="text-muted">Last Login IP:</span>
                                @if ($student->last_login_ip)
                                    {{ $student->last_login_ip }}
                                @else
                                    <span class="text-danger">Never</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card mb-4 shadow-lg border-left-dark">
                        <div class="card-header">
                            <h6 class="card-title mb-0 flex-grow-1 text-primary">Tracking Link</h6>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <select class="form-control offer" data-placeholder="Choose any Offer to Generate Its Tracking Link"
                                    onchange="generateLink({{ $student->id }})"></select>
                                <small class="help-block">To generate a tracking link, select any Offer from below. Tracking
                                    links records click for reporting.</small>
                            </div>
                            <div class="form-group">
                                <label class="text-muted">Generated Link</label>
                                <textarea class="form-control trLink mb-4" name="url"></textarea>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>

                    <div class="card mb-4 border-left-dark shadow-lg">
                        <div class="card-header">
                            <h6 class="card-title mb-0 flex-grow-1 text-primary">Settings</h6>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><span class="text-muted">Payament Frequancy:</span>
                                {{ $student->payment_frequency }}
                            </p>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#payterm-update">
                                Change Payment Frequency
                            </button>
                        </div>
                    </div>

                    <!--payment frequency Start-->
                    <div class="modal fade" id="payterm-update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form method="POST" action="{{ route('admin.student.payment_frequency', $student->id) }}"
                                class="form-horizontal">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Update Payment Frequency</h5>
                                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">                                            
                                        </button>
                                    </div>
                                    <div class="modal-body">


                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Payment Frequency</label>
                                            <div class="col-sm-9 col-md-6">
                                                <select name="payment_frequency" class="form-control">
                                                    <option selected disabled>--Select Payment Frequency--</option>
                                                    <option value="monthly"
                                                        {{ $student->payment_frequency == 'monthly' ? 'selected' : '' }}>
                                                        Monthly
                                                    </option>
                                                    <option value="weekly"
                                                        {{ $student->payment_frequency == 'weekly' ? 'selected' : '' }}>Weekly
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </form>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>

                    <div class="card mb-4 border-left-dark shadow-lg">
                        <div class="card-header">
                            <h6 class="card-title mb-0 flex-grow-1 text-primary">Payment History</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Invoice ID</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Payment Method</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($payments as $key => $payment)
                                            <tr>
                                                <td>{{ $payment->id }}</td>
                                                <td>{{ $payment->created_at->format('h:i:s A, d M, Y') }}</td>
                                                <td>{{ $payment->amount }} {{ $payment->currency }}</td>
                                                <td>
                                                    @if ($payment->payment_method == 'PayPal')
                                                        <i class="icon-paypal"></i>
                                                    @elseif ($payment->payment_method == 'Payoneer')
                                                        <i class="icon-payoneer"></i>
                                                    @elseif ($payment->payment_method == 'Wise')
                                                        <i class="icon-wise"></i>
                                                    @elseif ($payment->payment_method == 'Skrill')
                                                        <i class="icon-skrill"></i>
                                                    @elseif ($payment->payment_method == 'WebMoney')
                                                        <i class="icon-webmoney"></i>
                                                    @else
                                                    @endif
                                                    {{ $payment->payment_method }}
                                                </td>
                                                <td>
                                                    @if ($payment->status == 0)
                                                        <span class="badge badge-success"><i class="fa fa-clock-o"></i>
                                                            Pending</span>
                                                    @elseif ($payment->status == 1)
                                                        <span class="badge badge-primary"><i class="fa fa-check"></i>
                                                            Paid</span>
                                                    @elseif ($payment->status == 2)
                                                        <span class="badge badge-danger"><i class="fa fa-times"></i>
                                                            Cancelled</span>
                                                    @elseif ($payment->status == 3)
                                                        <span class="badge badge-info"><i class="fa fa-exclamation-triangle"></i>
                                                            Hold</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('student.payment.index') }}"><i
                                                            class="fa fa-download"></i></a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No Payment History</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4 shadow-lg border-left-dark">
                        <div class="card-header">
                            <h6 class="card-title mb-0 flex-grow-1 text-primary">Reports</h6>
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
                    </div>
                </div>
            </div>  
        </div>
    </div>
    
@endsection

@push('scripts')
    <!-- SweetAlert2-->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets/libs/select2/select2.full.min.js') }}"></script>
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
                let link =
                    `{{ config('app.tracking_domain') ? config('app.tracking_domain') . '/' : asset('/') }}click?aid=${userId}&oid=${offerId}`;
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



        /**
         * Created by ouarka.dev@gmail.com
         * */
        function submit_form() {
            document.getElementById('performance-form').submit();
        }
    </script>
@endpush
