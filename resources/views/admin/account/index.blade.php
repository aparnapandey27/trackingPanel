@extends('admin.layout.app')
@section('title', 'Profile')

@section('content')
    
<div class="page-content">
	<div class="container-fluid">
		<div class="row">
            <div class="col-xxl-6">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Account Details</h4>
                        <div class="flex-shrink-0">
                            <div class="form-check form-switch form-switch-right form-switch-md">
                                <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#editAccount">Edit</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <p class="card-text">
                                    <span class="text-muted">Company:</span>
                                    @empty($user->company)
                                        ---
                                    @else
                                        {{ $user->company }}
                                    @endempty
                                </p>
                                <p class="card-text">
                                    <span class="text-muted">Name:</span>
                                    @if(empty($user->name))
                                        --
                                    @else
                                        {{ $user->name }}
                                    @endif
                                </p>
                                
                                <p class="card-text">
                                    <span class="text-muted">Email:</span>
                                    @empty($user->email)
                                        No email available
                                    @else
                                        {{ $user->email }}
                                    @endempty
                                </p>
                                
                                <p class="card-text">
                                    <span class="text-muted">Phone:</span>
                                    @empty($user->phone)
                                        No phone number provided
                                    @else
                                        {{ $user->phone }}
                                    @endempty
                                </p>
                                
                                
                                
                                <p class="card-text">
                                    <span class="text-muted">Address</span>
                                    @empty($user->address)
                                        No address provided
                                    @else
                                        {{ $user->address }}
                                    @endempty
                                </p>
                                
                                
                                <p class="card-text">
                                    <span class="text-muted">Country:</span>
                                    @empty($user->country)
                                        Country not specified
                                    @else
                                        {{ $user->country }}
                                    @endempty
                                </p>
                                
                                <p class="card-text">
                                    <span class="text-muted">ZIP:</span>
                                    @empty($user->zipcode)
                                        ZIP code not provided
                                    @else
                                        {{ $user->zipcode }}
                                    @endempty
                                </p>
                                
                                <p class="card-text">
                                    <span class="text-muted">Created:</span>
                                    @if ($user->created_at)
                                        {{ $user->created_at->format('d-F-Y - h:i A') }}
                                    @else
                                        Date not available
                                    @endif
                                </p>
                                
                                <p class="card-text">
                                    <span class="text-muted">Modified:</span>
                                    @if ($user->updated_at)
                                        {{ $user->updated_at->format('d-F-Y - h:i A') }}
                                    @else
                                        Not modified yet
                                    @endif
                                </p>
                                
                                <p class="card-text">
                                    <span class="text-muted">Last Login:</span>
                                    @if ($user->last_login_at)
                                        {{ $user->last_login_at->format('d-F-Y - h:i A') }}
                                    @else
                                        No login record available
                                    @endif
                                </p>
                                
                                <p class="card-text">
                                    <span class="text-muted">Signup IP:</span>
                                    @if ($user->signup_ip)
                                        {{ $user->signup_ip }}
                                    @else
                                        No signup IP recorded
                                    @endif
                                </p>
                                
                                
                            </div>
                            <div class="col-6 text-center"> 
                                @if ($user->profile_photo == null) 
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/450px-No_image_available.svg.png" class="img-fluid img-thumbnail izoom rounded-circle mb-4" width="150" style="max-width: 150px;max-height: 150px;min-width: 85px;min-height: 85px;"> 
                                @else
                                    <img src="{{ asset("storage/users/$user->profile_photo") }}" class="img-fluid img-thumbnail izoom rounded-circle mb-4" width="150" style="max-width: 150px;max-height: 150px;min-width: 85px;min-height: 85px;">
                                @endif
                                <br/>
                                <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#profile-photo">Change Picture</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card mb-4 shadow-lg border-left-dark">
                    <div class="card-header with-border">
                        <h6 class="m-0 text-primary font-weight-bold">Change Password</h6>

                    </div>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                    <div class="card-body">
                        <form action="{{ route('admin.account.password') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <input type="password" class="form-control" name="old_password"
                                    placeholder="Current Password">
                                @error('old_password')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" placeholder="New Password">
                                @error('password')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <input type="password" class="form-control" name="password_confirmation"
                                    placeholder="New Password Confirm">
                                @error('password_confirmation')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button class="btn btn-primary" type="submit">Update</button>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
        


    <div class="modal fade" id="editAccount">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Edit Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <hr>
                <form action="{{ route('admin.account.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class=" form-group mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="name" id="name" required
                                placeholder="Fullname" value="{{ $user->name }}">                            
                        </div>
                        <div class=" form-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control email" name="email" id="email" required
                                placeholder="Email Address" value="{{ $user->email }}">
                        </div>
                        <div class=" form-group mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control phone" name="phone" id="phone" required
                                placeholder="Phone Number" value="{{ $user->phone }}">
                        </div>
                        
                        <div class=" form-group mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control address" name="address" id="address" required
                                placeholder="Address 1" value="{{ $user->address }}">
                        </div>
                        
                        <div class=" form-group mb-3">
                            <label for="zip" class="form-label">Zip</label>
                            <input type="text" class="form-control zip" name="zipcode" id="zip" required placeholder="Zip"
                                value="{{ $user->zipcode }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Change</button>
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
            <form method="POST" action="{{ route('admin.account.profile-photo', $user->id) }}" class="form-horizontal"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Profile Picture</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div> 
                    <hr>                   
                    <div class="modal-body">
                        <div class="form-group mb-3 row">
                            <label class="col-sm-3">New Profile Picture</label>
                            <div class="col-sm-9 col-md-6">
                                <input type="file" class="form-control" name="image" accept="image/*">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Profile Photo Update Modal End-->
	</div>
	<!-- container-fluid -->
</div>
@endsection
@push('scripts')
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
