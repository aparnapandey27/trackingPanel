@extends('admin.layout.app')
@section('title', 'Conversion Logs')
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/dataTables.bootstrap4.css') }}">

    
@endpush



@section('content')
<div class="page-content">
	<div class="container-fluid">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-4">{{__('Conversion Logs')}}</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">{{__('Report')}}</a>
                    </li>
                    <li class="breadcrumb-item active">{{__('Conversion Logs')}}</li>
                </ol>
            </div>
        </div>
        <form action="{{ route('admin.report.conversion.log') }}" method="get" id="report-form">
            
        <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4 shadow-lg">
                <div class="card-header d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#filterOptions">
                    <h6 class="m-0 text-primary font-weight-bold">Filter Options</h6>
                    <i class="mdi mdi-align-vertical-distribute"></i>
                </div>                   
                        
                
                <div class="card-body collapse" id="filterOptions">
                    
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
        
            <div class="card shadow-lg border-left-dark">
                <div class="card-header">
                    <h6 class="card-title mb-0 flex-grow-1 text-primary">
                        Conversion Logs
                    </h6>
                </div>
                <div class="card-body">
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="log">
                            <thead class="text-muted table-light">
                                <tr>
                                    <th>S.No</th>
                                    <th>ID</th>
                                    <th>student</th>
                                    <th>Offer</th>
                                    <th>Advertiser</th>
                                    <th>Event</th>
                                    <th>Status</th>
                                    <th>Conversion IP</th>
                                    <th>Transaction ID</th>
                                    <th>Revenue</th>
                                    <th>Payout</th>
                                    <th>Profit</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($conversions as $conversion)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{ $conversion->id }}</td>
                                        <td>
                                            <a href="{{ route('admin.students.manage', optional($conversion->student)->id) }}">
                                                {{ optional($conversion->student)->name ?? 'N/A' }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.offers.show', optional($conversion->offer)->id) }}">
                                                {{ optional($conversion->offer)->name ?? 'N/A' }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.advertisers.manage', optional($conversion->advertiser)->id) }}">
                                                {{ optional($conversion->advertiser)->name ?? 'N/A' }}
                                            </a>
                                        </td>
                                        <td>{{ $conversion->name }}</td>
                                        <td>{{ $conversion->status }}</td>
                                        <td>{{ $conversion->conversion_ip }}</td>
                                        <td>{{ $conversion->click_transaction_id }}</td>
                                        <td>{{ $conversion->revenue }} {{ $conversion->currency }}</td>
                                        <td>{{ $conversion->payout }} {{ $conversion->currency }}</td>
                                        <td>{{ ($conversion->revenue - $conversion->payout) }} {{ $conversion->currency }}</td>
                                        <td>
                                            <a title="Make this conversion {{ $conversion->status == 'approved' ? 'pending' : 'approved' }}"
                                                class="btn text-primary"
                                                href="javascript:void(0)"
                                                onclick="updateStatus({{ $conversion->id }}, '{{ $conversion->status == 'approved' ? 'pending' : 'approved' }}')"
                                                style="font-size:12px;">
                                                <i class="{{ $conversion->status == 'approved' ? 'ri-time-fill' : 'ri-check-line' }}" aria-hidden="true"></i>
                                                {{ $conversion->status == 'approved' ? 'Set as Pending' : 'Approve' }}
                                             </a>
                                             
                                             <a title="Reverse this conversion"
                                                class="btn text-success"
                                                href="javascript:void(0)"
                                                onclick="updateStatus({{ $conversion->id }}, 'reversed')"
                                                style="font-size:12px;">
                                                <i class="ri-arrow-go-back-fill" aria-hidden="true"></i>
                                                Reverse
                                             </a>
                                             
                                             <a title="Decline/Reject this conversion"
                                                class="btn text-danger"
                                                href="javascript:void(0)"
                                                onclick="updateStatus({{ $conversion->id }}, 'declined')"
                                                style="font-size:12px;">
                                                <i class="ri-close-line" aria-hidden="true"></i>
                                                Decline
                                             </a>
                                             
                                        </td>
                                        


                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                        {{ $conversions->appends(request()->except('page'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
    
@endsection
@push('scripts')
    <!-- SweetAlert2-->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    <script>
        function updateStatus(id, status) {
            swal.fire({
                title: 'Are you sure?',
                text: "You want to change the status!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: `/admin/conversion/update/${id}`,
                        type: "POST",
                        data: {
                            id: id,
                            status: status,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            swal.fire(
                                'Updated!',
                                'Status has been updated.',
                                'success'
                            )
                            setTimeout(function() {
                                window.location.reload(1);
                            }, 1500);
                        },
                        error: function(data) {
                            swal.fire(
                                'Oops...',
                                'Something went wrong!',
                                'error'
                            )
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('#log').DataTable({
                dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
            buttons: [
            {
                extend: 'copy',
                className: 'btn-sm btn-info',
                title: 'Conversion log',
                header: true,
                footer: true,
                exportOptions: {
                    // columns: ':visible'
                }
            },
            {
                extend: 'csv',
                className: 'btn-sm btn-success',
                title: 'Conversion log',
                header: true,
                footer: true,
                exportOptions: {
                    // columns: ':visible'
                }
            },
            {
                extend: 'excel',
                className: 'btn-sm btn-warning',
                title: 'Conversion log',
                header: true,
                footer: true,
                exportOptions: {
                    // columns: ':visible',
                }
            },
            {
                extend: 'pdf',
                className: 'btn-sm btn-primary',
                title: 'Conversion log',
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
                title: 'Conversion log',
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
