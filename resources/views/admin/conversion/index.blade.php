@extends('admin.layout.app')
@section('title', 'Import Conversion Data Excel')
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/dataTables.bootstrap4.css') }}">    
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
    
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-4">{{__('Manage/Import Conversions')}}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">{{__('Import Conversions')}}</a>
                                </li>
                                <li class="breadcrumb-item active">{{__('Manage')}}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-sm-auto ms-auto">
                            <div class="list-grid-nav hstack gap-1">
                                <form method="post"  action="{{ route('admin.conversion.import') }}" enctype="multipart/form-data"> 
                                    @csrf 
                                    <div class="input-group">
                                        <div class="custom-file mx-1">
                                            <input type="file" name="file" type="file" class="form-control" id="formFile" required accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                            {{-- <label class="custom-file-label" for="inputGroupFile">Choose file</label> --}}
                                        </div>
                                        <div class="input-group-append mx-1">
                                            <button type="submit" class="btn btn-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M11 16V7.85l-2.6 2.6L7 9l5-5l5 5l-1.4 1.45l-2.6-2.6V16h-2Zm-5 4q-.825 0-1.413-.588T4 18v-3h2v3h12v-3h2v3q0 .825-.588 1.413T18 20H6Z" />
                                                </svg> Import </button>
                                        </div>
                                        <a href="{{ asset('assets/uploads/sample_conversion.xlsx') }}" class="btn btn-secondary mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11l-5 5Zm-6 4q-.825 0-1.413-.588T4 18v-3h2v3h12v-3h2v3q0 .825-.588 1.413T18 20H6Z" />
                                            </svg> Download Excel </a>
                                    </div>
                                </form>
                            </div>
                        </div>                        
                    </div>
                    <!--end row-->
                </div>
            </div>
    
            <div class="card shadow-lg border-left-dark">
                <div class="card-header">
                    <h6 class="card-title mb-0 flex-grow-1 text-primary">All Conversions</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-borderles conversions" id="conversions">
                            <thead class="text-muted table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Student</th>
                                    <th>Offer</th>
                                    <th>Advertiser</th>
                                    <th>Event</th>
                                    <th>Status</th>
                                    <th>Conversion IP</th>
                                    <th>Transaction ID</th>
                                    <th>Created At</th>
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
    <!-- Select2 -->
    <script src="{{ asset('assets/libs/select2/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            $('#conversions').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [0, 'desc']
                ],
                ajax: '{{ route('admin.conversion.index') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'student',
                        name: 'student'
                    },
                    {
                        data: 'offer',
                        name: 'offer'
                    },
                    {
                        data: 'advertiser',
                        name: 'advertiser'
                    },
                    {
                        data: 'event',
                        name: 'event'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    
                    {
                        data: 'conversionip',
                        name: 'conversionip'
                    },
                    {
                        data: 'transactionid',
                        name: 'transactionid'
                    },
                    {
                        data:'created_at',
                        name:'created_at'
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
