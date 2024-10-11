@extends('advertiser.layout.app')
@section('title', ' Offer Detail')
@push('style')
    <!-- Sweetalert2 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
    <!-- flags -->
    <link rel="stylesheet" href="{{ asset('assets/libs/flag-icons/css/flag-icon.min.css?v=52475656') }}">
@endpush

@section('content')
<div class="page-content">
    <div class="container-fluid"> 
    <div class="row">
        <div class="col-lg-6">

            <div class="card mb-4 shadow-lg border-left-dark">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h6 class="m-0 text-primary font-weight-bold">Offer Details</h6>
                        <a href="{{ route('admin.offers.edit', $offer->id) }}" class="btn btn-sm btn-primary"><i
                                class="fa fa-edit"></i> Edit</a>
                    </div>
                </div>
                
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <p class="card-text"><span class="text-muted">Advertiser:</span> {{ $offer->advertiser_id }}</p>
                                <p class="card-text"><span class="text-muted">Offer Name:</span> {{ $offer->title }}</p>
                                <p class="card-text"><span class="text-muted">Preview URL:</span> <a
                                        href="{{ $offer->preview_url }}">{{ $offer->preview_url }}</a></p>
                                <p class="card-text"><span class="text-muted">Default Offer URL:</span> <a
                                        href="{{ $offer->url }}">{{ $offer->tracking_url }}</a></p>
                                <p class="card-text"><span class="text-muted">Conversion Flow:</span>
                                    {{ $offer->conversion_flow }}</p>
                                <p class="card-text"><span class="text-muted">Category:</span>
                                    @if ($offer->category_id != null)
                                        {{ $offer->category->name }}
                                    @endif
                                </p>
                                <p class="card-text"><span class="text-muted">Created:</span>
                                    {{ $offer->created_at->format('d-F-Y' . '  -  ' . 'h:i A') }}</p>
                                <p class="card-text"><span class="text-muted">Updated:</span>
                                    {{ $offer->updated_at->format('d-F-Y' . '  -  ' . 'h:i A') }}</p>
                                <p class="card-text"><span class="text-muted">Expire Date:</span> {{ $offer->expire_at }}
                                </p>
                                <p class="card-text"><span class="text-muted">Description:</span> {!! $offer->description !!} </p>
                            </div>
                            <div class="col-md-4">
                                <img src="{{ asset("storage/offers/$offer->thumbnail") }}" class="img-fluid img-thumbnail izoom"
                                    width="150" style="max-width: 150px; max-height: 150px; min-width: 85px; min-height: 85px;">
                            </div>
                        </div>
                    
                </div>
                
            </div>

            <div class="card mb-4 shadow-lg border-left-dark">
                <div class="card-header with-border">
                    <div class="d-flex justify-content-between">
                        <h6 class="m-0 text-primary font-weight-bold">Revenue and Payout</h6>
                        <!-- <a href="{{ route('advertiser.offer.edit', $offer->id) }}" class="btn btn-sm btn-primary"><i
                                class="fa fa-edit"></i> Manage Payouts &amp; Goals</a> -->
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                        <thead class="table-light">
                                <tr>
                                    <th>Event Name</th>
                                    <th>Object</th>
                                    <th>Payout</th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Default</td>
                                    <td>{{ $offer->offer_model }}</td>
                                    <td>
                                        @if ($offer->offer_model == 'RevShare' || $offer->offer_model == 'Dyamic')
                                            {{ $offer->percent_revenue }} %
                                        @elseif ($offer->offer_model == 'Hybrid')
                                            {{ $offer->default_revenue }} {{ $offer->currency }} +
                                            {{ $offer->percent_revenue }} %
                                        @else
                                            {{ $offer->default_revenue }} {{ $offer->currency }}
                                        @endif
                                    </td>
                                    <td></td>
                                </tr>
                                @foreach ($offer->goals as $goal)
                                    <tr>
                                        <td>{{ $goal->name }}</td>
                                        <td>{{ $goal->pay_model }}</td>
                                        <td>
                                            @if ($goal->object == 'RevShare' || $goal->object == 'Dynamic')
                                                {{ $goal->percent_revenue }} %
                                            @elseif ($goal->object == 'Hybrid')
                                                {{ $goal->default_revenue }} {{ $goal->currency }} +
                                                {{ $goal->percent_revenue }} %
                                            @else
                                                {{ $goal->default_revenue }} {{ $goal->currency }}
                                            @endif
                                        </td>
                                        <td>
                                            <!-- <a href="{{ route('advertiser.offer.goal.edit', [$offer->id, $goal->id]) }}"
                                                class=""><i class="fa fa-edit"></i> edit</a> |
                                            <a href="{{ route('advertiser.offer.goal.destroy', $goal->id) }}"
                                                class=""><i class="fa fa-trash"></i> delete</a> -->
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
        </div>

        <div class="col-lg-6">
            {{-- <div class="card mb-4 shadow-lg border-left-dark">
                <div class="card-header with-border">
                    <h6 class="m-0 text-primary font-weight-bold">Tracking Link</h6>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group">
                        <select class="form-control student"
                            data-placeholder="Choose any Offer to Generate Its Tracking Link"
                            onchange="generateLink({{ $offer->id }})"></select>
                        <small class="help-block">To generate a tracking link, select any Offer from below. Tracking
                            links records click for reporting.</small>
                    </div>
                    <div class="form-group">
                        <label class="text-muted">Generated Link</label>
                        <textarea class="form-control trLink mb-4" name="url"></textarea>
                    </div>
                </div>
                <!-- /.card-body -->
            </div> --}}

            <div class="card mb-4 shadow-lg border-left-dark">
                <div class="card-header with-border">
                    <h6 class="m-0 text-primary font-weight-bold">Setting and Targeting</h6>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <p class="card-text"><span class="text-muted">Country:</span>
                        @forelse($offer->countries as $country)
                            <i class="flag-icon flag-icon-{{ Str::lower($country->code) }}"></i> {{ $country->name }},
                        @empty
                            <i class="flag-icon flag-icon-ww"></i> World Wide
                        @endforelse
                    </p>
                    <p class="card-text"><span class="text-muted">Device:</span>
                        @forelse($offer->devices as $device)
                            @if ($device->name == 'Desktop')
                                <i class="bx bx-desktop" style="color:rgb(0, 0, 0)"></i>
                            @elseif ($device->name == 'Tablet')
                                <i class=" bx bx-tab" style="color:rgb(0, 0, 0)"></i>
                            @elseif ($device->name == 'Mobile')
                                <i class="bx bx-mobile" style="color:rgb(0, 0, 0)"></i>
                            @endif
                        @empty
                            <i class="bx bx-desktop" style="color:rgb(0, 0, 0)"></i>
                            <i class="bx bx-tab" style="color:rgb(0, 0, 0)"></i>
                            <i class="bx bx-mobile" style="color:rgb(0, 0, 0)"></i>
                        @endforelse
                    </p>
                    <p class="card-text"><span class="text-muted">Browser:</span>
                        @forelse($offer->browsers as $browser)
                            {{ $browser->name }},
                        @empty
                            All
                        @endforelse
                    </p>
                    <p class="card-text"><span class="text-muted">Featured:</span>
                        @if ($offer->is_featured == 1)
                            <span class=" badge bg-black text-black text-uppercase">Enable</span>
                        @else
                            <span class=" badge bg-black text-black text-uppercase">Disable</span>
                        @endif
                    </p>
                    <p class="card-text"><span class="text-muted">Redirect Offer:</span>
                        @if ($offer->redirect_offer_id != null)
                            <a href="{{ route('admin.offers.show', $offer->redirect_offer_id) }}">(OfferID
                                #{{ $offer->redirectOfferParent->id }})
                                - {{ $offer->redirectOfferParent->name }}</a>
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                <!-- /.card-body -->
            </div>

            <div class="card mb-4 shadow-lg border-left-dark">
                <div class="card-header">
                    <h6 class="m-0 text-primary font-weight-bold">Postback / Pixel</h6>
                </div>
                <div class="card-body">
                    <!-- /.card-header -->
                    <div class="card-body">

                        <form action="" style="padding: 20px">
                            <input type="hidden" name="offer_id" value="{{ $offer->id }}" id="offer_id">
                            <input type="hidden" name="security_token" value="{{ $offer->advertiser->security_token }}"
                                id="security_token">
                            <input type="hidden" name="offer_model" value="{{ $offer->offer_model }}">
                            <input type="hidden" name="conversion_tracking" value="{{ $offer->conversion_tracking }}"
                                id="type">

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Postback /Pixel Type</label>
                                <div class="col-sm-9 col-md-6">
                                    <div class="radio radio-success form-check-inline">
                                        <input type="radio" id="global" value="global" name="pixel_type">
                                        <label for="global">Global level</label>
                                    </div>
                                    <div class="radio radio-success form-check-inline">
                                        <input type="radio" id="offer" value="offer" name="pixel_type" checked=" checked">
                                        <label for="offer">Offer level</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="goal_id" class="col-sm-3 col-form-label">Choose Goal</label>
                                <div class="col-sm-9 col-md-6">
                                    <select class="form-control" id="goal_id">
                                        <option value="">Default</option>
                                        @foreach ($offer->goals as $goal)
                                            <option value="{{ $goal->id }}">{{ $goal->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class=" pull-right" style="margin-bottom: 20px ">
                                <button type="button" class="btn btn-primary btn-sm"
                                    onclick="generatePostback()">Generate</button>
                            </div>
                    </div>
                    </form>
                    <div class="form-group mx-4">
                        <label class="text-muted">Generated Postback / Tracking Pixel</label>
                        <textarea class="form-control" name="postback_url" id="postback_url" rows="3"></textarea>
                        <small class="help-block">Postback / Tracking Pixel is a pixel that is fired when the click
                            convertion in lead/sale on the offers. This is a great way to track conversions and
                            revenue. This must be placed in advertiser end</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/libs/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        function generateLink(offerId) {
            let userId = $('.student').val();
            if (offerId == null) {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please select any student to generate tracking link',
                    timer: 5000
                })
            } else {
                let link = `{{ asset('/') }}click?aid=${userId}&oid=${offerId}`;
                $('.trLink').val(link);
            }

        }

        $('.student').select2({
            ajax: {
                url: '{{ route('admin.getStudents') }}',
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
    </script>
    <script>
        function generatePostback() {
            let offerId = $('#offer_id').val();
            let goalId = $('#goal_id').val();
            let type = $('#type').val();
            let security_token = $('#security_token').val();
            let pixel_type = $('input[name=pixel_type]:checked').val();
            let offerModel = $('#offer_model').val();
            let goal = goalId == '' ? '' : `&goal_id=${goalId}`;
            let global = pixel_type == 'offer' ? `&offer_id=${offerId}` : '';
            let sale = offerModel == 'RevShare' ? `&sale_amount=SALE_AMOUNT` : '';
            let token = security_token ? `&token=${security_token}` : '';

            if (type == 's2s') {
                let postback =
                    `{{ config('app.postback_domain') ? config('app.postback_domain') . '/' : asset('/') }}track?click_id=CLICK_ID${global}${goal}${sale}${token}`;
                $('#postback_url').val(postback);
            } else if (type == 'image') {
                let postback =
                    `<img src="{{ config('app.postback_domain') ? config('app.postback_domain') . '/' : asset('/') }}pixel?${global}${goal}${sale}${token}">`;
                $('#postback_url').val(postback);
            } else if (type == 'iframe') {
                let postback =
                    `<iframe src="{{ config('app.postback_domain') ? config('app.postback_domain') . '/' : asset('/') }}pixel?${global}${goal}${sale}${token}" width="0" height="0" frameborder="0" style="display:none"></iframe>`;
                $('#postback_url').val(postback);
            }

        }
    </script>
@endpush
