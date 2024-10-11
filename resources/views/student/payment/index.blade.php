@extends('student.layout.app')
@section('title', 'Payment History')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/flag-icons/css/flag-icon.min.css') }}">
@endpush

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="card mb-4 shadow-lg">
            <div class="card-header">
                <a href="#collapseCardExample" class="d-block card-header collapsed" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="collapseCardExample">
                    <h6 class="m-1 font-weight-bold text-primary">Filter</h6>
                </a>
            </div>
            <div class="collapse" id="collapseCardExample" style="">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-lg-6 mb-4">
                            <div class="form-group">
                                <label for="invoice_id">Invoice ID</label>
                                <input type="text" class="form-control" id="invoice_id" name="invoice_id" placeholder="Invoice ID">
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="form-group">
                                <label for="status">Payment Status</label>
                                <select id="status" class="form-control status" style="width: 100%">
                                    <option value="">Select Status</option>
                                    <option value="0">Pending</option>
                                    <option value="1">Paid</option>
                                    <option value="2">Cancelled</option>
                                    <option value="3">Hold</option>
                                    <option value="4">Forwarded</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-lg">
            <div class="card-header">
                <h6 class="m-0 text-primary font-weight-bold">All Payment History</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-borderless payments" id="payments">
                        <thead class="table-light text-muted">
                            <tr>
                                <th>Invoice ID</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Payment data will be inserted here via DataTables -->
                        </tbody>
                    </table>
                </div>
            </div>
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

    <script>
        $(function() {
    var table = $('#payments').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('student.payment.index') }}',
        columns: [
            {data: 'id', name: 'id'},
            {data: 'created_at', name: 'created_at'},
            {data: 'amount', name: 'amount'},
            {data: 'payment_method', name: 'payment_method'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });


            // Reload table when filters change
            $('#invoice_id').change(function() {
                table.ajax.reload();
            });
            $('#status').change(function() {
                table.ajax.reload();
            });
        });

        // Select2 for status filter
        $('#status').select2({
            placeholder: 'Select Payment Status',
            allowClear: true
        });
    </script>
@endpush
