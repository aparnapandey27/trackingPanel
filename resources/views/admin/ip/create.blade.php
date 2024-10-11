@extends('admin.layout.app')
@section('title', 'Create IP Address')
@push('style')    
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-4">{{__('Add IP Address')}}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">{{__('IP WhiteListing')}}</a>
                        </li>
                        <li class="breadcrumb-item active">{{__('Add IP Address')}}</li>
                    </ol>
                </div>
            </div>
            <div class="card shadow-lg border-left-dark">
                <div class="card-header">
                    <h6 class="card-title mb-0 flex-grow-1 text-primary">Add IP Address</h6>
                </div>                                
                <div class="card-body">
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <strong>Error!</strong> {{ $error }}.
                        </div>
                    @endforeach                
                    <form action="{{ route('admin.ip.store') }}" method="POST">
                        @csrf
                        <div class="form-group row mb-3 @error('advertiser_id') has-error @enderror">
                                <label class="col-sm-3 col-form-label" for="advertiser_id">Advertiser</label>
                                <div class="col-sm-12">
                                    <select id="advertiser_id" name="advertiser_id" class="form-control selectpicker user-select" >
                                        <option disabled selected>Choose...</option>

                                        @foreach ($advertisers as $advertiser)
                                            <option value="{{ $advertiser->id }}">{{ $advertiser->name }}</option>
                                        @endforeach

                                    </select>
                                    @error('advertiser_id')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <span class="help-block text-danger" ></span>
                                </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label" for="ipaddress">IP Address</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control ipaddress @error('ipaddress') is-invalid @enderror" 
                                       name="ipaddress" id="ipaddress" required
                                       placeholder="IP Address format: 255:255:255:255" 
                                       pattern="^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$">
                                @error('ipaddress')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label" for="statuss">Status</label>
                            <div class="col-sm-12">
                                <select id="statuss" name="status" class="form-select status @error('status') is-invalid @enderror">
                                    <option disabled selected>Choose...</option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Pending</option>
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <button class="btn btn-primary" type="submit">Add IP Address</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>      
@endsection

@push('scripts')
    <!-- Select2 -->
    <script src="{{ asset('assets/libs/select2/select2.full.min.js') }}"></script>
@endpush
