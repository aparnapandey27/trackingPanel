<?php

namespace App\Http\Controllers\Advertiser;

use App\Http\Controllers\Controller;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;


class AccountController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());
        return view('advertiser.account.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::id());
        $user->company = $request->company;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->zipcode = $request->zipcode;
        $user->update();

        Toastr::success('Account has been updated', 'Success');
        return redirect()->back();
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->old_password, $hashedPassword)) {
            if (!Hash::check($request->password, $hashedPassword)) {
                $user = User::find(Auth::id());
                $user->password = Hash::make($request->password);
                $user->save();
                Toastr::success('Password Successfully Changed', 'Success');
                // Auth::logout();
                return redirect()->back();
            } else {
                Toastr::error('New password cannot be the same as old password.', 'Error');
                return redirect()->back();
            }
        } else {
            Toastr::error('Old password do not match.', 'Error');
            return redirect()->back();
        }
    }

    public function updateProfilePhoto(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $image = $request->file('image');
    $user = User::find(auth()->user()->id);

    if (!$user) {
        Toastr::error('User not found', 'Error');
        return redirect()->back();
    }

    // Set the default image name to the existing user's image
    $imageName = $user->image;

    if ($image) {
        $currentDate = Carbon::now()->toDateString();
        $imageName = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
        
        if (!Storage::disk('public')->exists('users')) {
            Storage::disk('public')->makeDirectory('users');
        }

        if (Storage::disk('public')->exists('users/' . $user->image)) {
            Storage::disk('public')->delete('users/' . $user->image);
        }

        // Resize the image and save it
        $postImage = Image::make($image->getRealPath());
        $postImage->resize(100, 60, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        Storage::disk('public')->put('users/' . $imageName, (string) $postImage->stream());
    }

    $user->profile_photo = $imageName;
    $user->save();

    Toastr::success('Profile Picture uploaded', 'Success');
    return redirect()->back();
}



    public function security_token($id)
    {
        $advertiser = User::find($id);
        $advertiser->security_token = substr(md5(strtotime('now') . uniqid()) . rand(0000000000, 9999999999), rand(1, 5), 20);;
        $advertiser->update();

        Toastr::success('Security Token Updated Successful', 'Success');

        return redirect()->back();
    }
}
