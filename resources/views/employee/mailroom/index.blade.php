@extends('employee.layout.app')
@push('page_title')
    Mail Room
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/libs/summernote/summernote.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-lg border-left-dark">
                <div class="card-header with-border">
                    <h6 class="m-0 font-weight-bold text-primary">Mail Room</h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
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
                                <div class="form-group">
                                    <label id="user_type">User Type</label>
                                    <select name="user" id="user_role" class="form-control" data-placeholder="User Type">
                                        <option value="student">Student</option>
                                        <option value="advertiser">Advertiser</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Select User</label>
                                    <select id="student" name="to[]" class="form-control" multiple
                                        data-placeholder="User type select first">
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <input type="text" class="form-control" id="subject" name="mailer_subject"
                                        placeholder="Subject">
                                </div>
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea class="form-control" id="msgbody" name="mailer_message"
                                        rows="10"></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/libs/summernote/summernote.min.js') }}"></script>
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
        $(document).ready(function() {
            $('#msgbody').summernote({
                tabsize: 2,
                height: 300,
                codemirror: { // codemirror options
                    theme: 'superhero'
                },
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>
@endpush
