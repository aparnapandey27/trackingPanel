@extends('advertiser.layout.app')
@section('title', 'Account')
@push('style')
<link rel="stylesheet" href="{{asset('assets/libs/toastr/toastr.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/libs/icomoon/style.css') }}">
@endpush
@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-lg-6">
            <div class="card mb-4 shadow-lg border-left-dark">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h6 class="m-0 text-primary font-weight-bold">Account Details</h6>
                        <button class=" btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#editAccount">Edit</button>
                     
                    </div>
                </div>
                <div class="card-body">
                 <div class="image-section">
                    <span class="float-right">
                        @if ($user->profile_photo == null)
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/450px-No_image_available.svg.png" class="img-fluid img-thumbnail izoom rounded-circle"
                                width="150" style="max-width: 150px;max-height: 150px;min-width: 85px;min-height: 85px;">
                        @else
                            <img src="{{ asset("storage/users/$user->profile_photo") }}"
                                class="img-fluid img-thumbnail izoom rounded-circle" width="150"
                                style="max-width: 150px;max-height: 150px;min-width: 85px;min-height: 85px;">
                        @endif
                        <br />
                        <button type="button" class="btn rounded-pill  btn btn-sm btn-primary waves-effect waves-light"  data-bs-toggle="modal"
                        data-bs-target="#profile-photo">Change Picture</button>
                       
                    </span>
                 </div>
            <div class="text-section">
                <p class="card-text"><span class="text-muted">Company:</span> @if(empty($user->company)) Not specified @else {{ $user->company }} @endif</p>
                <p class="card-text"><span class="text-muted">Name:</span> @if(empty($user->name)) Not specified @else {{ $user->name }} @endif</p>
                <p class="card-text"><span class="text-muted">Email:</span> @if(empty($user->email)) Not specified @else {{ $user->email }} @endif</p>
                <p class="card-text"><span class="text-muted">Phone:</span> @if(empty($user->phone)) Not specified @else {{ $user->phone }} @endif</p>
                <p class="card-text"><span class="text-muted">Address:</span> @if(empty($user->address)) Not specified @else {{ $user->address }} @endif</p>
                <p class="card-text"><span class="text-muted">Country:</span> @if(empty($user->country)) Not specified @else {{ $user->country }} @endif</p>
                <p class="card-text"><span class="text-muted">ZIP:</span> @if(empty($user->zipcode)) Not specified @else {{ $user->zipcode }} @endif</p>
                
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
                            {{ $user->last_login_at->format('d-F-Y - h:i A') }}
                        @else
                            Not available
                        @endif
                    </p>
                    
                    <p class="card-text"><span class="text-muted">Signup IP:</span>
                        @if(empty($user->signup_ip))
                            Not available
                        @else
                            {{ $user->signup_ip }}
                        @endif
                    </p>
                    
                </div>
            </div>
        </div>

</div>

        <div class="col-lg-6">
            <div class="card mb-4 shadow-lg border-left-dark">
                <div class="card-header with-border">
                    <h6 class="m-0 text-primary font-weight-bold">Change Password</h6>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('advertiser.account.password') }}" method="POST">
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
                        <button class=" btn btn-sm btn-primary" type="submit">Update</button>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <div class="card mb-4 shadow-lg border-left-dark">
                <div class="card-header">
                    <h6 class="m-0 font-wieght-bold text-primary">Security Token</h6>
                </div> 
                <!-- /.card-header -->
                <div class="card-body">
                    <p class="card-text"><span class="text-muted">Postback Security Token:</span>
                        @if ($user->security_token)
                            {{ $user->security_token }}
                            <br />
                            <br />
                            <a href="{{ route('advertiser.account.security.token.generate', $user->id) }}"
                                class="btn btn-sm btn-primary">Re Generate</a>
                        @else
                            <span class="badge bg-danger-subtle text-danger text-uppercase">Not Set</span>
                            <br />
                            <br />
                            <a href="{{ route('advertiser.account.security.token.generate', $user->id) }}"
                                class="btn btn-sm btn-primary">Generate</a>
                        @endif
                    </p>
                </div>
                <!-- /.card-body -->
            </div>
            <div class="card mb-4 shadow-lg border-left-dark">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-priamry">Global Postback/Pixels</h6>
                </div>
                <div class="card-body">
                    <div class="form-group mx-4">
                        <label class="text-muted">Generated Postback / Tracking Pixel</label>
                        <textarea class="form-control" name="postback_url" id="postback_url"
                            rows="3">{{ asset('/') }}track/?click_id=CLICK_ID{{ $user->security_token != null ? '&token=' . $user->security_token : '' }}</textarea>
                        <small class="help-block">Postback / Tracking Pixel is a pixel that is fired when the click
                            convertion in lead/sale on the offer. This is a great way to track conversions and
                            revenue. This must be placed in advertiser end</small>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editAccount">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('advertiser.account.update') }}" method="POST">
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

    <!--Profile Photo Update Modal Start-->
    <div class="modal fade" id="profile-photo" tabindex="-1" role="dialog" aria-labelledby="profilePhotoLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="{{ route('advertiser.account.profile-photo', $user->id) }}"
                class="form-horizontal" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Profile Picture</h5>
                        <button class="btn btn-light" type="button"  data-bs-dismiss="modal" aria-label="Close">
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
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
    <!--Profile Photo Update Modal End-->
@endsection
@push('scripts')

<script src="https://partners.streakads.com/assets/libs/toastr/toastr.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function addAdvertiser() {
            var name = $('.name').val();
            var email = $('.email').val();
            var status = $('.status').val();
            let _url = `/admin/advertiser/store`;
            let _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: _url,
                type: "POST",
                data: {
                    name: name,
                    email: email,
                    status: status,
                    // _token: _token
                },

                success: function(data) {
                    console.log(data);
                    $('.name').val('');
                    $('.email').val('');
                    $('#advertisers').DataTable().ajax.reload();
                    $('#addAdv').modal('hide');
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Advertiser has been Added',
                        showConfirmButton: false,
                        timer: 2000
                    })
                },
                error: function(data) {
                    console.log(data);
                }
            })
        }
    </script>
@endpush
