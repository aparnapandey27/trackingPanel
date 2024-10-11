@extends('employee.layout.app')
@section('title', 'Student Details')
@push('style')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/dataTables.bootstrap4.css') }}">
    
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
                            <p class="card-text"><span class="text-muted">ID:</span> {{ $student->id }}</p>
                            <p class="card-text"><span class="text-muted">Name:</span> {{ $student->name }}</p>
                            <p class="card-text"><span class="text-muted">Email:</span> <a
                                    href="mailto:{{ $student->email }}">{{ $student->email }}</a></p>
                            <p class="card-text"><span class="text-muted">Phone:</span> {{ $student->phone }}</p>
                            <p class="card-text"><span class="text-muted">Address :</span> {{ $student->address }}
                            </p>
                            <p class="card-text"><span class="text-muted">Country:</span> {{ $student->country }}</p>
                            <p class="card-text"><span class="text-muted">Zip:</span> {{ $student->zipcode }}</p>
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
                                    @if (!empty($student->signup_answers) && $student->signup_answers->count())
                                        @foreach ($student->signup_answers as $answer)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $answer->title }}</td>
                                                <td>{{ $answer->answer }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3" class="text-center">No answers available</td>
                                        </tr>
                                    @endif
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
                            <h6 class="m-0 font-wieght-bold text-primary">Tracking Link</h6>
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
                            <h6 class="m-0 text-primary font-weight-bold">Payment History</h6>
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
                                                        href="{{ route('admin.offers.show', $offer->Oid) }}">{{ $offer->Offer }}</a>
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
                                                    <div style="text-align: center">No Data
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
    <script src="{{ asset('assets/libs/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
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
                    text: 'Please select any offer to generate a tracking link',
                    timer: 5000
                });
            } else {
                let trackingDomain = @json(config('app.tracking_domain'));
                let link = `${trackingDomain ? trackingDomain + '/' : '{{ asset('/') }}'}click?aid=${userId}&oid=${offerId}`;
                $('.trLink').val(link);
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Success!',
                    text: 'Tracking link generated successfully.',
                    timer: 3000
                });
            }
        }

        $('.offer').select2({
            ajax: {
                url: '{{ route('employee.getOffers') }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.map(function (item) {
                            return {
                                id: item.id,
                                text: item.name 
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1,
            placeholder: 'Choose any Offer to Generate Its Tracking Link',
            allowClear: true
        });
    </script>
@endpush
