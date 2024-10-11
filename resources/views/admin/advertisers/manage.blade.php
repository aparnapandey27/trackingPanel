@extends('admin.layout.app')

@push('style')
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/flag-icons/css/flag-icon.min.css?v=52475656') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-body">
            <div class="row g-2 align-items-center">
                <div class="col-12 col-sm-8">
                    <h4 class="m-0 font-weight-bold text-primary">Manage Advertiser</h4>
                </div>
                <div class="col-12 col-sm-4 text-end">
                    <div class="list-grid-nav hstack gap-1">
                        <a class="btn btn-primary" href="{{ route('admin.advertisers.create') }}">Add Advertiser</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <div class="card mt-4">
        <div class="card-header pb-0 px-3">
            <h6 class="mb-0">{{ __('List of Advertisers') }}</h6>
        </div>

        <div class="card-body pt-4 p-3">
            <!-- Table of advertisers -->
            <div class="table-responsive">
                <table id="advertisersTable" class="table table-striped table-bordered table-light">
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Company Name') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($advertisers as $advertiser)
                            <tr class="table-hover">
                                <td>{{ $advertiser->id }}</td>
                                <td>{{ $advertiser->company_name }}</td>
                                <td>{{ $advertiser->name }}</td>
                                <td>{{ $advertiser->email }}</td>
                                <td>{!! $advertiser->status_badge !!}</td>
                                <td>
                                    <div class="d-flex">
                                        <!-- Confirm Button -->
                                        <form action="{{ route('admin.advertisers.confirm', $advertiser->id) }}" method="POST" class="approve-form" data-advertiser-id="{{ $advertiser->id }}" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-custom btn-confirm" style="background-color: yellowgreen; color: white; padding: 10px 15px; border: none; border-radius: 5px; margin-right: 10px;">
                                                <i class="fa fa-check fa-lg"></i>
                                            </button>
                                        </form>
                                    
                                        <!-- Reject Button -->
                                        <form action="{{ route('admin.advertisers.reject', $advertiser->id) }}" method="POST" class="reject-form" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-custom btn-reject" style="background-color: rgb(56, 187, 161); color: white; padding: 10px 15px; border: none; border-radius: 5px; margin-right: 10px;">
                                                <i class="fa fa-times fa-lg"></i>
                                            </button>
                                        </form>
                                    
                                        <!-- Disable Button -->
                                        <form action="{{ route('admin.advertisers.disable', $advertiser->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-custom btn-disable" style="background-color: red; color: white; padding: 10px 15px; border: none; border-radius: 5px; margin-right: 10px;">
                                                <i class="fa fa-ban fa-lg"></i>
                                            </button>
                                        </form>
                                    
                                        <!-- Edit Button -->
                                        <a href="{{ route('admin.advertisers.edit', $advertiser->id) }}" class="btn btn-custom btn-edit" style="background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 5px; margin-right: 10px;">
                                            <i class="fa fa-edit fa-lg"></i>
                                        </a>
                                    
                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.advertisers.destroy', $advertiser->id) }}" method="POST" class="delete-form" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-custom btn-delete" style="background-color: rgb(65, 65, 227); color: white; padding: 10px 15px; border: none; border-radius: 5px; margin-right: 10px;">
                                                <i class="fa fa-trash fa-lg"></i>
                                            </button>
                                        </form>
                                    
                                        <!-- Login Button -->
                                        <a href="{{ route('admin.loginAs', $advertiser->id) }}" class="btn btn-info btn-sm" title="Sign in to this account" style="background-color: #17a2b8; color: white; padding: 10px 15px; border: none; border-radius: 5px;">
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
        $('#advertisersTable').DataTable({
            responsive: true,
            ordering: true,
            searching: true,
            paging: true,
            columnDefs: [
                { targets: -1, orderable: false }  // Disable ordering for action column
            ]
        });

        const forms = document.querySelectorAll('.approve-form');
        forms.forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to approve this advertiser?',
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
                                    text: 'Advertiser has been approved.',
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
                text: 'Do you want to reject this advertiser?',
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
                                text: 'The advertiser has been rejected.',
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
                    text: 'Do you want to disable this advertiser?',
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
                                    text: 'The advertiser has been disabled.',
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
                    text: 'Do you want to delete this advertiser?',
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
                                    text: 'The advertiser has been deleted.',
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
