@extends('advertiser.layout.app')

@section('title', 'Create Goal')

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
            <form action="{{ route('advertiser.offers.goal.store') }}" method="POST">
                @csrf
                <input type="hidden" name="offer_id" value="{{ $offer->id }}">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Goal Name</label>
                    <div class="col-sm-9 col-md-6">
                        <input type="text" name="name" class="form-control" maxlength="100" value="">
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
                            <option value="CPL">CPL</option>
                            <option value="CPA">CPA</option>
                            <option value="CPS">CPS</option>
                            <option value="RevShare">RevShare</option>
                            <option value="Hybrid">Hybrid (CPA + Revshare)</option>
                        </select>
                        @error('offer_model')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="help-block text-danger"></span>
                    </div>
                </div>


                <div class="form-group row" id="currency">
                    <label class="col-sm-3 col-form-label">Currency</label>
                    <div class="col-sm-9 col-md-6">

                        <select name="currency" required="" class="form-control selectpicker">
                            <option disabled selected>Choose...</option>
                            <option value="USD">USD</option>
                            <option value="EUR">EUR</option>
                            <option value="GBP">GBP</option>
                            <option value="INR">INR</option>
                            <option value="RUB">RUB</option>
                            <option value="BTC">BTC</option>


                        </select>
                        @error('currency')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row" id="defaultRevenue">
                    <label class="col-sm-3 col-form-label">Revenue</label>
                    <div class="col-sm-9 col-md-6">
                        <input type="number" name="revenue" pattern="^[0-9]{1,2}(\.[0-9]{0,6})?$" class="form-control"
                            placeholder="Charged from advertiser. Eg: 0.3" step="0.001">
                        @error('revenue')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row" id="percentRevenue" style="display: none">
                    <label class="col-sm-3 col-form-label">Percent Revenue</label>
                    <div class="col-sm-9 col-md-6">
                        <div class="input-group">
                            <input type="number" name="percent_revenue" pattern="^[0-9]{1,2}(\.[0-9]{0,6})?$"
                                class="form-control" placeholder="How much percent charged to advertiser. Eg: 0.3"
                                step="0.001">
                            <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                        </div>
                        @error('revenue')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                {{-- <div class="form-group row" id="defaultPayout">
                    <label class="col-sm-3 col-form-label">Payout</label>
                    <div class="col-sm-9 col-md-6">
                        <input type="number" name="payout" pattern="^[0-9]{1,2}(\.[0-9]{0,6})?$" class="form-control"
                            placeholder="Pay to publisher" step="0.001">
                        @error('payout')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row" id="percentPayout" style="display: none">
                    <label class="col-sm-3 col-form-label">Percent Payout</label>
                    <div class="col-sm-9 col-md-6">
                        <div class="input-group">
                            <input type="number" name="percent_payout" pattern="^[0-9]{1,2}(\.[0-9]{0,6})?$"
                                class="form-control" placeholder="How much percent pay to publisher" step="0.001">
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
                    Create Goal
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
