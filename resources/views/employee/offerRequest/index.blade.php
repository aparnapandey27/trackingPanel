@extends('admin.layout.app')
@push('page_title')
    Offer Application
@endpush
@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4 border-left-dark shadow-lg">
                <div class="card-header">
                    <div class="float-right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addOfferRequest">Add New</button>
                    </div>
                    <h6 class="m-0 text-primary font-weight-bold">Offer Applications</h6>
                </div>
                <div class="card-body">
                    <div class="table-response">
                        <table class="table table-borderless table-hover table-striped offerApps" id="offerApps">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Student</th>
                                    <th>Offer</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addOfferRequest">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Offer Application</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class=" form-group">
                            <label for="student">Student</label>
                            <select style="width: 100%" name="student" id="student" class="form-control student"
                                data-placeholder="Choose.."></select>
                        </div>
                        <div class=" form-group">
                            <label for="offer">Offer</label>
                            <select style="width: 100%" name="offer" id="offer" class="form-control offer"
                                data-placeholder="Choose.."></select>
                        </div>
                        <div class=" form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control status">
                                <option disabled selected>Choose...</option>
                                <option value="0">Pending</option>
                                <option value="1">Approved</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="addOfferRequest()">Save Now</button>
                    </div>
                </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="editOfferRequest" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Offer Application</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <form method="POST">
                    @csrf
                    <input type="hidden" name="offerRequest_id" id="offerRequest_id">
                    <div class="modal-body">
                        <div class=" form-group">
                            <label for="student">Student</label>
                            <select style="width: 100%" name="editStudent" id="editStudent"
                                class="form-control student" data-placeholder="Choose.."></select>
                        </div>
                        <div class=" form-group">
                            <label for="offer">Offer</label>
                            <select style="width: 100%" name="editOffer" id="editOffer" class="form-control offer"
                                data-placeholder="Choose.."></select>
                        </div>
                        <div class=" form-group">
                            <label for="status">Status</label>
                            <select name="editStatus" id="editStatus" class="form-control status">
                                <option disabled selected>Choose...</option>
                                <option value="0">Pending</option>
                                <option value="1">Approved</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="updateOfferRequest()">Save changes</button>
                    </div>
                </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@push('js')
    <!-- DataTables -->
    <script src="{{ asset('assets/libs/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.bootstrap4.js') }}"></script>
    <!-- SweetAlert2-->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets/libs/select2/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            $('#offerApps').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': false,
                order: [
                    [0, 'desc']
                ],
                ajax: '{{ route('admin.offerApplication.index') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'user',
                        name: 'user'
                    },
                    {
                        data: 'offer',
                        name: 'offer'
                    },
                    {
                        data: 'status',
                        name: 'status'
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


        function addOfferRequest() {
            var student_id = $('#student').val();
            var offer_id = $('#offer').val();
            var status = $('#status').val();
            let _url = `/admin/offerApplication`;
            let _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: _url,
                type: "POST",
                data: {
                    student_id: student_id,
                    offer_id: offer_id,
                    status: status,
                    // _token: _token
                },

                success: function(data) {
                    console.log(data);
                    $('#student').val('');
                    $('#offer').val('');
                    $('#status').val('');
                    $('#offerApps').DataTable().ajax.reload();
                    $('#addOfferRequest').modal('hide');
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Offer application has been added',
                        showConfirmButton: false,
                        timer: 2000
                    })
                }
            })
        }

        function updateStatus(id, status) {
            let msg;
            if (status == 1) {
                msg = 'approve';
            } else if (status == 2) {
                msg = 'reject';
            } else if (status == 3) {
                msg = 'block';
            }
            //let msg = msg;
            let _url = `/admin/offerApplication/${id}`;
            Swal.fire({
                title: 'Confirmation?',
                text: `Are you want to ${msg} !`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `Yes, ${msg} it!`
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: _url,
                        type: 'PUT',
                        data: {
                            status: status
                        },

                        success: function(res) {
                            console.log(res)
                            $('#offerApps').DataTable().ajax.reload();
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: `Offer application has been ${msg} !`,
                                showConfirmButton: false,
                                timer: 2000
                            })
                        }
                    })
                }
            })
        }

        function deleteOfferRequest(id) {
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
                        url: "{{ route('admin.offerApplication.index') }}" + '/' + id,
                        type: 'DELETE',

                        success: function(res) {
                            $('#offerApps').DataTable().ajax.reload();
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Offer application has been deleted',
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

        $('.student').select2({
            ajax: {
                url: '{{ route('admin.getStudents') }}',
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

@endpush
