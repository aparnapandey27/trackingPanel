@extends('admin.layout.app')
@section('title', 'Edit Offer')
@push('style')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
    <style>
        .checkcard {
            padding-left: 0px !important;
        }

        .checkcard,
        .radio {
            position: relative;
            display: block;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .checkcard label,
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
    <link rel="stylesheet" href="{{ asset('assets/libs/summernote/summernote-lite.min.css') }}">
@endpush

@section('content')
<div class="page-content">
	<div class="container-fluid">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-4">{{__('Edit Offer')}}</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">{{__('Offer')}}</a>
                    </li>
                    <li class="breadcrumb-item active">{{__('Edit Offer')}}</li>
                </ol>
            </div>
        </div>
        <form action="{{ route('admin.offers.update', ['offer' => $offer->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card mb-4 shadow-lg border-left-dark">
                <div class="card-header with-border">
                    <h6 class="card-title mb-0 flex-grow-1 text-primary">Offer Details</h6>
                </div>        
                <div class="card-body mx-4">
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <strong>Error!</strong> {{ $error }}.
                        </div>
                    @endforeach
            
                    <div class="form-group row mb-3 @error('advertiser_id') has-error @enderror">
                        <label class="col-sm-3 col-form-label">Advertiser</label>
                        <div class="col-sm-9">
                            <select name="advertiser_id" class="form-select selectpicker user-select">
                                <option disabled selected>Choose...</option>
                                
                                @foreach ($advertisers as $advertiser)
                                    <option value="{{ $advertiser->id }}"
                                        {{ (old('advertiser_id') == $advertiser->id) || ($offer->advertiser_id == $advertiser->id) ? 'selected' : '' }}>
                                        {{ $advertiser->name }}
                                    </option>
                                @endforeach
                                
                            </select>
                            @error('advertiser_id')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <span class="help-block text-danger"></span>
                        </div>
                        
                    </div>
                    <div class="form-group row mb-3 @error('title') has-error @enderror">
                        <label class="col-sm-3 col-form-label">Title</label>
                        <div class="col-sm-9">
                            <input type="text" name="title" class="form-control" maxlength="100" value="{{ old('title', $offer->name) }}">
                            <span class="help-block text-danger"></span>
                            @error('title')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    

                    <div class="form-group row mb-3 @error('thumbnail') has-error @enderror">
                        <label class="col-sm-3 col-form-label">Thumbnail</label>
                        <div class="col-sm-9 d-flex align-items-center">
                            <img id="thumbnailPreview" src="{{ old('thumbnail', $offer->thumbnail ? asset('storage/offers/' . $offer->thumbnail) : '') }}" alt="Thumbnail" style="max-width: 100px; max-height: 100px; display: block;">
                            <input type="file" class="form-control" id="formFile" name="thumbnail" accept="image/*" onchange="previewThumbnail(event)">
                            @error('thumbnail')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <script>
                        function previewThumbnail(event) {
                            const input = event.target;
                            if (input.files && input.files[0]) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    document.getElementById('thumbnailPreview').src = e.target.result;
                                };
                                reader.readAsDataURL(input.files[0]);
                            }
                        }
                    </script>
                    
                    
                    
                    <div class="form-group row mb-3 @error('description') has-error @enderror">
                        <label class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9">
                            <textarea id="summernote" name="description" required>{{ old('description', $offer->description) }}</textarea>
                            <span class="help-block text-danger"></span>
                            @error('description')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    

                    <div class="form-group row mb-3 @error('preview_url') has-error @enderror">
                        <label class="col-sm-3 col-form-label">Preview URL</label>
                        <div class="col-sm-9">
                            <input type="url" class="form-control" name="preview_url" value="{{ old('preview_url', $offer->preview_url) }}">
                            @error('preview_url')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="help-block">Link to the preview landing page which publishers can see</small>
                        </div>
                    </div>
                    
                    <div class="form-group row mb-3 @error('conversion_tracking') has-error @enderror postback conv_tracking"
                    data-target-el='#conversion_tracking_domains'>
                    <label class="col-sm-3 col-form-label">Conversion Tracking</label>
                    <div class="col-sm-9">
                        <select name="conversion_tracking" id='tracking_type' class="form-select" placeholder="Conversion Tracking..">
                            <option disabled selected>Choose...</option>
                            <option value="s2s" {{ (old('conversion_tracking') == 's2s' || $offer->conversion_tracking == 's2s') ? 'selected' : '' }}>Server Postback</option>
                            <option value="offline" {{ (old('conversion_tracking') == 'offline' || $offer->conversion_tracking == 'offline') ? 'selected' : '' }}>Offline</option>
                            {{-- <!--<option value="image" {{ (old('conversion_tracking') == 'image' || $offer->conversion_tracking == 'image') ? 'selected' : '' }}>Image Pixel</option>--> --}}
                        </select>
                        @error('conversion_tracking')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="help-block">Conversion Tracking Method..</small>
                    </div>
                </div>
                

                <div class="form-group row mb-3 @error('package') has-error @enderror" id="packageField">
                    <label for="package" class="col-sm-3 col-form-label">Package Name</label>
                    <div class="col-sm-9">
                        <input type="text" name="package" class="form-control" maxlength="100" value="{{ old('package', $offer->package_name) }}" id="package" placeholder="Enter Package Name"/>
                        @error('package')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                    <div class="form-group row mb-3 @error('tracking_url') has-error @enderror">
                        <label class="col-sm-3 col-form-label">Default Campaign URL</label>
                        <div class="col-sm-9  autoHeight">
                            <input type="url" class="form-control" name="tracking_url" value="{{ old('tracking_url', $offer->tracking_url) }}" required id="tracking_url">
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
                                <button type="button" class="btn btn-rounded  btn-light btn-sm clickBtn"
                                    title="Unique Click ID generated by System"
                                    data-clipboard-text="{click_id}">{click_id}</button>
                                <button type="button" class="btn btn-rounded btn-light btn-sm offerBtn"
                                    title="Unique Campaign ID" data-clipboard-text="{offer_id}">{offer_id}</button>
                                <button type="button" class="btn btn-rounded btn-light btn-sm stuBtn"
                                    title="User ID of the Student" data-clipboard-text="{stu_id}">{stu_id}</button>
                                <button type="button" class="btn btn-rounded btn-light btn-sm sourceBtn"
                                    title="Sub Student ID" data-clipboard-text="{source}">{source}</button>
                                <button type="button" class="btn btn-rounded btn-light btn-sm stuClickBtn"
                                    title="Sub Student Click ID" data-clipboard-text="{stu_click}">{stu_click}</button>
                                <button type="button" class="btn btn-rounded btn-light btn-sm stuSub1Btn" title="Stu Sub 1"
                                    data-clipboard-text="{stu_sub1}">{stu_sub1}</button>

                                <button type="button" class="btn btn-rounded btn-light btn-sm stuSub2Btn" title="Stu Sub 2"
                                    data-clipboard-text="{stu_sub2}">{stu_sub2}</button>
                                <button type="button" class="btn btn-rounded btn-light btn-sm stuSub2Btn" title="Stu Sub 2"
                                    data-clipboard-text="{stu_sub2}">{stu_sub2}</button>
                                <button type="button" class="btn btn-rounded btn-light btn-sm stuSub3Btn" title="Stu Sub 3"
                                    data-clipboard-text="{stu_sub3}">{stu_sub3}</button>
                                <button type="button" type="button" class="btn btn-rounded btn-light btn-sm stuSub4Btn"
                                    title="Stu Sub 4" data-clipboard-text="{stu_sub4}">{stu_sub4}</button>
                                <button type="button" type="button" class="btn btn-rounded btn-light btn-sm stuSub5Btn"
                                    title="Stu Sub 5" data-clipboard-text="{stu_sub5}">{stu_sub5}</button>

                            </small>
                        </div>
                    </div>
                    <hr>


                    <div class="form-group row mb-3 @error('category_id') has-error @enderror">
                        <label class="col-sm-3 col-form-label">Category</label>
                        <div class="col-sm-9">
                            <select name="category_id" class="form-select categories" data-placeholder="Choose..">
                                @if(old('category_id'))
                                    <option value="{{ old('category_id') }}" selected>
                                        {{ \App\Models\Category::find(old('category_id'))->name }}
                                    </option>
                                @elseif ($offer->category_id != null)
                                    <option value="{{ $offer->category_id }}" selected>
                                        {{ $offer->category->name }}
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
                    


                    <div class="form-group row mb-3 @error('status') has-error @enderror">
                        <label class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            <select name="status" class="form-select" placeholder="Choose a campaign status">
                                <option disabled selected>Choose...</option>
                                <option value="1" {{ old('status', $offer->status) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status', $offer->status) == 0 ? 'selected' : '' }}>Pending</option>
                                <option value="3" {{ old('status', $offer->status) == 3 ? 'selected' : '' }}>Expire</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="help-block">Active for publishers to run, paused, pending, deleted not visible to publishers</small>
                        </div>
                    </div>
                    

                    <div class="form-group row mb-3 @error('note') has-error @enderror">
                        <label class="col-sm-3 col-form-label">Note (Optional)</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="note" rows="3">{{ old('note', $offer->note) }}</textarea>
                            @error('note')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="help-block">The content will not be displayed to advertiser or publisher</small>
                        </div>
                    </div>
                    
                </div>            
            </div>

            <div class="card mb-4 shadow-lg border-left-dark">
                <div class="card-header with-border">
                    <h6 class="card-title mb-0 flex-grow-1 text-primary">Revenue and Payout</h6>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body mx-4">
                    <div class="form-group row mb-3 @error('offer_model') has-error @enderror">
                        <label class="col-sm-3 col-form-label">Offer Model</label>
                        <div class="col-sm-9">
                            <select name="offer_model" class="form-select" id="offer_model">
                                <option disabled selected>Choose...</option>
                                <option value="CPL" {{ old('offer_model', $offer->offer_model) == 'CPL' ? 'selected' : '' }}>CPL</option>
                                <option value="CPA" {{ old('offer_model', $offer->offer_model) == 'CPA' ? 'selected' : '' }}>CPA</option>
                                <option value="CPS" {{ old('offer_model', $offer->offer_model) == 'CPS' ? 'selected' : '' }}>CPS</option>
                                <option value="RevShare" {{ old('offer_model', $offer->offer_model) == 'RevShare' ? 'selected' : '' }}>RevShare</option>
                                <option value="Hybrid" {{ old('offer_model', $offer->offer_model) == 'Hybrid' ? 'selected' : '' }}>Hybrid (CPA + RevShare)</option>
                                <option value="Dynamic" {{ old('offer_model', $offer->offer_model) == 'Dynamic' ? 'selected' : '' }}>Dynamic</option>
                            </select>
                            @error('offer_model')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <span class="help-block text-danger"></span>
                        </div>
                    </div>
                    
                    <div class="form-group row mb-3  @error('conversion_flow') has-error @enderror">
                        <label class="col-sm-3 col-form-label">Conversion Flow</label>
                        <div class="col-sm-9">
                            <input type="text" name="conversion_flow" class="form-control" placeholder="Conversion Flow"
                                value="{{ old('conversion_flow', $offer->conv_flow) }}">
                            @error('conversion_flow')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <span class="help-block text-danger"></span>
                        </div>
                    </div>
                    

                    <div class="form-group row mb-3 @error('currency') has-error @enderror" id="currency" style="{{ $offer->offer_model == 'RevShare' ? 'display: none' : '' }}">
                        <label class="col-sm-3 col-form-label">Currency</label>
                        <div class="col-sm-9">
                            <select name="currency" required class="form-select selectpicker">
                                <option disabled selected>Choose...</option>
                                <option value="USD" {{ old('currency', $offer->currency) == 'USD' ? 'selected' : '' }}>USD</option>
                                <option value="EUR" {{ old('currency', $offer->currency) == 'EUR' ? 'selected' : '' }}>EUR</option>
                                <option value="GBP" {{ old('currency', $offer->currency) == 'GBP' ? 'selected' : '' }}>GBP</option>
                                <option value="INR" {{ old('currency', $offer->currency) == 'INR' ? 'selected' : '' }}>INR</option>
                                <option value="RUB" {{ old('currency', $offer->currency) == 'RUB' ? 'selected' : '' }}>RUB</option>
                                <option value="BTC" {{ old('currency', $offer->currency) == 'BTC' ? 'selected' : '' }}>BTC</option>
                            </select>
                            @error('currency')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group row mb-3 @error('revenue') has-error @enderror" id="defaultRevenue" style="{{ $offer->offer_model == 'RevShare' ? 'display: none' : '' }}">
                        <label class="col-sm-3 col-form-label">Revenue</label>
                        <div class="col-sm-9">
                            <input type="number" name="revenue" pattern="^[0-9]{1,2}(\.[0-9]{0,6})?$" class="form-control" placeholder="Charged from advertiser. Eg: 0.3" step="0.001" value="{{ old('revenue', $offer->default_revenue) }}">
                            @error('revenue')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group row mb-3 @error('percent_revenue') has-error @enderror" id="percentRevenue" style="{{ $offer->offer_model == 'CPA' ? 'display: none' : '' }}">
                        <label class="col-sm-3 col-form-label">Percent Revenue</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="number" name="percent_revenue" pattern="^[0-9]{1,2}(\.[0-9]{0,6})?$" class="form-control" placeholder="How much percent charged to advertiser. Eg: 0.3" step="0.001" value="{{ old('percent_revenue', $offer->percent_revenue) }}">
                                <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                            </div>
                            @error('percent_revenue')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group row mb-3 @error('payout') has-error @enderror" id="defaultPayout" style="{{ $offer->offer_model == 'RevShare' ? 'display: none' : '' }}">
                        <label class="col-sm-3 col-form-label">Payout</label>
                        <div class="col-sm-9">
                            <input type="number" name="payout" pattern="^[0-9]{1,2}(\.[0-9]{0,6})?$" class="form-control" placeholder="Pay to publisher" step="0.001" value="{{ old('payout', $offer->default_payout) }}">
                            @error('payout')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group row mb-3 @error('percent_payout') has-error @enderror" id="percentPayout" style="{{ $offer->offer_model == 'CPA' ? 'display: none' : '' }}">
                        <label class="col-sm-3 col-form-label">Percent Payout</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="number" name="percent_payout" pattern="^[0-9]{1,2}(\.[0-9]{0,6})?$" class="form-control" placeholder="How much percent pay to publisher" step="0.001" value="{{ old('percent_payout', $offer->percent_payout) }}">
                                <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                            </div>
                            @error('percent_payout')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                </div>
                <!-- /.card-body mx-4 -->
            </div>

            <div class="card mb-4 shadow-lg border-left-dark">
                <div class="card-header with-border">
                    <h6 class="card-title mb-0 flex-grow-1 text-primary">
                        Targeting
                    </h6>
                </div>
                <div class="card-body mx-4">
                    <div class="form-group row mb-3 @error('countries') has-error @enderror">
                        <label class="col-sm-3 col-form-label" id="country">Country</label>
                        <div class="col-sm-9">
                            <select name="countries[]" class="form-control countries" multiple id="country">
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" {{ in_array($country->id, old('countries', $offer->countries->pluck('id')->toArray())) ? 'selected' : '' }}>
                                        [{{ $country->code }}] {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="help-block">
                                Leave blank for all
                            </small>
                            @error('countries')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- <div class="form-group row mb-3 ">
                        <label class="col-sm-3 col-form-label" id="states">States</label>
                        <div class="col-sm-9 ">
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
                    <div class="form-group row mb-3 @error('devices') has-error @enderror">
                        <label class="col-sm-3 col-form-label" id="device">Device</label>
                        <div class="col-sm-9">
                            <select name="devices[]" class="form-control devices" multiple id="device">
                                @foreach ($devices as $device)
                                    <option value="{{ $device->id }}" {{ in_array($device->id, old('devices', $offer->devices->pluck('id')->toArray())) ? 'selected' : '' }}>
                                        {{ $device->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="help-block">
                                Leave blank for all
                            </small>
                            @error('devices')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    

                    <div class="form-group row mb-3 @error('browsers') has-error @enderror">
                        <label class="col-sm-3 col-form-label" id="browser">Browser</label>
                        <div class="col-sm-9">
                            <select name="browsers[]" class="form-control browsers" multiple id="browser">
                                @foreach ($browsers as $browser)
                                    <option value="{{ $browser->id }}" {{ in_array($browser->id, old('browsers', $offer->browsers->pluck('id')->toArray())) ? 'selected' : '' }}>
                                        {{ $browser->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="help-block">
                                Leave blank for all
                            </small>
                            @error('browsers')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                </div>
            </div>

            <div class="card mb-4 shadow-lg border-left-dark">
                <div class="card-header with-border">
                    <h6 class="card-title mb-0 flex-grow-1 text-primary">Restriction Settings</h6>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body mx-4">

                    <div class="form-group row mb-3 @error('offer_permission') has-error @enderror">
                        <label class="col-sm-3 col-form-label">Offer Permission/Visibility</label>
                        <div class="col-sm-9 ">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="pubCampaign" value="public" name="offer_permission"
                                    {{ $offer->offer_permission == 'public' ? 'checked' : '' }}>
                                <label for="pubCampaign">Public</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="permCampaign" value="request" name="offer_permission"
                                    {{ $offer->offer_permission == 'request' ? 'checked' : '' }}>
                                <label for="permCampaign">Ask for Permission</label>
                            </div><br>
                            <small class="help-block">Public for all publishers, permission for
                                asking questions to run offer/campaign</small>
                        </div>
                    </div>
                    <div class="form-group row mb-3 @error('is_featured') has-error @enderror">
                        <label class="col-sm-3 col-form-label">Featured</label>
                        <div class="col-sm-9 ">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="featuredis" value=0 name="is_featured"
                                    {{ $offer->is_featured == 0 ? 'checked' : '' }}>
                                <label for="featuredis">Disable</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="featureen" value=1 name="is_featured"
                                    {{ $offer->is_featured == 1 ? 'checked' : '' }}>
                                <label for="featureen">Enable</label>
                            </div><br>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group row mb-3 @error('same_ip_conversion') has-error @enderror">
                        <label class="col-sm-3 col-form-label">Same IP Conversion</label>
                        <div class="col-sm-9 ">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" value=0 name="same_ip_conversion"
                                    {{ $offer->same_ip_conversion == 0 ? 'checked' : '' }}>
                                <label for="pubCampaign">block</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" value=1 name="same_ip_conversion"
                                    {{ $offer->same_ip_conversion == 1 ? 'checked' : '' }}>
                                <label for="permCampaign">allow</label>
                            </div><br>
                            <small class="help-block">
                                If block, conversion will be counted only once per IP address.
                            </small>
                        </div>
                    </div>

                    <div class="form-group row mb-3 @error('conversion_approval') has-error @enderror">
                        <label class="col-sm-3 col-form-label">Conversion Approval</label>
                        <div class="col-sm-9 ">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="manualConversion" value=0 name="conversion_approval"
                                    {{ $offer->conversion_approval == 0 ? 'checked' : '' }}>
                                <label for="manualConversion">manual</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="autoConversion" value=1 name="conversion_approval"
                                    {{ $offer->conversion_approval == 1 ? 'checked' : '' }}>
                                <label for="autoConversion">auto</label>
                            </div><br>
                            <small class="help-block">
                                If manual, conversion will be counted as pending conversion and need admin approval.
                            </small>
                        </div>
                    </div>

                    <div class="form-group row mb-3 @error('min_conversion_time') has-error @enderror">
                        <label for="min_conversion_time" class="col-sm-3 col-form-label">Min. Conversion Time</label>
                        <div class="col-sm-9 col-md-4">
                            <div class="row">
                                <div class="col-sm-6 ">
                                    <input name="min_conversion_time" type="number" class="form-control"
                                        value="{{ $offer->min_conversion_time }}">
                                </div>
                                <div class="col-sm-6 ">
                                    <select class="form-select" name="min_conversion_time_type">
                                        <option value="s" selected>Seconds</option>
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
                    <div class="form-group row mb-3 @error('max_conversion_time') has-error @enderror">
                        <label for="mix_conversion_time" class="col-sm-3 col-form-label">Max. Conversion Time</label>
                        <div class="col-sm-9 col-md-4">
                            <div class="row">
                                <div class="col-sm-6 ">
                                    <input name="max_conversion_time" type="number" class="form-control"
                                        value="{{ $offer->max_conversion_time }}">
                                </div>
                                <div class="col-sm-6 ">
                                    <select class="form-select" name="max_conversion_time_type">
                                        <option value="h" selected>Hours</option>
                                        <option value="d">Days</option>
                                    </select>
                                </div>
                            </div>
                            <small class="help-block">
                                If conversion happen after this time period, then it be rejected automatically.
                            </small>
                        </div>
                    </div>
                    
                    <div class="form-group row mb-3 @error('expire_at') has-error @enderror">
                        <label class="col-sm-3 col-form-label">Expire Date</label>
                        <div class="col-sm-9 ">
                            @if ($offer->expire_at)
                                @php
                                    $expireDate = new \DateTime($offer->expire_at);
                                @endphp
                                <input type="date" name="expire_at" class="form-control" placeholder="Expire Date"
                                    id="datepicker2" value="{{ $expireDate->format('Y-m-d') }}">
                            @else
                                <input type="date" name="expire_at" class="form-control" placeholder="Expire Date"
                                    id="datepicker2" value="">
                            @endif
                    
                            @error('expire_at')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <span class="help-block text-danger"></span>
                        </div>
                    </div>


                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">Refer Redirect Rule</label>
                        <div class="col-sm-9 ">
                            <select class="form-select" name="refer_rule">
                                <option value="302" {{ $offer->refer_rule == '302' ? 'selected' : '' }}>302</option>
                                <option value="302_hide" {{ $offer->refer_rule == '302_hide' ? 'selected' : '' }}>302 Hide Refer
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-3 @error('redirect_offer_id') has-error @enderror ">
                        <label class="col-sm-3 col-form-label">Redirect Offer</label>
                        <div class="col-sm-9 ">
                            <select name="redirect_offer_id" id="" class="form-select redirectOffer" data-placeholder="Choose..">
                                <option disabled selected>Choose...</option>
                                @if ($offer->redirect_offer_id != null)
                                    <option value="{{ $offer->redirect_offer_id }}" selected>
                                        {{ $offer->redirectOfferParent->name }}</option>
                                @endif
                            </select>
                            <span class="help-block text-danger"></span>
                            <small class="help-block">If you want to redirect ther offer to a specific offer when this offer
                                expired / paused / close.</small>
                        </div>
                    </div>                                   
                </div>
            </div>
            <div class="text-center mb-5">
                <button type="submit" class="btn btn-primary">Update Offer</button>
            </div> 
        </form>  
    </div>
</div>
    
    
@endsection

@push('scripts')
    <!-- Select2 -->
    <script src="{{ asset('assets/libs/select2/select2.full.min.js') }}"></script>
    <!-- Clipboard -->
    <script src="{{ asset('assets/libs/clipboard/clipboard.min.js') }}"></script>
    <script>
        $(function() {
            $('.categories').select2({
                ajax: {
                    url: '{{ route('admin.getCategories') }}',
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
                    url: '{{ route('admin.getCountries') }}',
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

            $('.states').select2({
                ajax: {
                    url: '{{ route('admin.getStates') }}',
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
                    url: '{{ route('admin.getDevices') }}',
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
                    url: '{{ route('admin.getBrowsers') }}',
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

            $('.redirectOffer').select2({
                ajax: {
                    url: '{{ route('admin.getOffers') }}',
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
                } else if (this.value == 'Dynamic') {
                    $('#percentRevenue, #percentPayout').show();
                    $('#defaultRevenue, #defaultPayout, #currency').hide();
                } else {
                    $('#defaultRevenue, #defaultPayout, #currency').show();
                    $('#percentRevenue, #percentPayout').hide();
                }
            });
        });
    </script>
    <!-- ClipboardJS-->
    <script>
        var clipboard = new ClipboardJS('.clickBtn');
        var clipboard = new ClipboardJS('.offerBtn');
        var clipboard = new ClipboardJS('.stuBtn');
        var clipboard = new ClipboardJS('.stuClickBtn');
        var clipboard = new ClipboardJS('.sourceBtn');
        var clipboard = new ClipboardJS('.stuSub1Btn');
        var clipboard = new ClipboardJS('.stuSub2Btn');
        var clipboard = new ClipboardJS('.stuSub3Btn');
        var clipboard = new ClipboardJS('.stuSub4Btn');
        var clipboard = new ClipboardJS('.stuSub5Btn');
    </script>
    <script>
    $(document).ready(function() {
        $(".clickBtn, .offerBtn, .stuBtn, .sourceBtn, .stuClickBtn, .stuSub1Btn, .stuSub2Btn, .stuSub3Btn, .stuSub4Btn, .stuSub5Btn").click(function() {
            var clipboardText = $(this).data("clipboard-text");
            $("#tracking_url").val(function(index, currentValue) {
                return currentValue + clipboardText;
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        function updatePackageFieldVisibility() {
            var selectedOption = $('#tracking_type').val();
            if (selectedOption === 's2s') {
                $('#packageField').hide();
            } else if (selectedOption === 'offline') {
                $('#packageField').show();
            }
        }

        // Call the function when the page loads and when the "Conversion Tracking" field changes.
        updatePackageFieldVisibility();
        $('#tracking_type').on('change', updatePackageFieldVisibility);
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
