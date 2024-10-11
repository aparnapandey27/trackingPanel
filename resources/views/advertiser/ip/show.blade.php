@extends('advertiser.layout.app')
@section('title', ' IP WhiteListing Details')
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-daterangepicker/daterangepicker.css') }}">
@endpush

@section('content')
<div class="page-content">
    <div class="container-fluid"> 
    <div class="row">
        <div class="col-lg-12 mb-12">
            <div class="card mb-12 shadow-lg border-left-dark">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">IP Whitelisting Details</h6>
                </div>
                <div class="card-body">
                    <p class="card-text"><span class="text-muted">#ID:</span> {{ $ipaddr->id }}</p>
                    <p class="card-text"><span class="text-muted">Advertiser:</span> {{ $ipaddr->advertiser_id }}
                    </p>
                    <p class="card-text"><span class="text-muted">IP Address:</span> {{ $ipaddr->ipaddress }}</p>
                    <p class="card-text"><span class="text-muted">Status:</span>
                        @if ($ipaddr->status == 1)
                            <span class="badge bg-success-subtle text-success text-uppercase">Active</span>
                        @elseif ($ipaddr->status == 2)
                            <span class="badge bg-danger-subtle text-danger text-uppercase">Rejected</span>
                        @else
                            <span class="badge bg-warning-subtle text-warning text-uppercase">Pending</span>
                        @endif
                    </p>
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
    <!-- Select2 -->
    <script src="{{ asset('assets/libs/select2/select2.full.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        
    </script>
    <script src="{{ asset('assets/libs/moment/moment.js') }}"></script>
    
@endpush
