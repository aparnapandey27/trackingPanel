@extends('advertiser.layout.app')
@section('title', 'Edit IP')
@push('style')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
    
@endpush


@section('content')
<div class="page-content">
                <div class="container-fluid"> 
    <div class="mb-4">
        <h1 class="h3 mb-2 text-gray-800">Edit IP Address</h1>
    </div>
    <div class="card shadow-lg border-left-dark">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Edit IP Address</h6>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('advertiser.ip.update', $ipaddr->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body row">
                <div class="col-lg-12 col-md-6">
                    
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="ipaddress">IP Address</label>
                        <div class="col-sm-9 col-md-6">
                          <input type="text" class="form-control ipaddress" name="ipaddress" id="ipaddress" required
                            placeholder="IP Address format:255:255:255:255" 
                            required pattern="^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$"
                            value="{{ $ipaddr->ipaddress }}"> 
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="status">Status</label>
                        <div class="col-sm-9 col-md-6">
                            <select name="status"  class=" form-control status">
                                <option disabled selected>Choose...</option>
                                <option value="0" {{ $ipaddr->status == 0 ? 'selected' : '' }}>Pending</option>
                                <option value="1" {{ $ipaddr->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="1" {{ $ipaddr->status == 2 ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Update IP Address</button>
                </div>
            </div>
        </form>
      </div>
   </div>
</div>


@endsection

@push('scripts')
    <!-- Select2 -->
    <script src="{{ asset('assets/libs/select2/select2.full.min.js') }}"></script>
    
@endpush
