@extends('admin.layout.app')
@section('title', 'IP WhiteListing Details')
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-daterangepicker/daterangepicker.css') }}">
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-4">{{__('IP Address')}}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">{{__('IP WhiteListing')}}</a>
                                </li>
                                <li class="breadcrumb-item active">{{__('Manage')}}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-12">
                    <div class="card mb-12 shadow-lg border-left-dark">
                        <div class="card-header">
                            <h6 class="card-title mb-0 flex-grow-1 text-primary">IP Whitelisting Details</h6>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><span class="text-muted">#ID:</span> {{ $ipaddr->id }}</p>
                            <p class="card-text"><span class="text-muted">Advertiser:</span>
                                <a
                                    href="{{ route('admin.advertisers.manage', $ipaddr->advertiser_id) }}">{{ $ipaddr->advertiser->name }}</a>
                            </p>
                            <p class="card-text"><span class="text-muted">IP Address:</span> {{ $ipaddr->ipaddress }}</p>
                            <p class="card-text"><span class="text-muted">Status:</span>
                                @if ($ipaddr->status == 1)
                                    <span class="badge btn-primary">Active</span>
                                @elseif ($ipaddr->status == 2)
                                    <span class="badge badge-danger">Rejected</span>
                                @else
                                    <span class="badge badge-danger">Pending</span>
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
