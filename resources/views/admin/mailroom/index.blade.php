@extends('admin.layout.app')
@section('title', 'Mail Room')
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/libs/summernote/summernote-lite.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
@endpush
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-4">{{__('Mail Room')}}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">{{__('Mail Room')}}</a>
                                </li>
                                <li class="breadcrumb-item active">{{__('Mail')}}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-lg border-left-dark">
                        <div class="card-header with-border">
                            <h6 class="card-title mb-0 flex-grow-1 text-primary">Mail Room</h6>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
                                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="{{ route('admin.mailroom.send') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <label id="user_type">User Type</label>
                                            <select name="user" id="user_role" class="form-control" data-placeholder="User Type">
                                                <option value="student">Student</option>
                                                <option value="advertiser">Advertiser</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Select User</label>
                                            <select id="student" name="to[]" class="form-control" multiple
                                                data-placeholder="User type select first">
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="subject">Subject</label>
                                            <input type="text" class="form-control" id="subject" name="mailer_subject"
                                                placeholder="Subject">
                                        </div>
                                        
                                        <div class="form-group mb-3">
                                            <label for="message">Message</label>
                                            <textarea id="summernote" name="mailer_message"></textarea>                                            
                                        </div>
                                        <div class="text-center mb-3">
                                            <button type="submit" class="btn btn-primary">Send</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/libs/summernote/summernote-lite.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets/libs/select2/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var user_type = document.querySelector('#user_role');
            $('#student').select2({
                ajax: {
                    url: function() {
                        var user_type = document.querySelector('#user_role')
                        if (user_role.value == 'advertiser') {
                            return '{{ route('admin.getUsers') }}' + '?user_role=advertiser'
                        } else {
                            return '{{ route('admin.getUsers') }}' + '?user_role=publisher'
                        }
                    },
                    dataType: 'json',
                    data: function(params) {
                        return {
                            search: params.term
                        }
                    },
                    processResults: function(response) {
                        if (response.length > 0) {
                            response.unshift({
                                id: -1,
                                text: "ALL"
                            })
                        }
                        return {
                            results: response
                        }
                    },
                    cache: true,
                    width: 'resolve'
                }
            });
            $('#student').on('select2:select', function(e) {
                if ($('#student').val().includes('-1')) {
                    $('#student').val(['-1']).trigger('change')
                }
            });
        });
    </script>

    <script>
        $('#summernote').summernote({
            height: 300,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: true                  // set focus to editable area after initializing summernote
        });
    </script>
@endpush
