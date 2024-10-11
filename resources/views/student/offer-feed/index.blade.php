@extends('student.layout.app')
@section('title', 'Offer Feed')
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/libs/icomoon/style.css') }}">
@endpush
@push('page_title')
    Offer Feed
@endpush
@section('content')
<div class="page-content">
    <div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-lg">
                <div class="card-header with-border">
                    <h6 class="m-0 text-primary font-weight-bold">Offer Feed</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="offer_feed">Your Offer Feed URL</label>
                        <input type="text" class="form-control" id="offer_feed"
                            value="{{ asset('/') }}offer/feed?stuid={{ auth()->id() }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
