@extends('admin.layout.app')
@section('title', 'Email')
@push('style')
@endpush
@section('content')
    <div class="page-content">
        <div class="container-fluid">        
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-4">{{__('Email')}}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{__('Prefernce')}}</a></li>
                                <li class="breadcrumb-item active">{{__('Email')}}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4 border-left-dark shadow-lg">
                        <div class="card-header">
                            <h6 class="card-title mb-0 flex-grow-1 text-primary">Customize SMTP Mail Setting</h6>
                        </div>
                        <div class="card-body row">
                    
                            <form action="{{ route('admin.preference.company.update') }}" method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="app_host">SMTP Host</label>
                                    <input type="text" name="MAIL_HOST" id="app_host" class="form-control"
                                        value="{{ config('mail.mailers.smtp.host') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="app_host">SMTP Port</label>
                                    <input type="text" name="MAIL_PORT" id="app_host" class="form-control"
                                        value="{{ config('mail.mailers.smtp.port') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="app_host">Encryption</label>
                                    <input type="text" name="MAIL_ENCRYPTION" id="app_host" class="form-control"
                                        value="{{ config('mail.mailers.smtp.encryption') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="app_host">Username</label>
                                    <input type="text" name="MAIL_USERNAME" id="app_host" class="form-control"
                                        value="{{ config('mail.mailers.smtp.username') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="app_host">Password</label>
                                    <input type="password" name="MAIL_PASSWORD" id="app_host" class="form-control"
                                        value="{{ config('mail.mailers.smtp.password') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="app_host">Sender Name</label>
                                    <input type="text" name="MAIL_FROM_NAME" id="app_host" class="form-control"
                                        value="{{ config('mail.from.name') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="app_host">Sender Address</label>
                                    <input type="email" name="MAIL_FROM_ADDRESS" id="app_host" class="form-control"
                                        value="{{ config('mail.from.address') }}">
                                </div>
                                <button class="btn btn-primary" type="submit">Update</button>
                            </form>                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection

