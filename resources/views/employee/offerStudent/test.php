@extends('employee.layout.app')

@push('page_title')
    Add Student Offer Payout
@endpush

@push('css')
    <!-- Sweetalert2 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">

@endpush

@section('content')
    <!-- /.col -->
    <div class="card mb-4 shadow-lg border-left-dark">
        <div class="card-header with-border">
            <h6 class="m-0 font-weight-bold text-primary">Student Offer Payout Details</h6>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form action="{{ route('employee.offer.student.store') }}" method="POST">
                @csrf
                <input type="hidden" name="student_id" value="{{$id}}">
                
                <input type="hidden" name="offer_id" id="offerSelect">
                <div class="form-group row" id="offer_id">
                    <label class="col-sm-3 col-form-label">Offer Name</label>
                    <div class="col-sm-9 col-md-6">
                       <select class="form-control offer" data-placeholder="Choose any Offer to Generate its Payout" >
                        </select>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="goal_name" class="col-sm-3 col-form-label">Choose Goal/Event</label>
                    <div class="col-sm-9 col-md-6">
                        <select class="form-control" name="goal_name" id="goal_name" style="display: none;"></select>
                    </div>
                </div>
                
             <div class="form-group row" id="pay_model_group">
                <label class="col-sm-3 col-form-label">Goal Model</label>
                <div class="col-sm-9 col-md-6">
                    <input name="payModel" class="form-control" id="payModel" data-placeholder="Goal Model for particular Event">
                </div>
            </div>
            
                <div class="form-group row" id="currency_group">
                    <label class="col-sm-3 col-form-label">Currency</label>
                    <div class="col-sm-9 col-md-6">
                        <input disabled="disabled" name="currency"  class="form-control" id="currency" data-placeholder="Currency for particular Event">
                        </input>
                        @error('currency')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
               
                <div class="form-group row" id="defaultPayout_group">
                    <label class="col-sm-3 col-form-label">Payout</label>
                    <div class="col-sm-9 col-md-6">
                    <input type="number" pattern="^[0-9]{1,2}(\.[0-9]{0,6})?$" name="defaultPayout" class="form-control" id="defaultPayout">
                    </input>
                        @error('default_payout')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row" id="percentPayout_group">
                    <label class="col-sm-3 col-form-label">Percent Payout</label>
                    <div class="col-sm-9 col-md-6">
                        <div class="input-group">
                        <input type="number" pattern="^[0-9]{1,2}(\.[0-9]{0,6})?$" name="percentPayout" class="form-control" id="percentPayout" step="0.001">
                        </input>
                        </div>
                        @error('percent_payout')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-rounded btn-primary"><i class="fa fa-check-circle"></i>
                    Create Student Payout
                </button>
          
            </form>
           
        </div>

    </div>

    <!-- /.card-body -->
@endsection

@push('js')
    <script src="{{ asset('assets/libs/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.bootstrap4.js') }}"></script>
    <!-- SweetAlert2-->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets/libs/select2/select2.full.min.js') }}"></script>
    <script>
    
        var selectedOfferId = 1; // Declare the variable to store the 
        var payModel = null;
        var currency = null;
        var defaultPayout = null;
        var percentPayout = null;
        // jQuery div hide show on select offer_model
       
    $('.offer').select2({
            ajax: {
            url: '{{ url('employee/common/offers') }}',
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
   
   $('#offerSelect').on('select2:select', function (e) {
    selectedOfferId = e.params.data.id;

        // Make an AJAX request to fetch goals data for the selected offer
        $.ajax({
            url: '{{ route('employee.getOfferGoals')}}', // Replace with the actual route for fetching goals
            method: 'GET',
            data: { offerId: selectedOfferId },
            success: function (data) {
                // Populate the "Goal Name" select box with the fetched goals data
                populateGoalSelect(data);
            },
            error: function (xhr, textStatus, errorThrown) {
                // Handle error if necessary
            }
        });
    });
    
    // Function to populate the "Goal Name" select box with goals data
    function populateGoalSelect(goalsData) {
        var goalSelect = $('#goal_name');
        goalSelect.empty(); // Clear previous options
    
        // Add a default option
        goalSelect.append('<option disabled selected>Choose...</option>');
    
        // Add goals data as options
        $.each(goalsData, function (index, goal) {
            goalSelect.append('<option value="' + goal.name + '" data-pay-model="' + goal.offer_model + '" data-currency="' + goal.currency + '" data-default-payout="' + goal.default_payout + '" data-percent-payout="' + goal.percent_payout + '">' + goal.name + '</option>');
        });
    
        // Show the "Goal Name" select box
        goalSelect.show();
    }

   
    
    document.getElementById('goal_name').addEventListener('change', function () {
   
    const selectedOption = this.options[this.selectedIndex];
     payModel = selectedOption.getAttribute('data-pay-model');
     currency = selectedOption.getAttribute('data-currency');
     defaultPayout = selectedOption.getAttribute('data-default-payout');
     percentPayout = selectedOption.getAttribute('data-percent-payout');

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
         
        
        $('#selectedOfferId').val(selectedOfferId);
        $('#currency').val(currencyValue);
        $('#payModel').val(payModelValue);
        $('#defaultPayout').val(defaultPayout);
        $('#percentPayout').val(percentPayout);
        
        // Proceed with form submission
        this.submit();
    });
 

    
    
    </script>
@endpush

