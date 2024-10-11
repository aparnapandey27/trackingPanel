@extends('admin.layout.app')

@push('style')
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/flag-icons/css/flag-icon.min.css?v=52475656') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
@endpush

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row align-items-center">                                
            <div class="col-sm-9">
                <div class="list-grid-nav hstack gap-1">                                        
                    <form method="post"  action="{{url('admin/student/import')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            <div class="custom-file mx-1">
                                <input type="file" name="file" type="file" class="form-control" id="formFile"  required accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                {{-- <label class="custom-file-label" for="inputGroupFile">Choose file</label> --}}
                            </div>
                            <div class="input-group-append mx-1">
                                <button type="submit" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M11 16V7.85l-2.6 2.6L7 9l5-5l5 5l-1.4 1.45l-2.6-2.6V16h-2Zm-5 4q-.825 0-1.413-.588T4 18v-3h2v3h12v-3h2v3q0 .825-.588 1.413T18 20H6Z"/></svg> Import</button>
                            </div>                                                
                            <a href="{{ asset('assets/uploads/sample_student.xlsx') }}" class="btn btn-success">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11l-5 5Zm-6 4q-.825 0-1.413-.588T4 18v-3h2v3h12v-3h2v3q0 .825-.588 1.413T18 20H6Z"/></svg> Download Excel
                            </a>                                                
                        </div>                                            
                    </form>
                </div>
            </div>
            <div class="col-sm-auto ms-auto">
                <a class="btn btn-primary" href="{{ route('admin.students.create') }}">Add Student</a>
            </div>                                
        </div>
        <!--end row-->
    </div>
</div> 

    

    <div class="card mt-4">
        <div class="card-header pb-0 px-3">
            <h6 class="mb-0">{{ __('List of students') }}</h6>
        </div>

        <div class="card-body pt-4 p-3">
            <!-- Table of students -->
            <div class="table-responsive">
                <table id="studentsTable" class="table table-striped table-bordered table-light">
                    <thead>
                        <tr>
                            <th style="padding: 1rem;">{{ __('ID') }}</th>
                            <th style="padding: 1rem;">{{ __('Name') }}</th>
                            <th style="padding: 1rem;">{{ __('College') }}</th>
                            <th style="padding: 1rem;">{{ __('Email') }}</th>
                            <th style="padding: 1rem;">{{ __('Status') }}</th>
                            <th style="padding: 1rem;">{{ __('Manager') }}</th>
                            <th style="padding: 1rem;">{{ __('Created at') }}</th>
                            <th style="padding: 1rem;">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr class="table-hover">
                            <td style="padding: 1rem;">{{ $student->id }}</td>
                            <td style="padding: 1rem;">{{ $student->name }}</td>
                            <td style="padding: 1rem;">{{ $student->college }}</td>
                            <td style="padding: 1rem;">{{ $student->email }}</td>
                            <td style="padding: 1rem;">{!! $student->status_badge !!}</td>
                            <td style="padding: 1rem;">{  }</td>
                            <td style="padding: 1rem;">{{ $student->created_at }}</td>
                            <td>
                                <div class="d-flex">
                                    <!-- Confirm Button -->
                                    <form action="{{ route('admin.students.confirm', $student->id) }}" method="POST" class="approve-form" data-student-id="{{ $student->id }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-custom btn-confirm" style="background-color: yellowgreen; color: white; padding: 10px 15px; border: none; border-radius: 5px; margin-right: 10px;">
                                            <i class="fa fa-check fa-lg"></i>
                                        </button>
                                    </form>
                                
                                    <!-- Reject Button -->
                                    <form action="{{ route('admin.students.reject', $student->id) }}" method="POST" class="reject-form" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-custom btn-reject" style="background-color: rgb(56, 187, 161); color: white; padding: 10px 15px; border: none; border-radius: 5px; margin-right: 10px;">
                                            <i class="fa fa-times fa-lg"></i>
                                        </button>
                                    </form>
                                
                                    <!-- Disable Button -->
                                    <form action="{{ route('admin.students.disable', $student->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-custom btn-disable" style="background-color: red; color: white; padding: 10px 15px; border: none; border-radius: 5px; margin-right: 10px;">
                                            <i class="fa fa-ban fa-lg"></i>
                                        </button>
                                    </form>
                                
                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-custom btn-edit" style="background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 5px; margin-right: 10px;">
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                
                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" class="delete-form" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-custom btn-delete" style="background-color: rgb(65, 65, 227); color: white; padding: 10px 15px; border: none; border-radius: 5px; margin-right: 10px;">
                                            <i class="fa fa-trash fa-lg"></i>
                                        </button>
                                    </form>
                                
                                    <!-- Login Button -->
                                    <a href="{{ route('admin.loginAs', $student->id) }}" class="btn btn-info btn-sm" title="Sign in to this account" style="background-color: #17a2b8; color: white; padding: 10px 15px; border: none; border-radius: 5px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" style="fill: white;">
                                            <path d="M12 21v-2h7V5h-7V3h7q.825 0 1.413.588T21 5v14q0 .825-.588 1.413T19 21h-7Zm-2-4l-1.375-1.45l2.55-2.55H3v-2h8.175l-2.55-2.55L10 7l5 5l-5 5Z"/>
                                        </svg>
                                    </a>
                                </div>
                                
                                
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Add SweetAlert JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/libs/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.bootstrap4.js') }}"></script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize DataTables
        $('#studentsTable').DataTable({
            responsive: true,
            ordering: true,
            searching: true,
            paging: true,
            columnDefs: [
                { targets: -1, orderable: false } 
            ]
        });

        const forms = document.querySelectorAll('.approve-form');
        forms.forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to approve this student?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, approve it!',
                    cancelButtonText: 'No, cancel!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const formData = new FormData(form);

                        $.ajax({
                            url: form.action,
                            method: form.method,
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function () {
                                Swal.fire({
                                    title: 'Approved!',
                                    text: 'student has been approved.',
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function () {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something went wrong. Please try again.',
                                    icon: 'error',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            });
        });

        $('.reject-form').on('submit', function (event) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to reject this student?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, reject it!',
                cancelButtonText: 'No, cancel!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = $(this);
                    $.ajax({
                        url: form.attr('action'),
                        method: form.attr('method'),
                        data: form.serialize(),
                        success: function (response) {
                            Swal.fire({
                                title: 'Rejected!',
                                text: 'The student has been rejected.',
                                icon: 'success',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function () {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Something went wrong. Please try again.',
                                icon: 'error',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });

        const disableForms = document.querySelectorAll('.btn-disable');
        disableForms.forEach(form => {
            form.addEventListener('click', function (event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to disable this student?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, disable it!',
                    cancelButtonText: 'No, cancel!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = $(this).closest('form');
                        $.ajax({
                            url: form.attr('action'),
                            method: form.attr('method'),
                            data: form.serialize(),
                            success: function () {
                                Swal.fire({
                                    title: 'Disabled!',
                                    text: 'The student has been disabled.',
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function () {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something went wrong. Please try again.',
                                    icon: 'error',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            });
        });

        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to delete this student?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const formData = new FormData(form);

                        $.ajax({
                            url: form.action,
                            method: form.method,
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function () {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'The student has been deleted.',
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function () {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something went wrong. Please try again.',
                                    icon: 'error',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            });
        });
    });
</script>
@endpush
