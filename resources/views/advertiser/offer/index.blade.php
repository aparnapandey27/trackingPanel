@extends('advertiser.layout.app')
@section('title', 'Offers')

@push('style')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('assets/libs/flag-icons/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
@endpush

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- Start Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ __('Offers') }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ __('Offers') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Manage') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Title -->

        <!-- Card for Page Header -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-2 align-items-center">
                    <div class="col-sm-4">
                        <h4 class="m-0 font-weight-bold text-primary">Manage Offers</h4>
                    </div>
                    <div class="col-sm-auto ms-auto">
                        <a class="btn btn-primary" href="{{ route('advertiser.offer.create') }}">Add Offer</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Offers Table -->
        <div class="card shadow-lg border-left-dark">
            <div class="card-header">
                <h6 class="card-title mb-0 text-primary">All Offers</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="offers">
                        <thead class="table-light text-muted">
                            <tr>
                                <th>ID</th>
                                <th>Preview</th>
                                <th>Offer Name</th>
                                <th>Status</th>
                                <th>Category</th>
                                <th>Devices</th>
                                <th>Model</th>
                                <th>Revenue</th>
                                <th>Countries</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($offers as $offer)
                                <tr>
                                    <td>{{ $offer->id }}</td>
                                    <td><img src="{{ asset('storage/offers/' . $offer->thumbnail) }}" width="50"></td>
                                    <td>{{ $offer->name }}</td>
                                    <td>
                                        @if ($offer->status == 1)
                                            <span class="badge bg-success text-uppercase">Active</span>
                                        @elseif ($offer->status == 2)
                                            <span class="badge bg-danger text-uppercase">Closed</span>
                                        @elseif ($offer->status == 3)
                                            <span class="badge bg-danger text-uppercase">Expired</span>
                                        @else
                                            <span class="badge bg-warning text-uppercase">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $offer->category ? $offer->category->name : 'N/A' }}</td>
                                    <td>
                                        @foreach($offer->devices as $device)
                                            @if ($device->name == 'Desktop')
                                                <i class="bx bx-desktop"></i>
                                            @elseif ($device->name == 'Tablet')
                                                <i class="bx bx-tab"></i>
                                            @elseif ($device->name == 'Mobile')
                                                <i class="bx bx-mobile"></i>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $offer->offer_model }}</td>
                                    <td>{{ $offer->default_revenue }}</td>
                                    <td>
                                        @foreach ($offer->countries as $country)
                                            <span class="flag-icon flag-icon-{{ strtolower($country->code) }}"></span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ route('advertiser.offer.show', $offer->id) }}" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">No offers found</td>
                                </tr>
                            @endforelse
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
        'processing': true,
        'serverSide': true,
        'ajax': '{{ route('advertiser.offer.index') }}',
        'columns': [
            { data: 'id' },
            { data: 'thumbnail', orderable: false, searchable: false },
            { data: 'name' },
            { data: 'status' },
            { data: 'category' },
            { data: 'device' },
            { data: 'revenue' },
            { data: 'payout' },
            { data: 'countries', orderable: false, searchable: false },
            { data: 'action', orderable: false, searchable: false },
        ]
    });
        })

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        function deleteOffer(id) {
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
                        url: '/advertiser/offer/delete/' + id,
                        type: 'DELETE',

                        success: function(res) {
                            $('#offers').DataTable().ajax.reload();
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Offer has been deleted',
                                showConfirmButton: false,
                                timer: 8000
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
@endpush

