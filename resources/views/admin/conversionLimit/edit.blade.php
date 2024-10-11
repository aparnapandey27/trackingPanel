@extends('admin.layout.app')

@section('title', 'Edit Student Conversion Limit')

@push('style')
 <!-- Sweetalert2 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">

@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-4">{{__(' Student Conversion Limit Details')}}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">{{__('Offer')}}</a>
                        </li>
                        <li class="breadcrumb-item active">{{__(' Student Conversion Limit Details')}}</li>
                    </ol>
                </div>
            </div>

            <div class="card mb-4 shadow-lg border-left-dark">
                <div class="card-header with-border">
                    <h6 class="card-title mb-0 flex-grow-1 text-primary"> Student Conversion Limit Details</h6>
                    <!-- /.card-tools -->
                </div>            
                <div class="card-body">
                    <form action="{{ route('admin.offers.convlimit.update', [$conversionlimit->offer_id, $conversionlimit->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="student_id" id="selectedStudentId">
                        <div class="form-group row mb-3" id="student_id">
                            <label class="col-sm-3 col-form-label"> Student Name</label>
                            <div class="col-sm-9">
                                
                            <select class="form-control student" data-placeholder="Choose any Student to Generate its Conversion Limit" >
                                <option value="selectedStudentId">{{$conversionlimit->user->name}}</option>
                                </select>

                            </div>
                        </div>
                        
                        <div class="form-group row mb-3">
                            <label for="goal_name" class="col-sm-3 col-form-label">Choose Goal/Event</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="goal_name" id="goal_name">
                                    
                                    @foreach ($offer->goals as $goal)
                                    <option value="{{ $goal->goalName->name }}"
                                    {{ $conversionlimit->name == $goal->goalName->name ? 'selected' : '' }} >{{ $goal->goalName->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        
                        <div class="form-group row mb-4" id="conversionlimit_group">
                            <label class="col-sm-3 col-form-label">Conversion Limit</label>
                            <div class="col-sm-9">
                            <input type="number" pattern="^[0-9]{1,5}" name="conversion_limit" class="form-control" id="conversion_limit"  inputmode="numeric" maxlength="5" value="{{ $conversionlimit->conversionlimit }}">                    
                                @error('conversion_limit')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="text-center mb-3">
                            <button type="submit" class="btn btn-rounded btn-primary"><i class="fa fa-check-circle"></i>
                                Update Student Offer Conversion Limit
                            </button>
                        </div>
                    </form>                
                </div>
            </div>
        </div>
    </div>
    
@endsection
@push('scripts')
  
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets/libs/select2/select2.full.min.js') }}"></script>
    
    <script>
          var selectedStudentId = {{$conversionlimit->student_id}}; // Declare the variable to store the 
       
        // jQuery div hide show on select offer_model
       
            $('.student').select2({
            ajax: {
            url: '{{ url('admin/common/students') }}',
            dataType: 'json',
            data: function(params) {
                return {
                    search: params.term
                }
            },
            processResults: function(response) {
                return {
                    results: response
                }
            },
            cache: true,
            width: 'resolve'
        }
    });
 
   

    // Event listener for when an student is selected
    $('.student').on('select2:select', function (e) {
        selectedStudentId = e.params.data.id;
        
    });
    
   
    
    
    $('form').on('submit', function (e) {
        e.preventDefault();
        
        
        $('#selectedStudentId').val(selectedStudentId);
        var conversionLimit = parseInt($('#conversion_limit').val());

        if (conversionLimit.length==0) {
            // Display an error message or perform any necessary actions
            alert('Conversion limit is empty');
            return false; // Prevent form submission
        }

        // Proceed with form submission
        this.submit();
    });
 
    </script>
@endpush
