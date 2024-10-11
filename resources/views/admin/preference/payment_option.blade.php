@extends('admin.layout.app')
@section('title', 'Payment Options')

@push('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-4">{{__('Offers')}}</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{__('Offers')}}</a></li>
                                        <li class="breadcrumb-item active">{{__('Manage')}}</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row g-2 align-items-center">
                                <div class="col-sm-4">
                                    <h4 class="m-0 font-weight-bold text-primary">Manage Payament Methods</h4>
                                </div>
                                <!--end col-->
                                <div class="col-sm-auto ms-auto">
                                    <div class="list-grid-nav hstack gap-1">                                        
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentOptionAdd">Add Payment
                                            Method</button>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                    </div>
            
                    <div class="card shadow-lg border-left-dark">
                        <div class="card-header">
                            <h6 class="card-title mb-0 flex-grow-1 text-primary">Payament Methods</h6>
                        </div>
                    
                                <div class="card-body">
                                    <div class="table-response">
                                        <table class="table table-striped table-hover paymentOptionTable" id="paymentOptionTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Payment Method Name</th>
                                                    <th>Minimum Threshold</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                    </div>
                        

                    <div class="modal fade" id="paymentOptionAdd">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Payment Method</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                </div>
                                <form action="" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class=" form-group">
                                            <label for="name">Payment Method Name</label>
                                            <input type="text" class="form-control name" name="name" id="name" required
                                                placeholder="Payment Option Name">
                                        </div>
                                        <div class=" form-group">
                                            <label for="name">Minimum Threshold</label>
                                            <input type="number" class="form-control name minimum_threshold" name="minimum_threshold"
                                                id="minimum_threshold" required placeholder="Minimum Threshold">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" onclick="addPaymentMethod()">Add Payment
                                            Method</button>
                                    </div>
                                </form>

                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <div class="modal fade" id="paymentOptionEdit" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Payment Method</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                </div>
                                <form method="POST">
                                    @csrf
                                    <input type="hidden" name="payment_option_id" id="payment_option_id">
                                    <div class="modal-body">
                                        <div class=" form-group">
                                            <label for="name">Payment Method Name</label>
                                            <input type="text" class="form-control name" name="name" id="edit_name" required
                                                placeholder="Payment Option Name" value="">
                                        </div>
                                        <div class=" form-group">
                                            <label for="name">Minimum Threshold</label>
                                            <input type="number" class="form-control name" name="minimum_threshold"
                                                id="edit_minimum_threshold" required placeholder="Minimum Threshold" value="">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" onclick="updatePaymentMethod()">Save changes</button>
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
    <script>
        $(function() {
            $('#paymentOptionTable').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': false,
                order: [
                    [0, 'desc']
                ],
                ajax: '{{ route('admin.preference.paymentOption.index') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'minimum_threshold',
                        name: 'minimum_threshold'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });


        })

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });


        function addPaymentMethod() {
            var name = $('.name').val();
            var minimum_threshold = $('.minimum_threshold').val();
            let _url = `/admin/preference/payment-options`;
            let _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: _url,
                type: "POST",
                data: {
                    name: name,
                    minimum_threshold: minimum_threshold,
                    // _token: _token
                },

                success: function(data) {
                    console.log(data);
                    $('.name').val('');
                    $('.minimum_threshold').val('');
                    $('#paymentOptionTable').DataTable().ajax.reload();
                    $('#paymentOptionAdd').modal('hide');
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Payment Method has been Added',
                        showConfirmButton: false,
                        timer: 2000
                    })
                }
            })
        }


        function editPaymentMethod(id) {
            let _url = `/admin/preference/payment-options/${id}/edit`;
            $.ajax({
                url: _url,
                type: 'GET',
                success: function(res) {
                    console.log(res);
                    $('#paymentOptionEdit').modal('show');
                    $('#payment_option_id').val(res.id);
                    $('#edit_name').val(res.name);
                    $('#edit_minimum_threshold').val(res.minimum_threshold);
                }
            })
        }


        function updatePaymentMethod() {
            var name = $('#edit_name').val();
            var minimum_threshold = $('#edit_minimum_threshold').val();
            var id = $('#payment_option_id').val();
            let _url = `/admin/preference/payment-options/${id}`;
            let _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: _url,
                type: "PUT",
                data: {
                    name: name,
                    minimum_threshold: minimum_threshold,
                    // _token: _token
                },
                success: function(data) {
                    console.log(data)
                    $('#paymentOptionTable').DataTable().ajax.reload();

                    $('#paymentOptionEdit').modal('hide');

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Payment Method has been updated',
                        showConfirmButton: false,
                        timer: 2000
                    })
                },
                error: function(response) {
                    $('#taskError').text(response.responseJSON.errors.todo);
                }
            });
        }


        function deletePaymentMethod(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.preference.paymentOption.index') }}" + '/' + id,
                        type: 'DELETE',

                        success: function(res) {
                            $('#paymentOptionTable').DataTable().ajax.reload();
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Payment Method has been deleted',
                                showConfirmButton: false,
                                timer: 2000
                            })
                        },
                        error: function(res) {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                                timer: 2000
                            })
                        }
                    })

                }
            })
        }
    </script>
@endpush
