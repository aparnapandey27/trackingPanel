@extends('admin.layout.app')

@section('title', 'Click Logs')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/libs/flag-icons/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/dataTables.bootstrap4.css') }}">
@endpush

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-4">{{ __('Click Logs') }}</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">{{ __('Report') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('Click Logs') }}</li>
                </ol>
            </div>
        </div>

        <div class="card mb-4 shadow-lg">
            <div class="card-header d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#filterOptions">
                <h6 class="m-0 text-primary font-weight-bold">Filter Options</h6>
                <i class="mdi mdi-align-vertical-distribute"></i>
            </div>

                    <div class="card-body collapse" id="filterOptions">
                        <form action="{{ route('admin.report.click.log') }}" method="get" id="report-form">
                            <div class="row">
                                <div class="col-lg-4 mb-4">
                                    <label for="student">Students</label>
                                    <select name="students[]" id="student" multiple class="form-control students"
                                        data-placeholder="Choose students">
                                    </select>
                                </div>
                                <div class="col-lg-4 mb-4">
                                    <label for="offer">Offers</label>
                                    <select name="offers[]" id="offer" multiple class="form-control offers"
                                        data-placeholder="Choose offers">
                                    </select>
                                </div>
                                <div class="col-lg-4 mb-4">
                                    <label for="click_id">Click/Transaction ID</label>
                                    <input type="text" name="click_data" class="form-control" id="click_id"
                                        placeholder="Ex. 6e41df0b4a6fd3d540d2743c066027"
                                        value="{{ old('click_data') ?? request()->click_data }}">
                                </div>
                                <div class="row g-3 mb-4 align-items-center">
                                <input type="hidden" name="download" id="download" value="false">
                                <div class="col-xl-10">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <button type="submit" class="btn btn-primary">
                                                Search
                                            </button>
                                        </div>                                        
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <button type="button" class="btn btn-success" onclick="downloadReport()">
                                        <i class="ri-download-2-fill" aria-hidden="true"></i> Download Report
                                    </button>
                                </div>											
                            </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Click Logs Table -->
                <div class="card mb-4 shadow-lg border-left-dark">
                    <div class="card-header">
                        <h6 class="card-title mb-0 flex-grow-1 text-primary">{{ __('Click Logs') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="dataTable">
                                <thead class="text-muted table-light">
                                    <tr>
                                        <th>{{ __('S.No') }}</th>
                                        <th>{{ __('ID') }}</th>
                                        <th>{{ __('Student') }}</th>
                                        <th>{{ __('Offer') }}</th>
                                        <th>{{ __('Advertiser') }}</th>
                                        <th>{{ __('Session IP') }}</th>
                                        <th>{{ __('Transaction ID') }}</th>
                                        <th>{{ __('Conversion') }}</th>
                                        <th>{{ __('Paytm No') }}</th>
                                        <th>{{ __('Country') }}</th>
                                        <th>{{ __('Device') }}</th>
                                        <th>{{ __('Browser') }}</th>
                                        <th>{{ __('Clicked') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($clicks as $click)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $click->id }}</td>
                                            <td>
                                                <a href="{{ route('admin.students.manage', optional($click->student)->id) }}">
                                                    {{ optional($click->student)->name ?? 'N/A' }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.offers.show', optional($click->offer)->id) }}">
                                                    {{ optional($click->offer)->name ?? 'N/A' }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.advertisers.manage', optional($click->advertiser)->id) }}">
                                                    {{ optional($click->advertiser)->name ?? 'N/A' }}
                                                </a>
                                            </td>
                                            <td>{{ $click->ip_address }}</td>
                                            <td>{{ $click->transaction_id }}</td>
                                            <td>{{ $click->conversions_count }}</td>
                                            <td>{{ $click->paytm_no }}</td>
                                            <td>{{ $click->country }}</td>
                                            <td>{{ $click->device_type }}</td>
                                            <td>{{ $click->browser_name }}</td>
                                            <td>{{ $click->created_at }}</td>
                                            <td>
                                                <button class="btn btn-success" onclick="updateStatus({{ $click->id }})">{{ __('Convert') }}</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="14" class="text-center">{{ __('No clicks found.') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
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
    <script src="{{ asset('assets/libs/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.bootstrap4.js') }}"></script>
    <!-- SweetAlert2-->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        function updateStatus(id, status) {
            swal.fire({
                title: 'Confirmation?',
                text: "You want to convert this click!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, convert it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: `/admin/click/convert/${id}`,
                        type: "POST",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            swal.fire(
                                'Success!',
                                'Click has been converted to conversion.',
                                'success'
                            )
                            setTimeout(function() {
                                window.location.reload(1);
                            }, 500);
                        },
                        error: function(data) {
                        console.log(data); // Inspect the response in the console
                        swal.fire(
                            'Oops...',
                            data.responseJSON?.message || 'Something went wrong!',
                            'error'
                        );
                    }
                    });
                }
            })
        }
    </script>
    <!-- Select2 -->
    <script src="{{ asset('assets/libs/select2/select2.full.min.js') }}"></script>
    <script>
        $('.students').select2({
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

        $('.offers').select2({
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
    <script>
        function downloadReport() {
            // Set the 'download' input field to 'true'
            document.getElementById('download').value = true;
            document.getElementById('report-form').submit();
        }
    </script>
    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    <script type="text/javascript">
            $(document).ready(function() {
                $('#dataTable').DataTable({
                    dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                buttons: [
                {
                    extend: 'copy',
                    className: 'btn-sm btn-info',
                    title: 'Click Logs',
                    header: true,
                    footer: true,
                    exportOptions: {
                        // columns: ':visible'
                    }
                },
                {
                    extend: 'csv',
                    className: 'btn-sm btn-success',
                    title: 'Click Logs',
                    header: true,
                    footer: true,
                    exportOptions: {
                        // columns: ':visible'
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn-sm btn-warning',
                    title: 'Click Logs',
                    header: true,
                    footer: true,
                    exportOptions: {
                        // columns: ':visible',
                    }
                },
                {
                    extend: 'pdf',
                    className: 'btn-sm btn-primary',
                    title: 'Click Logs',
                    pageSize: 'A2',
                    header: true,
                    footer: true,
                    exportOptions: {
                        // columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    className: 'btn-sm btn-danger',
                    title: 'Click Logs',
                    // orientation:'landscape',
                    pageSize: 'A2',
                    header: true,
                    footer: false,
                    orientation: 'landscape',
                    exportOptions: {
                        // columns: ':visible',
                        stripHtml: false
                    }
                }
            ],
                });
                
            });
        </script>
@endpush

