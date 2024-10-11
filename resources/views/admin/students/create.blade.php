@extends('admin.layout.app')

@section('content')
<div class="container-fluid py-4">
    <h6 class="mb-0">{{ __('Add Student') }}</h6>
    <div class="card mt-4">
        <div class="card-header pb-0 px-3">
            <h6 class="mb-0">{{ __('Student Information') }}</h6>
        </div>
        <div class="card-body pt-4 p-3">
            <!-- Corrected form tag -->
            <form action="{{ route('admin.students.store') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- College Name -->
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="college" class="form-label">{{ __('College Name') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-university"></i></span>
                                <input type="text" class="form-control" name="college" id="college" required placeholder="College Name" value="{{ old('college') }}">
                            </div>
                            @error('college')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Full Name -->
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="name" class="form-label">{{ __('Full Name') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" name="name" id="name" required placeholder="Full Name" value="{{ old('name') }}">
                            </div>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Email Address -->
                <div class="form-group mb-4">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" name="email" id="email" required placeholder="Email Address" value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <!-- Phone Number -->
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="text" class="form-control" name="phone" id="phone" required placeholder="Phone Number" value="{{ old('phone') }}">
                            </div>
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="address" class="form-label">{{ __('Address') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                <input type="text" class="form-control" name="address" id="address" required placeholder="Address" value="{{ old('address') }}">
                            </div>
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Zip Code -->
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="zipcode" class="form-label">{{ __('Zip Code') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-mail-bulk"></i></span>
                                <input type="text" class="form-control" name="zipcode" id="zipcode" required placeholder="Zip Code" value="{{ old('zipcode') }}">
                            </div>
                            @error('zipcode')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="status" class="form-label">{{ __('Status') }}</label>
                            <select name="status" class="form-select" required>
                                <option disabled @if(old('status') === null) selected @endif>{{ __('Choose...') }}</option>
                                <option value= 0 @if(old('status') === 0) selected @endif>{{ __('Pending') }}</option>
                                <option value=1 @if(old('status') === 1) selected @endif>{{ __('Active') }}</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button class="btn btn-primary btn-lg mt-4" type="submit">{{ __('Add Student') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
