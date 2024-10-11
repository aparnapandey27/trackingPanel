@extends('student.layout.app')
@section('title', 'Account')
@push('style')
    {{-- <link rel="stylesheet" href="{{ asset('assets/libs/icomoon/style.css') }}"> --}}
@endpush

@section('content')
<div class="page-content">
    <div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="card mb-4 shadow-lg">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h6 class="m-0 text-primay font-weight-bold">Account Details</h6>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editAccount">
                            <i class="fa fa-user"></i> Edit
                        </button>
                    </div>

                </div>
                <div class="card-body">
    <div class="row">
        <div class="col-md-8 text-right">
            <p class="card-text"><span class="text-muted">College:</span> {{ $user->college }} </p>
            <p class="card-text"><span class="text-muted">Name:</span> {{ $user->name }} </p>
            <p class="card-text"><span class="text-muted">Email:</span> {{ $user->email }}</p>
            <p class="card-text"><span class="text-muted">Phone:</span> {{ $user->phone }}</p>
            <p class="card-text"><span class="text-muted">Address:</span> {{ $user->address }}</p>
            <p class="card-text"><span class="text-muted">Country:</span> {{ $user->country }}</p>
            <p class="card-text"><span class="text-muted">ZIP:</span> {{ $user->zipcode }}</p>
            <p class="card-text"><span class="text-muted">Created:</span>
                @if ($user->created_at != null)
                    {{ $user->created_at->format('d-F-Y' . '  -  ' . 'h:i A') }}
                @endif
            </p>
            <p class="card-text"><span class="text-muted">Modified:</span>
                @if ($user->updated_at != null)
                    {{ $user->updated_at->format('d-F-Y' . '  -  ' . 'h:i A') }}
                @endif
            </p>
            <p class="card-text"><span class="text-muted">Last Login:</span>
                @if ($user->last_login_at != null)
                    {{ $user->last_login_at->format('d-F-Y' . '  -  ' . 'h:i A') }}
                @endif
            </p>
            <p class="card-text"><span class="text-muted">Signup IP:</span>
                {{ $user->signup_ip }}
            </p>
        </div>
        <div class="col-md-4">
            @if (is_null($user->profile_photo))
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/450px-No_image_available.svg.png" class="img-fluid img-thumbnail izoom rounded-circle"
                    width="150" style="max-width: 150px; max-height: 150px; min-width: 85px; min-height: 85px;">
            @else
                <img src="{{ asset("storage/users/$user->profile_photo") }}"
                    class="img-fluid img-thumbnail izoom rounded-circle" width="150"
                    style="max-width: 150px; max-height: 150px; min-width: 85px; min-height: 85px;">
            @endif
            <br />
            <button type="button" class="btn rounded-pill btn btn-sm btn-primary waves-effect waves-light"
                data-bs-toggle="modal" data-bs-target="#profile-photo">Change Picture</button>
        </div>
        
    </div>
</div>

            </div>

            <div class="card mb-4 shadow-lg">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h6 class="m-0 text-primay font-weight-bold">Payment Profile</h6>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editPayment">
                            <i class="fas fa-money-bill"></i> Edit
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <p class="card-text"><span class="text-muted">Payment Frequency: <br></span>
                        {{ auth()->user()->payment_frequency }}
                    </p>
                    <p class="card-text"><span class="text-muted">Payment Method: <br></span>
                        @if (auth()->user()->payment_method != null)
                            {{ auth()->user()->payment_method->payment_option->name }}
                            ({{ auth()->user()->payment_method->details }})
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card mb-4 shadow-lg border-left-dark">
                <div class="card-header with-border">
                    <h6 class="m-0 text-primay font-weight-bold">Change Password</h6>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('student.account.password') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                        <div class="col-lg-12">
                            <input type="password" class="form-control" name="old_password"
                                placeholder="Current Password">
                                </div>
                            @error('old_password')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row mb-3">
                          <div class="col-lg-12">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" placeholder="New Password">
                                </div>
                            @error('password')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row mb-3">
                          <div class="col-lg-12">
                            <input type="password" class="form-control" name="password_confirmation"
                                placeholder="New Password Confirm">
                            </div>
                            @error('password_confirmation')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-key"></i> Change Password
                        </button>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>


    <!-- User Profile Edit Modal -->
    <div class="modal fade" id="editAccount">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('student.account.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class=" form-group">
                            <label for="name">Fullname</label>
                            <input type="text" class="form-control name" name="name" id="name" required
                                placeholder="Fullname" value="{{ $user->name }}">
                        </div>
                        <div class=" form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control email" name="email" id="email" required
                                placeholder="Email Address" value="{{ $user->email }}">
                        </div>
                        <div class=" form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control phone" name="phone" id="phone" required
                                placeholder="Phone Number" value="{{ $user->phone }}">
                        </div>
                       
                        <div class=" form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control address" name="address" id="address" required
                                placeholder="Address 1" value="{{ $user->address }}">
                        </div>
                        
                        <div class=" form-group">
                            <label for="zip">Zip</label>
                            <input type="text" class="form-control zip" name="zipcode" id="zip" required placeholder="Zip"
                                value="{{ $user->zipcode }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save Change</button>
                    </div>
                </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!--Payment Profile Edit Modal-->
    <div class="modal fade" id="editPayment">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Payment Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('student.payment.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="option">Payment Method</label>
                            <select name="payment_method" id="option" class="form-control">
                                @foreach ($payment_options as $option)
                                    <option value="{{ $option->id }}"
                                        @if (auth()->user()->payment_method != null) @if (auth()->user()->payment_method->payment_option->name == $option->name)
                                            selected @endif
                                        @endif>
                                        {{ $option->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="detail">Details</label>
                            <textarea name="detail" id="detail" cols="30" rows="8"
                                class="form-control">{{ auth()->user()->payment_method != null ? auth()->user()->payment_method->details : '' }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Change</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!--Profile Photo Update Modal Start-->
    <div class="modal fade" id="profile-photo" tabindex="-1" role="dialog" aria-labelledby="profilePhotoLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="{{ route('student.account.profile-photo', $user->id) }}"
                class="form-horizontal" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Profile Picture</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">New Profile Picture</label>
                            <div class="col-sm-9 col-md-6">


                                <input type="file" class="form-control" name="image" accept="image/*">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
   </div>
</div>
    <!--Profile Photo Update Modal End-->
@endsection
@push('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        // jQuery div hide show on select offer_model
        $(document).ready(function() {
            $('#payment_method').on('change', function() {
                if (this.value == 'Wise') {
                    $('#wise').show();
                    $('#payoneer, #skrill, #webmoney, #paypal').hide();
                } else if (this.value == 'Payoneer') {
                    $('#payoneer').show();
                    $('#paypal, #skrill, #webmoney, #wise').hide();
                } else if (this.value == 'Skrill') {
                    $('#skrill').show();
                    $('#paypal, #payoneer, #webmoney, #wise').hide();
                } else if (this.value == 'WebMoney') {
                    $('#webmoney').show();
                    $('#paypal, #skrill, #payoneer, #wise').hide();
                } else {
                    $('#paypal').show();
                    $('#payoneer, #skrill, #webmoney, #wise').hide();
                }
            });
        });
    </script>
@endpush
