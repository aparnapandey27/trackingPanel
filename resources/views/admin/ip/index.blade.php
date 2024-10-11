@extends('admin.layout.app')

@section('title', 'IP Whitelisting')

@push('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-4">{{ __('IP Address') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript:void(0);">{{ __('IP Whitelisting') }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('Manage') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End page title -->

            <!-- Action and Manage IP Section -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row g-2 align-items-center">
                        <div class="col-sm-4">
                            <h4 class="m-0 font-weight-bold text-primary">Manage IP Address</h4>
                        </div>
                        <div class="col-sm-auto ms-auto">
                            <a class="btn btn-primary" href="{{ route('admin.ip.create') }}">Add IP Address</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- IP Whitelisted Table -->
            <div class="card shadow-lg border-left-dark">
                <div class="card-header">
                    <h6 class="card-title mb-0 flex-grow-1 text-primary">IP Whitelisted</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-borderless" id="ipaddr">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>IP Address</th>
                                    <th>Advertiser</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be populated by DataTables -->
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
    <!-- SweetAlert2 -->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        $(function() {
            // Initialize DataTable
            $('#ipaddr').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': false,
                order: [[0, 'desc']],
                ajax: '{{ route('admin.ip.index') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'ipaddress', name: 'ipaddress' },
                    { data: 'advertiser', name: 'advertiser' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function deleteIP(id) {
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
                        url: '/admin/ip/delete/' + id,
                        type: 'DELETE',

                        success: function(res) {
                            $('#ipaddr').DataTable().ajax.reload();
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'IP Address has been deleted',
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
   
    <script>
        function updateStatus(id, status) {
            let msg;
            if (status == 1) {
                msg = 'Approve';
            } else if (status == 2) {
                msg = 'Reject';
            } 
            let _url = `/admin/ip/status/${id}`;
            Swal.fire({
                title: 'Confirmation?',
                text: `Are you sure you want to ${msg} this IP?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `Yes, ${msg} it!`
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: _url,
                        type: 'POST',
                        data: {
                            status: status
                        },
                        success: function(res) {
                            $('#ipaddr').DataTable().ajax.reload();
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: `IP Address has been ${msg}!`,
                                showConfirmButton: false,
                                timer: 2000
                            })
                        },
                    })
                }
            })
        }
    </script>
@endpush
