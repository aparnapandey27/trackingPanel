@extends('admin.layout.app')

@section('content')
<div class="container-fluid py-4">
    <h6 class="mb-0">{{ __('Add Employee') }}</h6>
    <div class="card mt-4">
        <div class="card-header pb-0 px-3">
            <h6 class="mb-0">{{ __('Employee Information') }}</h6>
        </div>
        <div class="card-body pt-4 p-3">
            <form action="{{ route('admin.employees.store') }}" method="POST">
                @csrf
                <div class="row gx-4 gy-3">
                    <!-- Full Name and Email -->
                    <div class="col-lg-6 mb-3">
                        <div class="form-group">
                            <label for="name">
                                <i class="fas fa-user"></i> {{ __('Full Name') }}
                            </label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Full Name" required value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="form-group">
                            <label for="email">
                                <i class="fas fa-envelope"></i> {{ __('Email') }}
                            </label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email Address" required value="{{ old('email') }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Phone and Address -->
                    <div class="col-lg-6 mb-3">
                        <div class="form-group">
                            <label for="phone">
                                <i class="fas fa-phone"></i> {{ __('Phone') }}
                            </label>
                            <input type="text" id="phone" name="phone" class="form-control" placeholder="Phone Number" required value="{{ old('phone') }}">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="form-group">
                            <label for="address">
                                <i class="fas fa-map-marker-alt"></i> {{ __('Address') }}
                            </label>
                            <input type="text" id="address" name="address" class="form-control" placeholder="Address" required value="{{ old('address') }}">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>



                    <!-- Zip Code and Country -->
                    <div class="col-lg-6 mb-3">
                        <div class="form-group">
                            <label for="zipcode">
                                <i class="fas fa-mail-bulk"></i> {{ __('Zip Code') }}
                            </label>
                            <input type="text" id="zipcode" name="zipcode" class="form-control" placeholder="Zip Code" required value="{{ old('zipcode') }}">
                            @error('zipcode')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- <div class="row">
                        <div class="col-lg-6">
                            <div class=" form-group mb-3">
                                <label for="role">Role</label>
                                <select name="role" id="role" class=" form-select role">
                                    <option disabled selected>Choose...</option>
                                    <option value="admin">Super Admin</option>
                                    <option value="manager">Student Manager</option>
                                </select>
                            </div>
                        </div> --}}

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
                <div class="text-center mb-3">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-user-plus"></i> {{ __('Add Employee') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
