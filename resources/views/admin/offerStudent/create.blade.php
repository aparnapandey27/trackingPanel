@extends('admin.layout.app')
@section('title', 'Add Student Offer Payout')
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
                <h4 class="mb-sm-0">{{__('Student Offer Payout Details')}}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">{{__('Offer')}}</a>
                        </li>
                        <li class="breadcrumb-item active">{{__('Student Offer Payout Details')}}</li>
                    </ol>
                </div>
            </div>
            <div class="card mb-4 shadow-lg border-left-dark">
                <div class="card-header with-border">
                    <h6 class="card-title mb-0 flex-grow-1 text-primary">Student Offer Payout Details</h6>                    
                </div>                
                <div class="card-body">
                    <form action="{{ route('admin.offers.students.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="offer_id" value="{{ $offer->id }}">
                        <input type="hidden" name="student_id" id="selectedStudentId">
                        <div class="form-group row mb-3" id="student_id">
                            <label class="col-sm-3 col-form-label">Student Name</label>
                            <div class="col-sm-9 col-md-6">
                                
                            <select class="form-control student" data-placeholder="Choose any Student to Generate its Payout" >
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group row mb-3">
                            <label for="goal_name" class="col-sm-3 col-form-label">Choose Goal/Event</label>
                            <div class="col-sm-9 col-md-6">
                                <select class="form-select" name="goal_name" id="goal_name">
                                    <option disabled selected>Choose...</option>
                                    <!--<option value="Default" data-pay-model="{{ $offer->offer_model }}" data-currency="{{ $offer->currency }}" data-default-payout="{{ $offer->default_payout }}" data-percent-payout="{{ $offer->percent_payout }}">Default</option>-->
                                    @foreach ($offer->goals as $goal)
                                    <option value="{{ $goal->goalName->name }}" data-pay-model="{{ $goal->pay_model }}" data-currency="{{ $goal->currency }}" data-default-payout="{{ $goal->default_payout }}" data-percent-payout="{{ $goal->percent_payout }}">{{ $goal->goalName->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                    <div class="form-group row mb-3" id="pay_model_group">
                        <label class="col-sm-3 col-form-label">Goal Model</label>
                        <div class="col-sm-9 col-md-6">
                            <input name="payModel" class="form-control" id="payModel" data-placeholder="Goal Model for particular Event">
                        </div>
                    </div>
                    
                        <div class="form-group row mb-3" id="currency_group">
                            <label class="col-sm-3 col-form-label">Currency</label>
                            <div class="col-sm-9 col-md-6">
                                <input disabled="disabled" name="currency"  class="form-control" id="currency" data-placeholder="Currency for particular Event">
                                
                                @error('currency')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    
                        <div class="form-group row mb-3" id="defaultPayout_group">
                            <label class="col-sm-3 col-form-label">Payout</label>
                            <div class="col-sm-9 col-md-6">
                            <input type="number" pattern="^[0-9]{1,2}(\.[0-9]{0,6})?$" name="defaultPayout" class="form-control" id="defaultPayout">
                            
                                @error('default_payout')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-3" id="percentPayout_group">
                            <label class="col-sm-3 col-form-label">Percent Payout</label>
                            <div class="col-sm-9 col-md-6">
                                <div class="input-group">
                                <input type="number" pattern="^[0-9]{1,2}(\.[0-9]{0,6})?$" name="percentPayout" class="form-control" id="percentPayout" step="0.001">
                                
                                </div>
                                @error('percent_payout')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-rounded btn-primary">
                                Create Student Payout
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
        var payModel = null;
        var currency = null;
        var defaultPayout = null;
        var percentPayout = null;
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
    
    document.getElementById('goal_name').addEventListener('change', function () {
   
    const selectedOption = this.options[this.selectedIndex];
     payModel = selectedOption.getAttribute('data-pay-model');
     currency = selectedOption.getAttribute('data-currency');
     defaultPayout = selectedOption.getAttribute('data-default-payout');
     percentPayout = selectedOption.getAttribute('data-percent-payout');

    //document.getElementById('payModel').value = payModel;
    document.getElementById('payModel').value = payModel;
    document.getElementById('currency').value = currency;
    document.getElementById('defaultPayout').value = defaultPayout;
    document.getElementById('percentPayout').value = percentPayout;
  
    });
    
    $('#defaultPayout').on('input', function() {
        defaultPayout = $(this).val(); // Update defaultPayout with the user's input
    });
    
    $('#percentPayout').on('input', function() {
        percentPayout = $(this).val(); // Update defaultPayout with the user's input
    });
    
    
    $('form').on('submit', function (e) {
        e.preventDefault();
        // Assign the captured student_id to the hidden input field
         // Capture the values of payModel and currency
         var payModelValue = document.getElementById('payModel').value;
         var currencyValue = document.getElementById('currency').value;
         
        
        $('#selectedStudentId').val(selectedStudentId);
        $('#currency').val(currencyValue);
        $('#payModel').val(payModelValue);
        $('#defaultPayout').val(defaultPayout);
        $('#percentPayout').val(percentPayout);
        
        // Proceed with form submission
        this.submit();
    });
 

    
    
    </script>
@endpush

