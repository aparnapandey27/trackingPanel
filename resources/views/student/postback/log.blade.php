@extends('student.layout.app')
@section('title', 'Postback log')
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
        <div class="col-lg-12">
            <div class="card mb-4 font-weight-bold">
                <div class="card-header">
                    <h6 class="m-0 text-primary font-weight-bold">Postbacks Log</h6>
                </div>
                <div class="card-body">
                    <div class="table-response">
                        <table class="table table-borderless table-hover table-striped postbacksdata" id="postbacks">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Offer</th>
                                    <th>Event</th>
                                    <th>Status</th>
                                    <th>Postback</th>
                                    <th>Body</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
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
            $('.postbacksdata').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': false,
                order: [
                    [0, 'desc']
                ],
                ajax: {
                    url: "/student/settings/postbacks/logs" + '/' + "{{ $id }}",
                    type: 'GET'
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'offer',
                        name: 'offer'
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
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'body',
                        name: 'body',
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
