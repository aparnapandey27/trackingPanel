@extends('admin.layout.app')

@section('title', 'Create Offer')
@push('style')
<link rel="stylesheet" href="{{ asset('assets/libs/summernote/summernote-lite.min.css') }}">
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
   /* display: inline-flex; */
   -webkit-card-align: center;
   -ms-flex-align: center;
   align-items: center;
   padding-left: 20px;
   margin-right: .75rem;
   }
</style>
@endpush
@section('content')
<div class="page-content">
   <div class="container-fluid">
      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
         <h4 class="mb-sm-4">{{__('Create Offer')}}</h4>
         <div class="page-title-right">
            <ol class="breadcrumb m-0">
               <li class="breadcrumb-item">
                  <a href="javascript: void(0);">{{__('Offer')}}</a>
               </li>
               <li class="breadcrumb-item active">{{__('Create Offer')}}</li>
            </ol>
         </div>
      </div>
      <form action="{{ route('admin.offers.store') }}" METHOD="post" enctype="multipart/form-data">
         @csrf        
         <div class="card mb-4 shadow-lg border-left-dark">
            <div class="card-header with-border">
               <h6 class="card-title mb-0 flex-grow-1 text-primary">Offer Details</h6>
               <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body mx-4">
               @foreach ($errors->all() as $error)
               <div class="alert alert-danger alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                     aria-hidden="true">&times;</span></button>
                  <strong>Error!</strong> {{ $error }}.
               </div>
               @endforeach
               <div class="form-group row mb-3 @error('advertiser_id') has-error @enderror">
                  <label class="col-sm-2 col-form-label">Advertiser</label>
                  <div class="col-sm-15">
                      <select name="advertiser_id" class="form-select selectpicker user-select @error('advertiser_id') is-invalid @enderror" placeholder="Choose..." >
                          <option disabled selected>Choose...</option>
                          @foreach ($advertisers as $advertiser)
                              <option value="{{ $advertiser->id }}" {{ old('advertiser_id') == $advertiser->id ? 'selected' : '' }}>
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
                  <label class="col-sm-2 col-form-label">Title</label>
                  <div class="col-sm-15">
                     <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" maxlength="100" value="{{ old('title') }}" placeholder="Enter Offer Title" >
                     @error('title')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="form-group row mb-3 @error('thumbnail') has-error @enderror">
                  <label class="col-sm-2 col-form-label">Thumbnail</label>
                  <div class="col-sm-15">
                     <input class="form-control @error('thumbnail') is-invalid @enderror" type="file" id="formFile" name="thumbnail" accept="image/*" >
                     @error('thumbnail')
                     <span class="invalid-feedback text-danger" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="form-group row mb-3 @error('description') has-error @enderror">
                  <label class="col-sm-2 col-form-label" >Description</label>
                  <div class="col-sm-15">
                     <textarea id="summernote" name="description" required >{{ old('description') }}</textarea>
                     @error('description')
                     <span class="invalid-feedback text-danger" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="form-group row mb-3 @error('preview_url') has-error @enderror">
                  <label class="col-sm-2 col-form-label">Preview URL</label>
                  <div class="col-sm-15">
                     <input type="url" class="form-control" name="preview_url" value="{{ old('preview_url') }}" >
                     @error('preview_url')
                     <span class="invalid-feedback text-danger" role="alert" >
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                     <small class="help-block">Link to preview landing page which publishers can see</small>
                  </div>
               </div>
               <div class="form-group row mb-3 @error('conversion_tracking') has-error @enderror postback conv_tracking"
                  data-target-el='#conversion_tracking_domains'>
                  <label class="col-sm-2 col-form-label">Conversion Tracking</label>
                  <div class="col-sm-15">
                     <select name="conversion_tracking" id='tracking_type' class="form-select" >
                        <option disabled selected>Choose...</option>
                        <option value="s2s" {{ old('conversion_tracking') == 's2s' ? 'selected' : '' }}>Server Postback</option>
                        <option value="offline" {{ old('conversion_tracking') == 'offline' ? 'selected' : '' }}>Offline</option>
                        <!--<option value="iframe">IFrame Pixel</option>-->
                        <!--<option value="image">Image Pixel</option>-->
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
                  <label for="package" class="col-sm-2 col-form-label">Package Name</label>
                  <div class="col-sm-15">
                     <input type="text" name="package" class="form-control" maxlength="100" value="{{ old('package') }}" id="package" placeholder="Enter Package Name" style="width: 120%"/>
                     @error('package')
                     <span class="invalid-feedback text-danger" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="form-group row mb-3 @error('tracking_url') has-error @enderror">
                  <label class="col-sm-2 col-form-label">Default Campaign URL</label>
                  <div class="col-sm-15 autoHeight">
                     <input type="url" class="form-control" name="tracking_url" value="{{ old('tracking_url') }}" required id="tracking_url" >
                     @error('tracking_url')
                     <span class="invalid-feedback text-danger" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                     <small class="help-block">The campaign URL where traffic will redirect to. {click_id}
                     variable/params is required to track. Optional variabled/params
                     can be used in URL.</small>
                     <hr>
                     <small class="tracking_macros">
                     <b>Most Used URL tokens</b><br>
                     <button type="button" class="btn btn-rounded  btn-light btn-sm clickBtn"
                        title="Unique Click ID generated by System"
                        data-clipboard-text="{click_id}">{click_id}</button>
                     <button type="button" class="btn btn-rounded btn-light btn-sm offerBtn"
                        title="Unique Campaign ID" data-clipboard-text="{offer_id}">{offer_id}</button>
                     <button type="button" class="btn btn-rounded btn-light btn-sm stuBtn"
                        title="User ID of the student" data-clipboard-text="{stu_id}">{stu_id}</button>
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
                  <label class="col-sm-2 col-form-label">Category</label>
                  <div class="col-sm-15">
                      <select name="category_id" class="form-select selectpicker user-select @error('category_id') is-invalid @enderror" placeholder="Choose...">
                          <option disabled selected>Choose...</option>
                          @foreach ($categories as $category)
                              <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                  {{ $category->name }}
                              </option>
                          @endforeach
                      </select>
                      @error('category_id')
                          <span class="invalid-feedback text-danger" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                      <span class="help-block text-danger"></span>
                  </div>
              </div>
              
               <div class="form-group row mb-3 @error('status') has-error @enderror">
                  <label class="col-sm-2 col-form-label">Status</label>
                  <div class="col-sm-15">
                     <select name="status" class="form-select" placeholder="Choose a campaign status" >
                        <option disabled selected>Choose...</option>
                        <option value="1" @if(old('status') == '1') selected @endif>Active</option>
                        <option value="0" @if(old('status') == '0') selected @endif>Pending</option>
                        <option value="3" @if(old('status') == '3') selected @endif>Expire</option>
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
                  <label class="col-sm-2 col-form-label">Note (Optional)</label>
                  <div class="col-sm-15">
                     <textarea class="form-control" name="note" rows="3" >{{ old('note') }}</textarea>
                     <small class="help-block">The content will not be displayed to advertiser or publisher</small>
                     @error('note')
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
               <h6 class="card-title mb-0 flex-grow-1 text-primary">Revenue and Payout</h6>
            </div>
            <!-- /.card-header -->
            <div class="card-body mx-4">
               <div class="form-group row mb-3 @error('offer_model') has-error @enderror">
                  <label class="col-sm-2 col-form-label">Offer Model</label>
                  <div class="col-sm-15">
                     <select name="offer_model" class="form-select" id="offer_model" >
                        <option disabled selected>Choose...</option>
                        <option value="CPL" {{ old('offer_model') == 'CPL' ? 'selected' : '' }}>CPL</option>
                        <option value="CPA" {{ old('offer_model') == 'CPA' ? 'selected' : '' }}>CPA</option>
                        <option value="CPS" {{ old('offer_model') == 'CPS' ? 'selected' : '' }}>CPS</option>
                        <option value="RevShare" {{ old('offer_model') == 'RevShare' ? 'selected' : '' }}>RevShare</option>
                        <option value="Hybrid" {{ old('offer_model') == 'Hybrid' ? 'selected' : '' }}>Hybrid (CPA + Revshare)</option>
                        <option value="Dynamic" {{ old('offer_model') == 'Dynamic' ? 'selected' : '' }}>Dynamic</option>
                     </select>
                     @error('offer_model')
                     <span class="invalid-feedback text-danger" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                     <span class="help-block text-danger"></span>
                  </div>
               </div>
               <div class="form-group row mb-3 @error('conversion_flow') has-error @enderror">
                  <label class="col-sm-2 col-form-label">Conversion Flow</label>
                  <div class="col-sm-15">
                     <input type="text" name="conversion_flow" class="form-control" placeholder="Conversion Flow" value="{{ old('conversion_flow') }}" >
                     @error('conversion_flow')
                     <span class="invalid-feedback text-danger" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                     <span class="help-block text-danger"></span>
                  </div>
               </div>
               <div class="form-group row mb-3 @error('currency') has-error @enderror" id="currency">
                  <label class="col-sm-2 col-form-label">Currency</label>
                  <div class="col-sm-15">
                     <select name="currency" required="" class="form-select selectpicker" >
                        <option disabled selected>Choose...</option>
                        <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                        <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                        <option value="GBP" {{ old('currency') == 'GBP' ? 'selected' : '' }}>GBP</option>
                        <option value="INR" {{ old('currency') == 'INR' ? 'selected' : '' }}>INR</option>
                        <option value="RUB" {{ old('currency') == 'RUB' ? 'selected' : '' }}>RUB</option>
                        <option value="BTC" {{ old('currency') == 'BTC' ? 'selected' : '' }}>BTC</option>
                     </select>
                     @error('currency')
                     <span class="invalid-feedback text-danger" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="form-group row mb-3 @error('revenue') has-error @enderror" id="defaultRevenue">
                  <label class="col-sm-2 col-form-label">Revenue</label>
                  <div class="col-sm-15">
                     <input type="number" name="revenue" pattern="^[0-9]{1,2}(\.[0-9]{0,6})?$" class="form-control"
                        placeholder="Charged from advertiser. Eg: 0.3" step="0.001" value="{{ old('revenue') }}" >
                     @error('revenue')
                     <span class="invalid-feedback text-danger" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="form-group row mb-3 @error('percent_revenue') has-error @enderror" id="percentRevenue"
                  style="display: none">
                  <label class="col-sm-2 col-form-label">Percent Revenue</label>
                  <div class="col-sm-15">
                     <div class="input-group">
                        <input type="number" name="percent_revenue" pattern="^[0-9]{1,2}(\.[0-9]{0,6})?$"
                           class="form-control" placeholder="How much percent charged to advertiser. Eg: 0.3"
                           step="0.001" value="{{ old('percent_revenue') }}" >
                        <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                     </div>
                     @error('percent_revenue')
                     <span class="invalid-feedback text-danger" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="form-group row mb-3 @error('payout') has-error @enderror" id="defaultPayout">
                  <label class="col-sm-2 col-form-label">Payout</label>
                  <div class="col-sm-15">
                     <input type="number" name="payout" pattern="^[0-9]{1,2}(\.[0-9]{0,6})?$" class="form-control"
                        placeholder="Pay to publisher" step="0.001" value="{{ old('payout') }}" >
                     @error('payout')
                     <span class="invalid-feedback text-danger" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="form-group row mb-3 @error('percent_revenue') has-error @enderror" id="percentPayout"style="display: none">
                  <label class="col-sm-2 col-form-label">Percent Payout</label>
                  <div class="col-sm-15">
                     <div class="input-group">
                        <input type="number" name="percent_payout" pattern="^[0-9]{1,2}(\.[0-9]{0,6})?$" class="form-control"
                           placeholder="How much percent pay to publisher" step="0.001"
                           value="{{ old('percent_payout') }}" >
                        <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                     </div>
                     @error('percent_revenue')
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
               <div class="form-group row mb-3 {{ $errors->has('countries') ? 'has-error' : '' }}">
                  <label class="col-sm-2 col-form-label" id="country">Country</label>
                  <div class="col-sm-15">
                     <select name="countries[]" class="form-control form-select countries" multiple id="country" >
                        @foreach($countries as $country)
                        <option value="{{ $country->id }}"
                        {{ (is_array(old('countries')) && in_array($country->id, old('countries'))) ? 'selected' : '' }}>
                        {{ $country->name }}
                        </option>
                        @endforeach
                    </select>
                     <small class="help-block">
                     leave blank for all
                     </small>
                     @error('countries')
                     <div class="text-danger">{{ $message }}</div>
                     @enderror
                  </div>
               </div>
               <div class="form-group row mb-3 @error('devices') has-error @enderror">
                  <label class="col-sm-2 col-form-label" id="device">Device</label>
                  <div class="col-sm-15">
                     <select name="devices[]" class="form-control devices" multiple id="device" >
                        <!-- Add options here -->
                        @foreach($devices as $device)
                        <option value="{{ $device->id }}" 
                        {{ (is_array(old('devices')) && in_array($device->id, old('devices'))) ? 'selected' : '' }}>
                        {{ $device->name }}
                        </option>
                        @endforeach
                     </select>
                     <small class="help-block">
                     leave blank for all
                     </small>
                     @error('devices')
                     <div class="text-danger">{{ $message }}</div>
                     @enderror
                  </div>
               </div>
               <div class="form-group row mb-3 @error('browsers') has-error @enderror">
                  <label class="col-sm-2 col-form-label" id="browser">Browser</label>
                  <div class="col-sm-15">
                     <select name="browsers[]" class="form-control browsers" multiple id="browser" >
                        <!-- Add options here -->
                        @foreach($browsers as $browser)
                        <option value="{{ $browser->id }}" 
                        {{ (is_array(old('browsers')) && in_array($browser->id, old('browsers'))) ? 'selected' : '' }}>
                        {{ $browser->name }}
                        </option>
                        @endforeach
                     </select>
                     <small class="help-block">
                     leave blank for all
                     </small>
                     @error('browsers')
                     <div class="text-danger">{{ $message }}</div>
                     @enderror
                  </div>
               </div>
            </div>
         </div>
         <div class="card mb-4 shadow-lg border-left-dark">
            <div class="card-header with-border">
               <h6 class="card-title mb-0 flex-grow-1 text-primary">Restriction Settings</h6>
            </div>
            <div class="card-body mx-4">
               <div class="form-group row mb-3 @error('offer_permission') has-error @enderror">
                  <label class="col-sm-2 col-form-label">Offer Permission/Visibility</label>
                  <div class="col-sm-15">
                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="pubCampaign" value="public" name="offer_permission" 
                        {{ old('offer_permission', 'public') == 'public' ? 'checked' : '' }}>
                        <label for="pubCampaign">Public</label>
                     </div>
                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="permCampaign" value="request" name="offer_permission"
                        {{ old('offer_permission') == 'request' ? 'checked' : '' }}>
                        <label for="permCampaign">Ask for Permission</label>
                     </div>
                     <br>
                     <small class="help-block">Public for all publishers, permission for asking questions to run offer/campaign</small>
                     @error('offer_permission')
                     <div class="invalid-feedback text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                     </div>
                     @enderror
                  </div>
               </div>
               <div class="form-group row mb-3 @error('is_featured') has-error @enderror">
                  <label class="col-sm-2 col-form-label">Featured</label>
                  <div class="col-sm-15">
                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="disableFeatured" value="0" name="is_featured"
                        {{ old('is_featured', '0') == '0' ? 'checked' : '' }}>
                        <label for="disableFeatured">Disable</label>
                     </div>
                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="enableFeatured" value="1" name="is_featured"
                        {{ old('is_featured') == '1' ? 'checked' : '' }}>
                        <label for="enableFeatured">Enable</label>
                     </div>
                     <br>
                     <small class="help-block"></small>
                     @error('is_featured')
                     <div class="invalid-feedback text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                     </div>
                     @enderror
                  </div>
               </div>
               <div class="form-group row mb-3 @error('same_ip_conversion') has-error @enderror">
                  <label class="col-sm-2 col-form-label">Same IP Conversion</label>
                  <div class="col-sm-15">
                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="blockSameIP" value="0" name="same_ip_conversion"
                        {{ old('same_ip_conversion', '0') == '0' ? 'checked' : '' }}>
                        <label for="blockSameIP">block</label>
                     </div>
                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="allowSameIP" value="1" name="same_ip_conversion"
                        {{ old('same_ip_conversion') == '1' ? 'checked' : '' }}>
                        <label for="allowSameIP">allow</label>
                     </div>
                     <br>
                     <small class="help-block">
                     If block, conversion will be counted only once per IP address.
                     </small>
                     @error('same_ip_conversion')
                     <div class="invalid-feedback text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                     </div>
                     @enderror
                  </div>
               </div>
               <div class="form-group row mb-3 @error('conversion_approval') has-error @enderror">
                  <label class="col-sm-2 col-form-label">Conversion Approval</label>
                  <div class="col-sm-15">
                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="manualConversion" value="0" name="conversion_approval"
                        {{ old('conversion_approval') == '0' ? 'checked' : '' }}>
                        <label for="manualConversion">manual</label>
                     </div>
                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="autoConversion" value="1" name="conversion_approval"
                        {{ old('conversion_approval', '1') == '1' ? 'checked' : '' }}>
                        <label for="autoConversion">auto</label>
                     </div>
                     <br>
                     <small class="help-block">
                     If manual, conversion will be counted as pending conversion and need admin approval.
                     </small>
                     @error('conversion_approval')
                     <div class="invalid-feedback text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                     </div>
                     @enderror
                  </div>
               </div>
               <div class="form-group row mb-3 @error('min_conversion_time') has-error @enderror">
                  <label for="min_conversion_time" class="col-sm-2 col-form-label">Min. Conversion Time</label>
                  <div class="col-sm-15 col-md-4">
                     <div class="row">
                        <div class="col-sm-6">
                           <input name="min_conversion_time" type="number" class="form-control" value="{{ old('min_conversion_time', '60') }}">
                        </div>
                        <div class="col-sm-6">
                           <select class="form-select" name="min_conversion_time_type">
                           <option value="s" {{ old('min_conversion_time_type') == 's' ? 'selected' : '' }}>Seconds</option>
                           <option value="m" {{ old('min_conversion_time_type') == 'm' ? 'selected' : '' }}>Minutes</option>
                           <option value="h" {{ old('min_conversion_time_type') == 'h' ? 'selected' : '' }}>Hours</option>
                           </select>
                        </div>
                     </div>
                     <small class="help-block">
                     If conversion happens before this time period, then it will be rejected automatically.
                     </small>
                     @error('min_conversion_time')
                     <div class="invalid-feedback text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                     </div>
                     @enderror
                  </div>
               </div>
               <div class="form-group row mb-3 @error('max_conversion_time') has-error @enderror">
                  <label for="max_conversion_time" class="col-sm-2 col-form-label">Max. Conversion Time</label>
                  <div class="col-sm-15 col-md-4">
                     <div class="row">
                        <div class="col-sm-6">
                           <input name="max_conversion_time" type="number" class="form-control" value="{{ old('max_conversion_time', '24') }}">
                        </div>
                        <div class="col-sm-6">
                           <select class="form-select" name="max_convesion_time_type">
                           <option value="h" {{ old('max_convesion_time_type') == 'h' ? 'selected' : '' }}>Hours</option>
                           <option value="d" {{ old('max_convesion_time_type') == 'd' ? 'selected' : '' }}>Days</option>
                           </select>
                        </div>
                     </div>
                     <small class="help-block">
                     If conversion happens after this time period, then it will be rejected automatically.
                     </small>
                     @error('max_conversion_time')
                     <div class="invalid-feedback text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                     </div>
                     @enderror
                  </div>
               </div>
               <div class="form-group row mb-3 @error('expire_date') has-error @enderror">
                  <label class="col-sm-2 col-form-label">Expire Date</label>
                  <div class="col-sm-15">
                     <input type="date" name="expire_date" class="form-control" placeholder="Expire Dates"
                        id="datepicker2" value="{{ old('expire_date') }}" >
                     @error('expire_date')
                     <span class="invalid-feedback text-danger" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                     <span class="help-block text-danger"></span>
                  </div>
               </div>
               <div class="form-group row mb-3 @error('refer_rule') has-error @enderror">
                  <label class="col-sm-2 col-form-label">Refer Redirect Rule</label>
                  <div class="col-sm-15">
                     <select class="form-select" name="refer_rule" >
                     <option value="302" {{ old('refer_rule') == '302' ? 'selected' : '' }}>302 with Refer</option>
                     <option value="302_hide" {{ old('refer_rule') == '302_hide' ? 'selected' : '' }}>302 with Hide Refer</option>
                     </select>
                     @error('refer_rule')
                     <span class="invalid-feedback text-danger" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="form-group row mb-3 @error('redirect_offer_id') has-error @enderror">
                  <label class="col-sm-2 col-form-label">Redirect Offer</label>
                  <div class="col-sm-15"> <!-- Changed from col-sm-10 to col-sm-15 -->
                      <select name="redirect_offer_id" class="form-select form-control selectpicker redirectOffer @error('redirect_offer_id') is-invalid @enderror" data-placeholder="Choose...">
                          <option disabled selected>Choose...</option>
                          @if(old('redirect_offer_id'))
                              @php
                                  $selectedOffer = \App\Models\Offer::find(old('redirect_offer_id'));
                              @endphp
                              @if($selectedOffer)
                                  <option selected value="{{ $selectedOffer->id }}">{{ "[".$selectedOffer->id."] ".$selectedOffer->name }}</option>
                              @endif
                          @endif
                      </select>
                      <span class="help-block text-danger">@error('redirect_offer_id') {{ $message }} @enderror</span>
                      <small class="help-block">If you want to redirect to another offer when this offer expires, pauses, or closes.</small>
                  </div>
              </div>
              
              
            </div>
         </div>
         <div class="text-center mb-4">
            <button type="submit" class="btn btn-primary">Create Offer</button>
         </div>
      </form>
   </div>
</div>
@endsection
@push('scripts')
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
   $(document).ready(function() {
       var trackingTypeSelect = $('#tracking_type');
       var packageField = $('#packageField');
   
       // Initially hide the "Package Name" field
       packageField.hide();
   
       trackingTypeSelect.on('change', function() {
           if (trackingTypeSelect.val() === 's2s') {
               packageField.hide(); // Hide the field
           } else if (trackingTypeSelect.val() === 'offline') {
               packageField.show(); // Show the field
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