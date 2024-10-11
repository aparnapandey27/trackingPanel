@extends('employee.layout.app')
@section('title', 'Offers')
@push('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/libs/flag-icons/css/flag-icon.min.css?v=52475656') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">

@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">{{__('Offers')}}</h4>

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
                        <div class="card-body ">
                            <div class="row g-2 align-items-center">
                                <div class="col-sm-4">
                                    <h4 class="m-0 font-weight-bold text-primary">Manage Offers</h4>
                                </div>
                                <!--end col-->
                                
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                    </div>
            
                    <div class="card shadow-lg border-left-dark">
                        <div class="card-header">
                            <h6 class="card-title mb-0 flex-grow-1 text-primary">All Offers</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-borderles offers" id="offers">
                                    <thead class="table-light text-muted">
                                        <tr>
                                            <th>ID</th>
                                            <th>Preview</th>
                                            <th>Offer Name</th>
                                            <th>Status</th>
                                            <th>Category</th>
                                            <th>Object</th>
                                            <th>Payout</th>
                                            <th>Countries</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>

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
            $('#offers').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': false,
                order: [
                    [0, 'desc']
                ],
                ajax: '{{ route('employee.offer.index') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'thumbnail',
                        name: 'thumbnail',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },

                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'offer_model',
                        name: 'offer_model'
                    },
                    {
                        data: 'payout',
                        name: 'payout'
                    },
                    {
                        data: 'countries',
                        name: 'countries',
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
    </script>
    
@endpush
