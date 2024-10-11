<?php

namespace App\Http\Controllers\Employee\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
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
        return view('admin.account.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::id());
        $user->company = $request->company;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address1 = $request->address1;
        $user->address2 = $request->address2;
        $user->city = $request->city;
        $user->state = $request->state;
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
        $image = $request->file('image');
        $user = User::find(auth()->user()->id);

        if (isset($image)) {
            //make unipue name for image
            $currentDate = Carbon::now()->toDateString();
            $imageName  = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            if (!Storage::disk('public')->exists('users')) {
                Storage::disk('public')->makeDirectory('users');
            }

            //delete old post image
            if (Storage::disk('public')->exists('users/' . $user->image)) {
                Storage::disk('public')->delete('users/' . $user->image);
            }
            $postImage = Image::make($image)->resize(100, 80)->stream();
            Storage::disk('public')->put('users/' . $imageName, $postImage);
        } else {
            $imageName = "$user->image";
        }


        $user->profile_photo = $imageName;
        $user->save();
        Toastr::success('Profile Picture uploaded', 'Success');
        return redirect()->back();
    }
}
