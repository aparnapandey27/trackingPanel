@extends('employee.layout.app')
@section('title', 'Offer Details')
@push('style')
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
    <!-- Sweetalert2 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">        
            <div class="row mb-4">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{__('Offers')}}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{__('Offers')}}</a></li>
                                <li class="breadcrumb-item active">{{__('Manage')}}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="row g-2 align-items-center">
                        <div class="col-sm-4">
                            <h4 class="card-title mb-0 flex-grow-1 text-primary">Manage Offers</h4>
                        </div>                                                               
                    </div>                            
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-6">

                    <div class="card mb-4 shadow-lg border-left-dark">
                        <div class="card-header">
                            <h6 class="card-title mb-0 flex-grow-1 text-primary">Offer Details</h6>
                        </div>
                        <div class="card-body">
                        <div class="row">
                                <div class="col-xl-9">
                                    <p class="card-text"><span class="text-muted">Offer Name:</span> {{ $offer->name }}</p>
                                    <p class="card-text"><span class="text-muted">Preview URL:</span> <a
                                            href="{{ $offer->preview_url }}">{{ $offer->preview_url }}</a></p>
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
                                    <p class="card-text">
                                        <span class="text-muted">Expire Date:</span>
                                        @if ($offer->expire_at instanceof \Carbon\Carbon)
                                            {{ $offer->expire_at->format('Y-m-d') }}
                                        @elseif ($offer->expire_at)
                                            {{ \Carbon\Carbon::parse($offer->expire_at)->format('Y-m-d') }}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                    <p class="card-text"><span class="text-muted">Description:</span> {!! $offer->description !!} </p>
                                </div>
                                <div class="col-xl-3">
                                    @if ($offer->thumbnail != null)
                                        <img src="{{ asset("storage/offers/$offer->thumbnail") }}"
                                            class="img-fluid img-thumbnail izoom" width="150"
                                            style="max-width: 150px;max-height: 150px;min-width: 85px;min-height: 85px;">
                                    @else
                                        <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxAQEBIQEBIQFhAPEBEQEBgPERsPEA8PFRIXFxUWFRMYKCggGBolGxUWITEhJSsrLi4uFx8zODMsNygtLisBCgoKDQ0NDw0NDy0ZFRktLSsrKy0rKysrKysrKysrKysrKystKysrKysrKysrKysrKysrKysrKysrKysrKysrK//AABEIAL4BCgMBIgACEQEDEQH/xAAaAAEAAwEBAQAAAAAAAAAAAAAABAUGAwEC/8QAORAAAgEBAwcJBwQDAQAAAAAAAAECAwURIQQVMVFSkZISMjNBYXFyoeEUQoGCsbLRImKiwRNj8FP/xAAVAQEBAAAAAAAAAAAAAAAAAAAAAf/EABQRAQAAAAAAAAAAAAAAAAAAAAD/2gAMAwEAAhEDEQA/AN4AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAPUr8Fp7MSXRsyrL3bl+53eWkCGC6o2LH35N9kcFvZPo5HThzYrveL3sDPUcjqT5sXdreC3snUbFfvyS7Iq97y6OUsogmouUeU3clfe7yCuy2zIRpScU+VHG9u93LT5FKa6UU009DVz7mZSrT5MnF+62tzKPgAAAAAAAAAAAAAAAAAAAAAAAAAAAd6OR1J82Lu1vBb2T6Niy9+SXZHF7wKk+6VKUsIxb7leaGjZlKPu3v8Adj5aCWklgsF2YICho2RUfOuiu3F7kTqNj01zr5PtwW5E6rVjHGUku93EGta9Nc2+T7MFvZBNpUYx5sUu5XH23di9HaUNa16j5t0V2YveyDVqyljJt97vKNDWtOlH3r3+3Hz0EGtbUvcil2yxe4qQB3rZZUnzpO7UsFuRxjJpprSneu88AGtpTUoqS0SSe8orapcmpf1TSfxWD/reWFi1eVSu64Nr4aV/e4+bcpX01LYfk8PrcQUIAKAAAAAAAAAAAAAAAegeAn5NZc5pSvSi1er8Xd3IsKNj01zm5d+C3IChSvwWnsxJdGzasvduX7sPLSaClSjDCMUu5XH23di9HkBVUbFXvyb7I4LeT6OR04c2Kv1vF72cq1pUo+9e/wBuPnoINa2n7kUu2Tve4gujhWyynDnSV+pYvcjPVssqT50ndqWC3IjlF1WtqPuRb7ZYLcQa1p1Ze9cv24eekhgD1tvF6e3E8AAFlktkykr5Pkp6FdfL0OVk0VOqr9EU5d92jzaNGBT1LEV36Z4/uWHkVdejKD5Mlc1/2BrCutuinT5XXBrc3c19AKAAAWVh1bqjjtrzWP0vLqvT5cZR2k0ZfJ6nInGWy0/h1mrTIMi0eEu1KXJqy1S/Uvjp87yIUAAAAAAAAAAAAAAAAaCxKvKp3dcHd8Hiv7JWV1/8cHO5u67RhpZT2HVuqOPVNeax/JdV6fKjKO0miCkrWxUfNSit73s61bLrSxlOL723/RVNXYPStJryihzLU2ob3+BmWptQ3v8ABczymEXc5xTXU2kz59spbcOJEVUZlqbUN7/AzLU2ob3+C39spbcOJD2yltw4kBUZlqbUN7/AzLU2ob3+C39spbcOJD2yltw4kBUZlqbUN7/AzLU2ob3+C39spbcOJD2yltw4kBCs6z50p8puLVzTubv+nYWhw9spbcOJD2yltw4kB3I2X0ZVIOMbr21p1J3n17ZS24cSHtlLbhxICozLU2ob3+BmWptQ3v8ABb+2UtuHEh7ZS24cSAqMy1NqG9/guclg4wjGV18Vc7tGGg+fbKW3DiQ9spbcOJARrTyB1XFxaTV6d/Wur+yDmWptQ3v8Fv7ZS24cSOyd+K0PR2oDL5Xkzpy5Mmr7k8DgWNudKvBH6srioAAAAAAAAAAAAAOlCpyJRlstM1ad+K6zIGksqryqUdcf0v4elwFPatLk1ZapfqXx0+d5oyqt+lhGepuL+OK+jLUis7a/TT+X7UQiba/TT+X7UQioAHoHgAAAAAAAABYZBZjqLlSd0Xo1y9AK8F+7HpXe/vKzL8glSx0xeCep6mgIYAAGryXmQ8EftRlDV5LzIeCP2oCltzpV4I/VlcWNudKvBH6srgAAAAAAAAAAAAAAW1gVcZQ1rlLvWD/oqSRkFXkVIy6r7n3PBgaDL6XLpzj13XrvWKO56eEVnbX6afy/aiETbX6afy/aiEVAsbIyNVHJyX6Uru+T/BXpGoyKh/jhGPXpfien/uwCiy/IZUnrg9D/AKfaQzXTimmmr09N5Q2jZzp/qjjDzj39naBXgAACQ8jn/jVS79L1aUtbWojgdKFPlTjHaklvZq0rsF1YfAyVOfJaktMWnuZqqNVTipR0Nf8AIDoc8opKcJRfWmvwdCNl+UKnBvrauj2yZFZgAFQNXkvMh4I/ajKGryXmQ8EftQFLbnSrwR+rK4sbc6VeCP1ZXAAAAAAAAAAAAAAAAAanIqvLpxlrWPesH5o7FXYNW+Moanyl3PT9PMtCKztr9NP5ftRCJtr9NP5ftRCKiwsbJ+VU5T0Qx+bq/PwNARbOyf8Ax00ut/ql3slEUPGegCktKzLr501hpa1dq7CBktF1Jxiut49i62ao4UslhGbnFXOSuer4FR2jFJXLQlcu4qsvsq++VPB9cep92ruLYEVkGmsHpWm87ZLlc6fNeD0p4pl7l2QRq46J9T19+soMooSpvkyVz6tTXYyonu2p7Mb/AI/QgZRlEqjvk735LuRyAAAADV5LzIeCP2oyhq8l5kPBH7UBS250q8EfqyuLG3OlXgj9WVwAAAAAAAAAAAAAAAAE2yavJqx1Svi/jo80jRGRjK5prSnejXgZy1+mn8v2oWTk/LqK/mw/U/6Qtfpp/L9qLKw4JU7+tyd/w0AWIAIoAAAAAAAAcq9CM1yZK9ea7mdQBm8uyCVLHTDqervIZr2r8Hoem8prQsq6+VPR1x613a+4qKkHp4ANXkvMh4I/ajKGryXmQ8EftQFLbnSrwR+rK4sbc6VeCP1ZXAAAAAAAAAAAAAAAAADXmQNeBnbX6afy/ai0sXol4pFXa/TT+X7UfWR2k6ceSop4t4vWBoQUme5bEd7Pc9y2FxMiroFLnuWwuIZ7ewuIC6BTZ7ewuL0Ge3sLi9ALkFNnt/8AmuL0Pc9/6/5egFwCnz3/AK/5+gz3/r/l6AXAKjPn+v8Al6DPa/8AP+XoBIy+zo1P1Rwn5S7/AMlDVpSg+TJXNFtntf8Am+L0OOVWjTqK6VN9jUsV3YFRWGryXmQ8EftRlTVZLzIeCP2oCltzpV4I/VlcWNudKvBH6srgAAAAAAAAAAAAAAAABsDHl1ntbD4gJdez6c5OUk73dfi1oVx8Zpo6nxMj57Ww+L0Ge1sPi9AJGaaOp8TGaaOp8TI+e1sPi9BntbD4vQCRmmjqfExmmjqfEyPntbD4vQZ7Ww+L0AkZpo6nxMZpo6nxMj57Ww+L0Ge1sPi9AJGaaOp8TGaaOp8TI+e1sPi9BntbD4vQCRmmjqfExmmjqfEyPntbD4vQZ7Ww+L0AkZpo6nxMZpo6nxMj57Ww+L0Ge1sPi9AJGaaOp8TGaaOp8TI+e1sPi9BntbD4vQCRmmjqfEyZCKSSWhJJdyKvPa2Hxegz2th8XoBGtzpV4I/VlcScvyn/ACz5V136UtN+i8jAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAH//2Q==" style="width: 100px; height: 60px">
                                    @endif
                                </div>                                
                            </div>  
                            
                            
                        </div>
                    </div>

                    
                    
                    <div class="card mb-4 shadow-lg border-left-dark">
                        <div class="card-header with-border">
                            <div class="row g-2 align-items-center">
                                <div class="col-sm-4">
                                    <h6 class="card-title mb-0 flex-grow-1 text-primary">Student Offer Payout</h6>
                                </div>                
                                <div class="col-sm-auto ms-auto">
                                    <div class="list-grid-nav hstack gap-1">                                        
                                        <a href="{{ route('employee.offer.student.create', $offer->id) }}" class="btn btn-primary btn-sm"><i class="ri-add-fill"></i> Add Student Payout</a>
                                    </div>                            
                                </div>                        
                            </div>                            
                        </div>
                    
                        <div class="card-body">                            
                            <div class="table-responsive ">
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Student Name</th>
                                            <th>Event Name</th>
                                            <th>Pay Model</th>
                                            <th>Payout</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($offer->offerStudents as $offerStudent)
                                            @if ($offerStudent->user->manager_id ==$manager_id)
                                            <tr>
                                                <td>{{ $offerStudent->user->name }}</td>
                                                <td>{{ $offerStudent->name }}</td>
                                                <td>{{ $offerStudent->pay_model }}</td>
                                                <td>{{ $offerStudent->default_payout }}</td>
                                                <td>
                                                    <a href="{{ route('employee.offer.student.edit', [$offer->id, $offerStudent->id]) }}"
                                                        class=""><i class="ri-edit-line fs-16 text-info"></i></a>
                                                    <a href="javascript:void(0)" onclick="deleteStudent({{ $offerStudent->id }})">
                                                        <i class="ri-delete-bin-line fs-16 text-danger"></i></a>
                                                </td>
                                            </tr>
                                        @endif    
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="card mb-4 shadow-lg border-left-dark">
                        <div class="card-header with-border">
                            <h6 class="card-title mb-0 flex-grow-1 text-primary">Tracking Link</h6>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group mb-3">
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
                    </div>


                </div>

                <div class="col-lg-6">

                <div class="card mb-4 shadow-lg border-left-dark">
                        <div class="card-header with-border">
                            <h6 class="card-title mb-0 flex-grow-1 text-primary">Targeting</h6>

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
                            {{-- <p class="card-text"><span class="text-muted">States:</span>
                                @forelse($offer->states as $state)
                                    {{ $state->state_name }} / <i
                                        class="flag-icon flag-icon-{{ Str::lower($state->country->code) }}"></i>
                                    {{ $state->country->name }},
                                @empty
                                    <i class="flag-icon flag-icon-ww"></i> World Wide
                                @endforelse
                            </p> --}}
                            <p class="card-text"><span class="text-muted">Device:</span>
                                @forelse($offer->devices as $device)
                                    @if ($device->name == 'Desktop')
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 576 512"><path fill="currentColor" d="M528 0H48C21.5 0 0 21.5 0 48v320c0 26.5 21.5 48 48 48h192l-16 48h-72c-13.3 0-24 10.7-24 24s10.7 24 24 24h272c13.3 0 24-10.7 24-24s-10.7-24-24-24h-72l-16-48h192c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48zm-16 352H64V64h448v288z"/></svg>
                                    @elseif ($device->name == 'Tablet')
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path fill="currentColor" d="M2 2c0-1.1.9-2 2-2h12a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm2 0v14h12V2H4zm6 17a1 1 0 1 0 0-2a1 1 0 0 0 0 2z"/></svg>
                                    @elseif ($device->name == 'Mobile')
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16"><path fill="currentColor" d="M11.5 0h-7C3.675 0 3 .675 3 1.5v13c0 .825.675 1.5 1.5 1.5h7c.825 0 1.5-.675 1.5-1.5v-13c0-.825-.675-1.5-1.5-1.5zM6 .75h4v.5H6v-.5zM8 15a1 1 0 1 1 0-2a1 1 0 0 1 0 2zm4-3H4V2h8v10z"/></svg>
                                    @endif
                                @empty
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 576 512"><path fill="currentColor" d="M528 0H48C21.5 0 0 21.5 0 48v320c0 26.5 21.5 48 48 48h192l-16 48h-72c-13.3 0-24 10.7-24 24s10.7 24 24 24h272c13.3 0 24-10.7 24-24s-10.7-24-24-24h-72l-16-48h192c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48zm-16 352H64V64h448v288z"/></svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path fill="currentColor" d="M2 2c0-1.1.9-2 2-2h12a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm2 0v14h12V2H4zm6 17a1 1 0 1 0 0-2a1 1 0 0 0 0 2z"/></svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16"><path fill="currentColor" d="M11.5 0h-7C3.675 0 3 .675 3 1.5v13c0 .825.675 1.5 1.5 1.5h7c.825 0 1.5-.675 1.5-1.5v-13c0-.825-.675-1.5-1.5-1.5zM6 .75h4v.5H6v-.5zM8 15a1 1 0 1 1 0-2a1 1 0 0 1 0 2zm4-3H4V2h8v10z"/></svg>
                                @endforelse
                            </p>
                            <p class="card-text"><span class="text-muted">Browser:</span>
                                @forelse($offer->browsers as $browser)
                                    {{ $browser->name }},
                                @empty
                                    All
                                @endforelse
                            </p>
                        </div>
                        <!-- /.card-body -->
                    </div>

                    

                    <div class="card mb-4 shadow-lg border-left-dark">
                        <div class="card-header with-border">
                            <h6 class="card-title mb-0 flex-grow-1 text-primary">Restriction</h6>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <p class="card-text"><span class="text-muted">Featured:</span>
                                @if ($offer->is_featured == 1)
                                    <span class=" badge badge-dark" style="background-color: black">Enable</span>
                                @else
                                    <span class=" badge badge-light">Disable</span>
                                @endif
                            </p>

                            <p class="card-text"><span class="text-muted">Same IP Conversion:</span>
                                @if ($offer->same_ip_conversion == 1)
                                    <span class=" badge badge-dark" style="background-color: black">allow</span>
                                @else
                                    <span class=" badge badge-light">block</span>
                                @endif
                            </p>

                            <p class="card-text"><span class="text-muted">Conversion Approval:</span>
                                @if ($offer->conversion_approval == 1)
                                    <span class=" badge badge-dark" >auto</span>
                                @else
                                    <span class=" badge badge-light">manual</span>
                                @endif
                            </p>
                            <p class="card-text"><span class="text-muted">Min. Conversion Time:</span>
                                {{ $offer->min_conversion_time }} Seconds.
                            </p>
                            <p class="card-text"><span class="text-muted">Max. Conversion Time:</span>
                                {{ $offer->max_conversion_time }} Hours.
                            </p>
                            <p class="card-text"><span class="text-muted">Refer Redirect Rule</span>
                                @if ($offer->refer_rule == '302')
                                    302 with Refer
                                @elseif($offer->refer_rule == '302_hide')
                                    302 with Hide Refer
                                @else
                                    unknwon
                                @endif
                            </p>
                            <p class="card-text"><span class="text-muted">Redirect Offer:</span>
                                @if ($offer->redirect_offer_id != null)
                                    <a href="{{ route('employee.offer.show', $offer->redirect_offer_id) }}">(OfferID
                                        #{{ $offer->redirectOfferParent->id }})
                                        - {{ $offer->redirectOfferParent->name }}</a>
                                @else
                                    N/A
                                @endif
                            </p>
                            {{-- <p class="card-text"><span class="text-muted">Cutback:</span>
                                {{ $offer->cutback }}%
                            </p> --}}
                        </div>
                        <!-- /.card-body -->
                    </div>

        
                    
                    <!-- card start -->
                    <div class="card mb-4 shadow-lg border-left-dark">
                        <div class="card-header with-border">
                            <div class="row g-2 align-items-center">
                                <div class="col-sm-4">
                                    <h6 class="card-title mb-0 flex-grow-1 text-primary">Student Offer Click Limit</h6>
                                </div>                
                                <div class="col-sm-auto ms-auto">
                                    <div class="list-grid-nav hstack gap-1">                                        
                                        <a href="{{ route('employee.offer.clicklimit.create', $offer->id) }}" class="btn btn-primary btn-sm"><i class="ri-add-fill"></i> Add Click Limit</a>
                                    </div>                            
                                </div>                        
                            </div>
                        </div>
                        <div class="card-body">                            
                            <div class="table-responsive ">
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Student Name</th>
                                            <th>Click Limit</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($offer->clicklimit as $limit)
                                        @if ($limit->user->manager_id ==$manager_id)
                                            <tr>
                                                <td>{{ $limit->user->name }}</td>
                                                <td>{{ $limit->clicklimit }}</td>
                                                <td>
                                                    <a href="{{ route('employee.offer.clicklimit.edit', [$offer->id, $limit->id]) }}"
                                                        class=""><i class="ri-edit-line fs-16 text-info"></i></a>
                                                    <a href="javascript:void(0)" onclick="deleteClickLimit({{ $limit->id }})">
                                                        <i class="ri-delete-bin-line fs-16 text-danger"></i></a>
                                                </td>
                                            </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    
                    </div>
                    <!-- card ends -->
                    
                    <!-- card start -->
                    <div class="card mb-4 shadow-lg border-left-dark">
                        <div class="card-header with-border">
                            <div class="row g-2 align-items-center">
                                <div class="col-sm-4">
                                    <h6 class="card-title mb-0 flex-grow-1 text-primary">Student Offer Conversion Limit</h6>
                                </div>                
                                <div class="col-sm-auto ms-auto">
                                    <div class="list-grid-nav hstack gap-1">                                        
                                        <a href="{{ route('employee.offer.convlimit.create', $offer->id) }}" class="btn btn-primary btn-sm"><i class="ri-add-fill"></i> Add Conversion Limit</a>
                                    </div>                            
                                </div>                        
                            </div>
                            
                        </div>
                        <div class="card-body">                            
                            <div class="table-responsive ">
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Student Name</th>
                                            <th>Event Name</th>
                                            <th>Conversion Limit</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($offer->conversionlimit as $limit)
                                            @if ($limit->user->manager_id ==$manager_id)
                                            <tr>
                                                <td>{{ $limit->user->name }}</td>
                                                <td>{{ $limit->name }}</td>
                                                <td>{{ $limit->conversionlimit }}</td>
                                                <td>
                                                    <a href="{{ route('employee.offer.convlimit.edit', [$offer->id, $limit->id]) }}"
                                                        class=""><i class="ri-edit-line fs-16 text-info"></i></a>
                                                    <a href="javascript:void(0)" onclick="deleteConversionLimit({{ $limit->id }})">
                                                        <i class="ri-delete-bin-line fs-16 text-danger"></i></a>
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    
                    </div>
                    <!-- card ends -->
                    
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/libs/select2//select2.full.min.js') }}"></script>
    <!-- SweetAlert2-->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        function generateLink(offerId) {
            let userId = $('.student').val();
            if (offerId == null) {
                Swal.fire({
                    position: 'center',
                    type: 'error',
                    title: 'Oops...',
                    text: 'Please select any student to generate tracking link',
                    timer: 5000
                })
            } else {
                let link =
                    `{{ config('app.tracking_domain') ? config('app.tracking_domain') . '/' : asset('/') }}click?aid=${userId}&oid=${offerId}`;
                $('.trLink').val(link);
            }

        }

        $('.student').select2({
            ajax: {
                url: '{{ route('employee.getStudents') }}',
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
        function deleteStudent(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: `/employee/offer/delete/student/${id}`,
                        type: 'DELETE',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            location.reload();
                        },

                        error: function(data) {
                            Swal.fire(
                                'Error!',
                                'Your file has not been deleted.',
                                'error'
                            )
                        }
                    });
                }
            })
        }
    </script>
    
    <script>
        function deleteClickLimit(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: `/employee/offer/delete/clicklimit/${id}`,
                        type: 'DELETE',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            location.reload();
                        },

                        error: function(data) {
                            Swal.fire(
                                'Error!',
                                'Your clicklimit has not been deleted.',
                                'error'
                            )
                        }
                    });
                }
            })
        }
    </script>
    <script>
        function deleteConversionLimit(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: `/employee/offer/delete/convlimit/${id}`,
                        type: 'DELETE',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            location.reload();
                        },

                        error: function(data) {
                            Swal.fire(
                                'Error!',
                                'Your conversionlimit has not been deleted.',
                                'error'
                            )
                        }
                    });
                }
            })
        }
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
