@extends('admin.layout.app')

@section('content')
<div class="container-fluid py-4">
    <h6 class="mb-0">{{ __('advertiser Dashboard') }}</h6>
    <div class="card mt-4">
        <div class="card-header pb-0 px-3">
            <h6 class="mb-0">{{ __('Manage advertisers') }}</h6>
        </div>
        <div class="card-body pt-4 p-3">
            <a href="{{ route('admin.advertisers.create') }}" class="btn btn-primary">Add advertiser</a>
            <a href="{{ route('admin.advertisers.manage') }}" class="btn btn-secondary">Manage advertisers</a>
        </div>
    </div>
</div>
@endsection
