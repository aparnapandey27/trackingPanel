@extends('admin.layout.app')
@section('title', 'Application Customize')
@push('style')
@endpush
@section('content')
    <div class="page-content">
        <div class="container-fluid">        
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-4">{{__('Application Customize')}}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{__('Prefernce')}}</a></li>
                                <li class="breadcrumb-item active">{{__('Application Customize')}}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-lg-6">
                    <div class="card mb-4 border-left-dark shadow-lg">
                        <div class="card-header">
                            <h6 class="card-title mb-0 flex-grow-1 text-primary">Signup Additional Question</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Question</th>
                                            <th>for</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($questions as $question)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $question->title }}</td>
                                                <td>
                                                    {{ $question->for }}
                                                </td>
                                                <td>
                                                    <button class="btn btn-primary" type="button"
                                                        onclick="event.preventDefault();
                                                                            document.getElementById('del-form').submit();">Delete</button>
                                                    <form id="del-form"
                                                        action="{{ route('admin.preference.additional_question_delete', $question->id) }}"
                                                        method="POST" STYLE="display: none">
                                                        @csrf
                                                        @method("delete")

                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>


                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card mb-4 border-left-dark shadow-lg">
                        <div class="card-header">
                            <h6 class="card-title mb-0 flex-grow-1 text-primary">Add New Question</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.preference.additional_question_store') }}" method="POST">
                                @csrf
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3 col-form-label">Question</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="title" class="form-control" maxlength="100" required="" value="">
                                        <span class="help-block text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3 col-form-label">Question for</label>
                                    <div class="col-sm-9">
                                        <select name="for" class="form-control select2 selectpicker user-select">
                                            <option value="student" selected="">student</option>
                                            <option value="advertiser">advertiser</option>
                                        </select>
                                        <small class="help-block">
                                            This question will be shown to student if you choose for question for student &
                                            advertiser if you choose for question for advertiser
                                        </small>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">Add Question</button>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
