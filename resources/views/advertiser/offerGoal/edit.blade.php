@extends('advertiser.layout.app')

@section('title', ' Edit Goal')

@push('style')

@endpush

@section('content')
    <!-- /.col -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Goal Details</h3>
            <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->

            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <form action="{{ route('advertiser.offers.goal.update', [$offerGoal->offer_id, $offerGoal->id]) }}"
                method="POST">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Goal Name</label>
                    <div class="col-sm-9 col-md-6">
                        <input type="text" name="name" class="form-control" maxlength="100"
                            value="{{ $offerGoal->name }}">
                        <span class="help-block text-danger"></span>
                        @error('title')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Goal Model</label>
                    <div class="col-sm-9 col-md-6">
                        <select name="pay_model" class="form-control" id="pay_model">
                            <option disabled selected>Choose...</option>
                            <option value="CPL" {{ $offerGoal->pay_model == 'CPL' ? 'selected' : '' }}>CPL</option>
                            <option value="CPA" {{ $offerGoal->pay_model == 'CPA' ? 'selected' : '' }}>CPA</option>
                            <option value="CPS" {{ $offerGoal->pay_model == 'CPS' ? 'selected' : '' }}>CPS</option>
                            <option value="RevShare" {{ $offerGoal->pay_model == 'RevShare' ? 'selected' : '' }}>RevShare
                            </option>
                            <option value="Hybrid" {{ $offerGoal->pay_model == 'Hybrid' ? 'selected' : '' }}>Hybrid (CPA +
                                RevShare)</option>
                        </select>
                        @error('offer_model')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="help-block text-danger"></span>
                    </div>
                </div>

                <div class="form-group row" id="currency"
                    style="{{ $offerGoal->pay_model == 'RevShare' ? 'display: none' : '' }}">
                    <label class="col-sm-3 col-form-label">Currency</label>
                    <div class="col-sm-9 col-md-6">

                        <select name="currency" required="" class="form-control selectpicker">
                            <option disabled selected>Choose...</option>
                            <option value="USD" {{ $offerGoal->currency == 'USD' ? 'selected' : '' }}>USD</option>
                            <option value="EUR" {{ $offerGoal->currency == 'EUR' ? 'selected' : '' }}>EUR</option>
                            <option value="GBP" {{ $offerGoal->currency == 'GBP' ? 'selected' : '' }}>GBP</option>
                            <option value="INR" {{ $offerGoal->currency == 'INR' ? 'selected' : '' }}>INR</option>
                            <option value="RUB" {{ $offerGoal->currency == 'RUB' ? 'selected' : '' }}>RUB</option>
                            <option value="BTC" {{ $offerGoal->currency == 'BTC' ? 'selected' : '' }}>BTC</option>


                        </select>
                        @error('currency')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row" id="defaultRevenue"
                    style="{{ $offerGoal->pay_model == 'RevShare' ? 'display: none' : '' }}">
                    <label class="col-sm-3 col-form-label">Revenue</label>
                    <div class="col-sm-9 col-md-6">
                        <input type="number" name="revenue" pattern="^[0-9]{1,2}(\.[0-9]{0,6})?$" class="form-control"
                            placeholder="Charged from advertiser. Eg: 0.3" step="0.001"
                            value="{{ $offerGoal->default_revenue }}">
                        @error('revenue')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row" id="percentRevenue"
                    style="{{ $offerGoal->pay_model == 'CPA' ? 'display: none' : '' }}">
                    <label class="col-sm-3 col-form-label">Percent Revenue</label>
                    <div class="col-sm-9 col-md-6">
                        <div class="input-group">
                            <input type="number" name="percent_revenue" pattern="^[0-9]{1,2}(\.[0-9]{0,6})?$"
                                class="form-control" placeholder="How much percent charged to advertiser. Eg: 0.3"
                                step="0.001" value="{{ $offerGoal->percent_revenue }}">
                            <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                        </div>
                        @error('revenue')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                {{-- <div class="form-group row" id="defaultPayout"
                    style="{{ $offerGoal->pay_model == 'RevShare' ? 'display: none' : '' }}">
                    <label class="col-sm-3 col-form-label">Payout</label>
                    <div class="col-sm-9 col-md-6">
                        <input type="number" name="payout" pattern="^[0-9]{1,2}(\.[0-9]{0,6})?$" class="form-control"
                            placeholder="Pay to publisher" step="0.001" value="{{ $offerGoal->default_payout }}">
                        @error('payout')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row" id="percentPayout"
                    style="{{ $offerGoal->pay_model == 'CPA' ? 'display: none' : '' }}">
                    <label class="col-sm-3 col-form-label">Percent Payout</label>
                    <div class="col-sm-9 col-md-6">
                        <div class="input-group">
                            <input type="number" name="percent_payout" pattern="^[0-9]{1,2}(\.[0-9]{0,6})?$"
                                class="form-control" placeholder="How much percent pay to publisher" step="0.001"
                                value="{{ $offerGoal->percent_payout }}">
                            <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                        </div>
                        @error('payout')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div> --}}
                <button type="submit" class="btn btn-rounded btn-primary"><i class="fa fa-check-circle"></i>
                    Update Goal
                </button>
            </form>
            </form>
        </div>

    </div>
    <!-- /.box-body -->
@endsection
@push('scripts')
    <script>
        // jQuery div hide show on select offer_model
        $(document).ready(function() {
            $('#pay_model').on('change', function() {
                if (this.value == 'Hybrid') {
                    $('#defaultRevenue, #percentRevenue, #defaultPayout, #percentPayout, #currency').show();
                } else if (this.value == 'RevShare') {
                    $('#percentRevenue, #percentPayout').show();
                    $('#defaultRevenue, #defaultPayout, #currency').hide();
                } else {
                    $('#defaultRevenue, #defaultPayout, #currency').show();
                    $('#percentRevenue, #percentPayout').hide();
                }
            });
        });
    </script>
@endpush
