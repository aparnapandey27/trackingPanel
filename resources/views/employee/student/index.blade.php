@extends('employee.layout.app')
@section('title', 'Students')
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
                    <!-- end page title -->

                    {{-- <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">                                
                                <div class="col-sm-9">
                                    <div class="list-grid-nav hstack gap-1">                                        
                                        <h4 class="m-0 text-primary font-weight-bold">Manage Students</h4>
                                    </div>
                                </div>
                                <div class="col-sm-auto ms-auto">
                                    <a class="btn btn-primary" href="{{ route('admin.student.create') }}">Add Student</a>
                                </div>                                
                            </div>
                            <!--end row-->
                        </div>
                    </div>  --}}
                    <div class="card shadow-lg border-left-dark">
                        <div class="card-header">
                            <h6 class="card-title mb-0 flex-grow-1 text-primary">All Students</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-borderles Students" id="students">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>status</th>
                                            <th>Created</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="addStu">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Student</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">                                        
                                </div>
                                <form action="" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class=" form-group mb-3">
                                            <label for="name">Fullname</label>
                                            <input type="text" class="form-control name" name="name" id="name" required
                                                placeholder="Fullname">
                                        </div>
                                        <div class=" form-group mb-3">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control email" name="email" id="email" required
                                                placeholder="Email Address">
                                        </div>
                                        
                                        <div class=" form-group mb-3">
                                            <label for="status">Status</label>
                                            <select name="status"  class=" form-select status">
                                                <option disabled selected>Choose...</option>
                                                <option value="0">Pending</option>
                                                <option value="1">Active</option>
                                            </select>
                                        </div>

                                        <div class=" form-group mb-3">
                                            <input type="checkbox" name="notification" id="notification" class=" notification">
                                            <label for="notification">Send Welcome Email</label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" onclick="addStudent()">Add Student</button>
                                    </div>
                                </form>

                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>

                    <div class="modal fade" id="editStu">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Student</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                </div>
                                <form action="" method="POST">
                                    <input type="hidden" id="student_id" name="student_id" class="student_id">
                                    @csrf
                                    <div class="modal-body">
                                        <div class=" form-group mb-3">
                                            <label for="name">Fullname</label>
                                            <input type="text" class="form-control ename" name="name" id="name" required
                                                placeholder="Fullname">
                                        </div>
                                        <div class=" form-group mb-3">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control eemail" name="email" id="email" required
                                                placeholder="Email Address">
                                        </div>
                                        
                                        <div class=" form-group mb-3">
                                            <label for="status">Status</label>
                                            <select name="status"  class=" form-select estatus">
                                                <option disabled selected>Choose...</option>
                                                <option value="0">Pending</option>
                                                <option value="1">Active</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" onclick="updateStudent()">Update Student</button>
                                    </div>
                                </form>

                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>

                    <!-- Update/Add student Manager Modal -->
                    <div class="modal fade" id="updateMngr">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Update Student Manager</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">                                        
                                </div>
                                <form action="" method="POST">
                                    <div class="modal-body">
                                        <input type="hidden" id="student_id" name="student_id" class="student_id">
                                        <div class="form-group mb-3">
                                            <label for="manager">Student Manager</label>
                                            <select style="width: 100%" name="manager" id="manager" class="form-control manager"
                                                data-placeholder="Choose..">

                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" onclick="updateManager()">Update Student
                                            Manager</button>
                                    </div>
                                </form>
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
            $('#students').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': false,
                order: [
                    [0, 'desc']
                ],
                ajax: '{{ route('employee.student.index') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
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

        function addStudent() {
            var name = $('.name').val();
            var email = $('.email').val();
            var status = $('.status').val();
            let _url = `/employee/student/store`;
            let _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: _url,
                type: "POST",
                data: {
                    name: name,
                    email: email,
                    status: status,
                    // _token: _token
                },

                success: function(data) {
                    console.log(data);
                    $('.name').val('');
                    $('.email').val('');
                    $('.status').val('');
                    $('#students').DataTable().ajax.reload();
                    $('#addStu').modal('hide');
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Student has been Added',
                        showConfirmButton: false,
                        timer: 2000
                    })
                },
                error: function(data) {
                    console.log(data);
                }
            })
        }

        


        
        function deleteStudent(id) {
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
                        url: '/employee/student/delete/' + id,
                        type: 'DELETE',

                        success: function(res) {
                            $('#students').DataTable().ajax.reload();
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Student has been deleted',
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
        const quickAdd = new URL(window.location.href).searchParams.get("quickAdd");
        if (quickAdd) {
            $(document).ready(function() {
                $("#addStu").modal('show');
            });
        }
    </script>

    <script>
        function updateStatus(id, status) {
            let msg;
            if (status == 1) {
                msg = 'Approve';
            } else if (status == 2) {
                msg = 'Reject';
            } else if (status == 3) {
                msg = 'Closed';
            }
            //let msg = msg;
            let _url = `/employee/student/status/${id}`;
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
                        type: 'POST',
                        data: {
                            status: status
                        },

                        success: function(res) {
                            console.log(res)
                            $('#students').DataTable().ajax.reload();
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: `Student has been ${msg} !`,
                                showConfirmButton: false,
                                timer: 2000
                            })
                        }
                    })
                }
            })
        }
    </script>
@endpush
