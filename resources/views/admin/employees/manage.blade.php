@extends('admin.layout.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/flag-icons/css/flag-icon.min.css?v=52475656') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
@endpush

@section('content')
<div class="container-fluid py-4">
    {{-- <h6 class="mb-0">{{ __('Manage employees') }}</h6> --}}

    <div class="card">
        <div class="card-body">
            <div class="row g-2 align-items-center">
                <div class="col-sm-4">
                    <h4 class="m-0 font-weight-bold text-primary">Manage Employee</h4>
                </div>
                <div class="col-sm-auto ms-auto">
                    <div class="list-grid-nav hstack gap-1">
                        <a class="btn btn-primary" href="{{ route('admin.employees.create') }}">Add Employee</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <div class="card mt-4">
        <div class="card-header pb-0 px-3">
            <h6 class="mb-0">{{ __('List of employees') }}</h6>
        </div>

        <div class="card-body pt-4 p-3">
            <!-- Table of employees -->
            <table id="employeesTable" class="table table-striped table-bordered table-light">
                <thead>
                    <tr>
                        <th style="padding: 1rem;">{{ __('ID') }}</th>
                        <th style="padding: 1rem;">{{ __('Name') }}</th>
                        <th style="padding: 1rem;">{{ __('Email') }}</th>
                        <th style="padding: 1rem;">{{ __('Status') }}</th>
                        <th style="padding: 1rem;">{{ __('Role') }}</th>
                        <th style="padding: 1rem;">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $employee)
                        <tr class="table-hover">
                            <td style="padding: 1rem;">{{ $employee->id }}</td>
                            <td style="padding: 1rem;">{{ $employee->name }}</td>
                            <td style="padding: 1rem;">{{ $employee->email }}</td>
                            <td style="padding: 1rem;">{!! $employee->status_badge !!}</td>
                            <td style="padding: 1rem;">{{ $employee->role }}</td>
                            <td>
                                <div class="d-flex">
                                    <!-- Confirm Button -->
                                    <form action="{{ route('admin.employees.confirm', $employee->id) }}" method="POST" class="approve-form" data-employee-id="{{ $employee->id }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-custom btn-confirm" style="background-color: yellowgreen; color: white; padding: 10px 15px; border: none; border-radius: 5px; margin-right: 10px;">
                                            <i class="fa fa-check fa-lg"></i>
                                        </button>
                                    </form>
                                
                                    <!-- Reject Button -->
                                    <form action="{{ route('admin.employees.reject', $employee->id) }}" method="POST" class="reject-form" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-custom btn-reject" style="background-color: rgb(56, 187, 161); color: white; padding: 10px 15px; border: none; border-radius: 5px; margin-right: 10px;">
                                            <i class="fa fa-times fa-lg"></i>
                                        </button>
                                    </form>
                                
                                    <!-- Disable Button -->
                                    <form action="{{ route('admin.employees.disable', $employee->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-custom btn-disable" style="background-color: red; color: white; padding: 10px 15px; border: none; border-radius: 5px; margin-right: 10px;">
                                            <i class="fa fa-ban fa-lg"></i>
                                        </button>
                                    </form>
                                
                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.employees.edit', $employee->id) }}" class="btn btn-custom btn-edit" style="background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 5px; margin-right: 10px;">
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                
                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="POST" class="delete-form" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-custom btn-delete" style="background-color: rgb(65, 65, 227); color: white; padding: 10px 15px; border: none; border-radius: 5px; margin-right: 10px;">
                                            <i class="fa fa-trash fa-lg"></i>
                                        </button>
                                    </form>
                                
                                    <!-- Login Button -->
                                    <a href="{{ route('admin.loginAs', $employee->id) }}" class="btn btn-info btn-sm" title="Sign in to this account" style="background-color: #17a2b8; color: white; padding: 10px 15px; border: none; border-radius: 5px;">
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
@endsection

@push('scripts')
    

<!-- Add SweetAlert JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JavaScript and CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            Swal.fire({
                title: 'Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize DataTables
        $('#employeesTable').DataTable();

        const forms = document.querySelectorAll('.approve-form');
        forms.forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to approve this employee?',
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
                                    text: 'Employee has been approved.',
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
                text: 'Do you want to reject this employee?',
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
                                text: 'The employee has been rejected.',
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
                    text: 'Do you want to disable this account?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, disable it!',
                    cancelButtonText: 'No, cancel!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const formData = new FormData(this.closest('form'));

                        $.ajax({
                            url: this.closest('form').action,
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function () {
                                Swal.fire({
                                    title: 'Disabled!',
                                    text: 'Employee account has been disabled.',
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

        $('.btn-delete').on('click', function (event) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to delete this employee?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = $(this).closest('form');
                    $.ajax({
                        url: form.attr('action'),
                        method: form.attr('method'),
                        data: form.serialize(),
                        success: function (response) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Employee has been deleted.',
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
</script>
@endpush

