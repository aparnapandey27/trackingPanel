@extends('admin.layout.app')
@section('title', 'Student Payments')
@push('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">        
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{__('Student Invoices')}}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{__('Students')}}</a></li>
                                <li class="breadcrumb-item active">{{__('Invoices')}}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="row g-2 align-items-center">
                        <div class="col-sm-4">
                            <h4 class="m-0 font-weight-bold text-primary">Student Invoices</h4>
                        </div>                
                        <div class="col-sm-auto ms-auto">
                            <div class="row">
                                <div class="col-sm-auto ms-auto">
                                    <div class="list-grid-nav hstack gap-1">                                        
                                        <form action="{{ route('admin.payment.generate') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="invoice" value="monthly">
                                            <button class="btn btn-primary" type="submit">Generate Monthly
                                                Invoice</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-sm-auto ms-auto">
                                    <div class="list-grid-nav hstack gap-1">                                        
                                        <form action="{{ route('admin.payment.generate') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="invoice" value="weekly">
                                            <button class="btn btn-primary" type="submit">Generate Weekly
                                                Invoice</button>
                                        </form>
                                    </div>
                                </div>
                            </div>                            
                        </div>                        
                    </div>                            
                </div>
            </div> 
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4 border-left-dark shadow-lg">
                        <div class="card-header">
                            
                            <h6 class="card-title mb-0 flex-grow-1 text-primary">Payments</h6>
                        </div>                        
                        <div class="card-body">
                            @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <h4><i class="icon fa fa-check"></i> Success!</h4>
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-borderless table-hover table-striped payments" id="payments">
                                    <thead>
                                        <tr>
                                            <th>#ID</th>
                                            <th>Student</th>
                                            <th>Original Amount</th>
                                            <th>Payable Amount</th>
                                            <th>Payment Method</th>
                                            <th>Payment Method Detail</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- / Amount Adjust Modal -->
            <div class="modal fade" id="adjustModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Adjust Payable Balance</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">                                
                        </div>
                        <form action="" method="POST">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="id" id="paymentId" value="">
                                <div class=" form-group">
                                    <label for="adjustAmount">Adjusted Amount</label>
                                    <input type="number" class="form-control" id="adjustAmount" name="amount"
                                        placeholder="Enter Amount" pattern="^[0-9]{1,2}(\.[0-9]{0,6})?$" step="0.01">
                                </div>
                                <div class="form-group">
                                    <label for="adjustType">Adjustment Type</label>
                                    <select class="form-control" id="adjustType" name="type">
                                        <option value="add">Add</option>
                                        <option value="subtract">Subtract</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="adjustReason">Reason</label>
                                    <textarea class="form-control" id="adjustReason" name="reason" rows="3" placeholder="Enter Reason"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="adjustSubmit()">Save Now</button>
                            </div>
                        </form>

                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- DataTables -->
    <script src="{{ asset('assets/libs/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.bootstrap4.js') }}"></script>
    <!-- SweetAlert2-->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets/libs/select2/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            $('#payments').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': false,
                order: [
                    [0, 'desc']
                ],
                ajax: '{{ route('admin.payment.index') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'student',
                        name: 'student'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'payable_amount',
                        name: 'payable_amount'
                    },
                    {
                        data: 'method',
                        name: 'method'
                    },
                    {
                        data: 'payment_method_detail',
                        name: 'payment_method_detail'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });
        })
    </script>
    <script>
        function paid(id) {
            swal.fire({
                title: 'Are you sure?',
                text: "You want to mark this payment as paid!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, paid it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: `/admin/student/payments/paid/${id}`,
                        type: "POST",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            swal.fire(
                                'Success!',
                                'Payment has been marked as paid.',
                                'success'
                            )
                            $('#payments').DataTable().ajax.reload();
                        }
                    });
                }
            })
        }


        // Adjust Amount Modal
        function adjust(id) {
            $('#adjustModal').modal('show');
            $('#paymentId').val(id);
        }

        function adjustSubmit() {
            let _id = $('#paymentId').val();
            let amount = $('#adjustAmount').val();
            let type = $('#adjustType').val();
            let reason = $('#adjustReason').val();
            let _url = `/admin/student/payments/adjust/${_id}`;
            let _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: _url,
                type: "POST",
                data: {
                    id: _id,
                    amount: amount,
                    type: type,
                    reason: reason,
                    _token: _token
                },
                success: function(data) {
                    console.log(data);
                    $('#adjustModal').modal('hide');
                    swal.fire(
                        'Success!',
                        'Payment has been adjusted.',
                        'success'
                    )
                    $('#payments').DataTable().ajax.reload();
                }
                // error: function(response) {
                //     $('#taskError').text(response.responseJSON.errors.todo);
                // }
            });
        }
    </script>
@endpush
