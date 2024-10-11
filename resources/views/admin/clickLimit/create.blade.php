@extends('admin.layout.app')

@section('title', 'Add Student Click Limit')

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
                <h4 class="mb-sm-4">{{__('Student Click Limit Details')}}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">{{__('Offer')}}</a>
                        </li>
                        <li class="breadcrumb-item active">{{__('Student Click Limit Details')}}</li>
                    </ol>
                </div>
            </div>

            <div class="card mb-4 shadow-lg border-left-dark">
                <div class="card-header with-border">
                    <h6 class="card-title mb-0 flex-grow-1 text-primary">Student Click Limit Details</h6>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('admin.offers.clicklimit.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="offer_id" value="{{ $offer->id }}">
                        <input type="hidden" name="student_id" id="selectedStudentId">
                        <div class="form-group row mb-3" id="student_id">
                            <label class="col-sm-3 col-form-label">Student Name</label>
                            <div class="col-sm-9">
                                
                            <select class="form-control student" data-placeholder="Choose any Student to Generate its ClickLimit" >
                                </select>
                            </div>
                        </div>
                        
                    
                        <div class="form-group row mb-4" id="clicklimit_group">
                            <label class="col-sm-3 col-form-label">Click Limit</label>
                            <div class="col-sm-9">
                            <input type="number" pattern="^[0-9]{1,5}" name="click_limit" class="form-control" id="click_limit"  inputmode="numeric" maxlength="5">                            
                                @error('click_limit')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>                                                                   
                        <div class="text-center mb-3">
                            <button type="submit" class="btn btn-rounded btn-primary"><i class="fa fa-check-circle"></i>
                                Create Student Click Limit
                            </button>
                        </div>                
                    </form>
                
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/libs/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.bootstrap4.js') }}"></script>
    <!-- SweetAlert2-->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets/libs/select2/select2.full.min.js') }}"></script>
    <script>
    
        var selectedStudentId = null; // Declare the variable to store the 
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
        var clickLimit = parseInt($('#click_limit').val());

        if (clickLimit.length==0) {
            // Display an error message or perform any necessary actions
            alert('Click limit is empty');
            return false; // Prevent form submission
        }

        // Proceed with form submission
        this.submit();
    });
 

    
    
    </script>
@endpush

