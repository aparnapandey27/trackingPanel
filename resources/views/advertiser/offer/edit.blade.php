@extends('advertiser.layout.app')
@section('title', 'Edit Offer')
@push('style')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/summernote/summernote-lite.min.css') }}">  
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
    <style>
        .checkbox {
            padding-left: 0px !important;
        }

        .checkbox,
        .radio {
            position: relative;
            display: block;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .checkbox label,
        .radio label {
            min-height: 20px;
            padding-left: 0px !important;
            padding-right: 25px !important;
            margin-bottom: 0;
            font-weight: 400;
            cursor: pointer;
        }

        .form-check-inline {
            display: -webkit-inline-card;
            display: -ms-inline-flexcard;
            display: inline-flex;
            -webkit-card-align: center;
            -ms-flex-align: center;
            align-items: center;
            padding-left: 20px;
            margin-right: .75rem;
        }

    </style>
@endpush

@section('content')
    <!-- /.col -->
    <div class="page-content">
    <div class="container-fluid"> 
    <div class="card mb-4 shadow-lg border-left-dark">
        <div class="card-header with-border">
            <h3 class="card-title">Offer Details</h3>
            <div class="card-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->

            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if ($errors->any())
                {{ implode('', $errors->all('<div>:message</div>')) }}
            @endif
            <form action="{{ route('advertiser.offers.update', $offer->id) }}" METHOD="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Title</label>
                    <div class="col-sm-9 col-md-6">
                        <input type="text" name="title" class="form-control" maxlength="100" value="{{ $offer->name }}">
                        <span class="help-block text-danger"></span>
                        @error('title')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Thumbnail (Optional)</label>
                    <div class="col-sm-9 col-md-6">


                        <input type="file" class="form-control-file" name="thumbnail" accept="image/*">
                        @error('thumbnail')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Description (Optional)</label>
                    <div class="col-sm-9 col-md-6">
                        <textarea id="summernote" name="description" required>{{ $offer->description }}</textarea>
                        <span class="help-block text-danger"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Preview URL</label>
                    <div class="col-sm-9 col-md-6">
                        <input type="url" class="form-control" name="preview_url" value="{{ $offer->preview_url }}">
                        @error('preview_url')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="help-block">Link to preview landing page which publishers can see</small>
                    </div>
                </div>
                <div class="form-group row postback conv_tracking" data-target-el='#conversion_tracking_domains'>
                    <label class="col-sm-3 col-form-label">Conversion Tracking</label>
                    <div class="col-sm-9 col-md-6">
                        <select name="conversion_tracking" id='tracking_type' class="form-control"
                            placeholder="Conversion Tracking..">
                            <option disabled selected>Choose...</option>
                            <option value="s2s" {{ $offer->conversion_tracking == 's2s' ? 'selected' : '' }}>Server
                                Postback
                            </option>
                            <option value="iframe" {{ $offer->conversion_tracking == 'iframe' ? 'selected' : '' }}>IFrame
                                Pixel</option>
                            <option value="image" {{ $offer->conversion_tracking == 'image' ? 'selected' : '' }}>Image
                                Pixel
                            </option>
                        </select>
                        @error('conversion_tracking')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="help-block">Conversion Tracking Method..</small>
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Default Campaign URL</label>
                    <div class="col-sm-9 col-md-6 autoHeight">
                        <input type="url" class="form-control" name="tracking_url" value="{{ $offer->tracking_url }}"
                            required>
                        @error('tracking_url')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="help-block">The campaign URL where traffic will redirect to. Optional variabled
                            can be used in URL. <a href="#" data-toggle="modal" data-target="#trackingValue">Learn
                                more.</a></small>
                        <hr>
                        <small class="tracking_macros">
                            <b>Most Used URL tokens</b><br>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                title="Unique Click ID generated by System">{click_id}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                title="Unique Campaign ID">{offer_id}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                title="User ID of the student">{stu_id}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                title="Sub Student ID">{source}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                title="Sub Student Click ID">{stu_click}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                title="Stu Sub 1">{stu_sub1}</button>
                                                                                                                                                                                                                                                                                                                                                    <button type="
                                button" class="btn btn-rounded  btn-light btn-sm"
                                title="Stu Sub 2">{stu_sub2}</button>
                                                                                                                                                                                                                                                                                                                                                    <button type="
                                button" class="btn btn-rounded  btn-light btn-sm" title="Stu Sub 3">{stu_sub3}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                title="Stu Sub 4">{stu_sub4}</button><br>

                        </small>
                    </div>
                </div>
                <hr>


                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Category</label>
                    <div class="col-sm-9 col-md-6">
                        <select name="category_id" class="form-control categories" data-placeholder="Choose..">
                            @if ($offer->category_id != null)
                                <option value="{{ $offer->category_id }}" selected>{{ $offer->category->name }}
                                </option>
                            @endif
                        </select>
                        @error('category_id')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Status</label>
                    <div class="col-sm-9 col-md-6">
                        <select name="status" class="form-control" placeholder="Choose a campaign status">
                            <option disabled selected>Choose...</option>
                            <option value="0" {{ $offer->status == 0 ? 'selected' : '' }}>Pending</option>
                        </select>
                        @error('status')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="help-block">Active for publishers to run, paused, pending, deleted not visible to
                            publishers</small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Note (Optional)</label>
                    <div class="col-sm-9 col-md-6">
                        <textarea class="form-control" name="note" rows="3">{{ $offer->note }}</textarea>
                        <small class="help-block">The content will not be displayed to advertiser or publisher</small>
                    </div>
                </div>


        </div>
        <!-- /.card-body -->
    </div>



    <div class="card mb-4 shadow-lg border-left-dark">
        <div class="card-header with-border">
            <h3 class="card-title">Revenue and Payout</h3>
            <div class="card-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->

            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Offer Model</label>
                <div class="col-sm-9 col-md-6">
                    <select name="offer_model" class="form-control" id="offer_model">
                        <option disabled selected>Choose...</option>
                        <option value="CPL" {{ $offer->offer_model == 'CPL' ? 'selected' : '' }}>CPL</option>
                        <option value="CPA" {{ $offer->offer_model == 'CPA' ? 'selected' : '' }}>CPA</option>
                        <option value="CPS" {{ $offer->offer_model == 'CPS' ? 'selected' : '' }}>CPS</option>
                        <option value="RevShare" {{ $offer->offer_model == 'RevShare' ? 'selected' : '' }}>RevShare
                        </option>
                        <option value="Hybrid" {{ $offer->offer_model == 'Hybrid' ? 'selected' : '' }}>Hybrid (CPA +
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
            <div class="form-group row ">
                <label class="col-sm-3 col-form-label">Conversion Flow</label>
                <div class="col-sm-9 col-md-6">
                    <input type="text" name="conversion_flow" class="form-control" placeholder="Conversion Flow"
                        value="{{ $offer->conv_flow }}">
                    @error('conversion_flow')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <span class="help-block text-danger"></span>
                </div>
            </div>

            <div class="form-group row" id="currency"
                style="{{ $offer->offer_model == 'RevShare' ? 'display: none' : '' }}">
                <label class="col-sm-3 col-form-label">Currency</label>
                <div class="col-sm-9 col-md-6">

                    <select name="currency" required="" class="form-control selectpicker">
                        <option disabled selected>Choose...</option>
                        <option value="USD" {{ $offer->currency == 'USD' ? 'selected' : '' }}>USD</option>
                        <option value="EUR" {{ $offer->currency == 'EUR' ? 'selected' : '' }}>EUR</option>
                        <option value="GBP" {{ $offer->currency == 'GBP' ? 'selected' : '' }}>GBP</option>
                        <option value="INR" {{ $offer->currency == 'INR' ? 'selected' : '' }}>INR</option>
                        <option value="RUB" {{ $offer->currency == 'RUB' ? 'selected' : '' }}>RUB</option>
                        <option value="BTC" {{ $offer->currency == 'BTC' ? 'selected' : '' }}>BTC</option>


                    </select>
                    @error('currency')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row" id="defaultRevenue"
                style="{{ $offer->offer_model == 'RevShare' ? 'display: none' : '' }}">
                <label class="col-sm-3 col-form-label">Revenue</label>
                <div class="col-sm-9 col-md-6">
                    <input type="number" name="revenue" pattern="^[0-9]{1,2}(\.[0-9]{0,6})?$" class="form-control"
                        placeholder="Charged from advertiser. Eg: 0.3" step="0.001"
                        value="{{ $offer->default_revenue }}">
                    @error('revenue')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row" id="percentRevenue"
                style="{{ $offer->offer_model == 'CPA' ? 'display: none' : '' }}">
                <label class="col-sm-3 col-form-label">Percent Revenue</label>
                <div class="col-sm-9 col-md-6">
                    <div class="input-group">
                        <input type="number" name="percent_revenue" pattern="^[0-9]{1,2}(\.[0-9]{0,6})?$"
                            class="form-control" placeholder="How much percent charged to advertiser. Eg: 0.3"
                            step="0.001" value="{{ $offer->percent_revenue }}">
                        <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                    </div>
                    @error('revenue')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>

    <div class="card mb-4 shadow-lg border-left-dark">
        <div class="card-header with-border">
            <h6 class="m-0 font-weight-bold text-primary">
                Targeting
            </h6>
        </div>
        <div class="card-body">
            <div class="form-group row  @error('countries') has-error @enderror">
                <label class="col-sm-3 col-form-label" id="country">Country</label>
                <div class="col-sm-9 col-md-6">
                    <select name="countries[]" class="form-control countries" multiple id="country"
                        data-placeholder="Choose..">
                        @foreach ($offer->countries as $country)
                            <option value="{{ $country->id }}" selected>[{{ $country->code }}] {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <small class="help-block">
                    leave blank for all
                </small>
            </div>
            {{-- <div class="form-group row ">
                <label class="col-sm-3 col-form-label" id="states">States</label>
                <div class="col-sm-9 col-md-6">
                    <select name="states[]" class="form-control states" multiple id="states"
                        data-placeholder="Choose States..">
                        @foreach ($offer->states as $state)
                            <option value="{{ $state->id }}" selected>
                                [{{ $state->state_code }}] {{ $state->state_name }}</option>
                        @endforeach
                    </select>
                </div>
                <small class="help-block">
                    leave blank for all
                </small>
            </div> --}}
            <div class="form-group row  @error('devices') has-error @enderror">
                <label class="col-sm-3 col-form-label" id="device">Device</label>
                <div class="col-sm-9 col-md-6">
                    <select name="devices[]" class="form-control devices" multiple id="device" data-placeholder="Choose..">
                        @foreach ($offer->devices as $device)
                            <option value="{{ $device->id }}" selected>{{ $device->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <small class="help-block">
                    leave blank for all
                </small>
            </div>

            <div class="form-group row  @error('browsers') has-error @enderror">
                <label class="col-sm-3 col-form-label" id="browser">Browser</label>
                <div class="col-sm-9 col-md-6">
                    <select name="browsers[]" class="form-control browsers" multiple id="browser"
                        data-placeholder="Choose..">
                        @foreach ($offer->browsers as $browser)
                            <option value="{{ $browser->id }}" selected>{{ $browser->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <small class="help-block">
                    leave blank for all
                </small>
            </div>
        </div>
    </div>

    <div class="card mb-4 shadow-lg border-left-dark">
        <div class="card-header with-border">
            <h3 class="card-title">Restriction Settings</h3>
            <div class="card-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <div class="form-group row @error('same_ip_conversion') has-error @enderror">
                <label class="col-sm-3 col-form-label">Same IP Conversion</label>
                <div class="col-sm-9 col-md-6">
                    <div class="radio radio-success form-check-inline">
                        <input type="radio" value=0 name="same_ip_conversion"
                            {{ $offer->same_ip_conversion == 0 ? 'checked' : '' }}>
                        <label for="pubCampaign">block</label>
                    </div>
                    <div class="radio radio-success form-check-inline">
                        <input type="radio" value=1 name="same_ip_conversion"
                            {{ $offer->same_ip_conversion == 1 ? 'checked' : '' }}>
                        <label for="permCampaign">allow</label>
                    </div><br>
                    <small class="help-block">
                        If block, conversion will be counted only once per IP address.
                    </small>
                </div>
            </div>

            <div class="form-group row @error('conversion_approval') has-error @enderror">
                <label class="col-sm-3 col-form-label">Conversion Approval</label>
                <div class="col-sm-9 col-md-6">
                    <div class="radio radio-success form-check-inline">
                        <input type="radio" id="manualConversion" value=0 name="conversion_approval"
                            {{ $offer->conversion_approval == 0 ? 'checked' : '' }}>
                        <label for="manualConversion">manual</label>
                    </div>
                    <div class="radio radio-success form-check-inline">
                        <input type="radio" id="autoConversion" value=1 name="conversion_approval"
                            {{ $offer->conversion_approval == 1 ? 'checked' : '' }}>
                        <label for="autoConversion">auto</label>
                    </div><br>
                    <small class="help-block">
                        If manual, conversion will be counted as pending conversion and need admin approval.
                    </small>
                </div>
            </div>

            <div class="form-group row @error('min_conversion_time') has-error @enderror">
                <label for="min_conversion_time" class="col-sm-3 col-form-label">Min. Conversion Time</label>
                <div class="col-sm-9 col-md-4">
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <input name="min_conversion_time" type="number" class="form-control"
                                value="{{ $offer->min_conversion_time }}">
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <select class="form-control" name="min_conversion_time_type">
                                <option value="s">Seconds</option>
                                <option value="m">Minutes</option>
                                <option value="h">Hours</option>
                            </select>
                        </div>
                    </div>
                    <small class="help-block">
                        If conversion happen before this time period, then it be rejected automatically.
                    </small>
                </div>
            </div>
            <div class="form-group row @error('max_conversion_time') has-error @enderror">
                <label for="mix_conversion_time" class="col-sm-3 col-form-label">Max. Conversion Time</label>
                <div class="col-sm-9 col-md-4">
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <input name="max_conversion_time" type="number" class="form-control"
                                value="{{ $offer->max_conversion_time }}">
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <select class="form-control" name="max_convesion_time_type">
                                <option value="h">Hours</option>
                                <option value="d">Days</option>
                            </select>
                        </div>
                    </div>
                    <small class="help-block">
                        If conversion happen after this time period, then it be rejected automatically.
                    </small>
                </div>
            </div>

            <div class="form-group row  @error('expire_date') has-error @enderror">
                <label class="col-sm-3 col-form-label">Expire Date</label>
                <div class="col-sm-9 col-md-6">
                    <input type="date" name="expire_date" class="form-control" placeholder="Expire Dates"
                        id="datepicker2" value="{{ $offer->expire_at }}">
                    @error('expire_date')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <span class="help-block text-danger"></span>
                </div>
            </div>


            <button type="submit" class="btn btn-rounded btn-primary"><i class="fa fa-check-circle"></i>
                Update Offer</button>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
            </div>
        </div>
@endsection

@push('scripts')
    <!-- Select2 -->
    <script src="{{ asset('assets/libs/select2/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            $('.categories').select2({
                ajax: {
                    url: '{{ route('addvertiser.getCategories') }}',
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

            $('.countries').select2({
                ajax: {
                    url: '{{ route('advertiser.getCountries') }}',
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

            $('.devices').select2({
                ajax: {
                    url: '{{ route('advertiser.getDevices') }}',
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

            $('.browsers').select2({
                ajax: {
                    url: '{{ route('advertiser.getBrowsers') }}',
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

        })
    </script>

    <script>
        // jQuery div hide show on select offer_model
        $(document).ready(function() {
            $('#offer_model').on('change', function() {
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
    <script src="{{ asset('assets/libs/summernote/summernote-lite.min.js') }}"></script>
    <script>
        $('#summernote').summernote({
            placeholder: "Place some text here",            
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: true                  // set focus to editable area after initializing summernote
        });
    </script>
@endpush
