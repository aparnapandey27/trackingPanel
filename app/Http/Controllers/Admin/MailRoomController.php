<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\Admin\MailRoom;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailRoomController extends Controller
{
    public function index()
    {
        // Fetch all users and pass them to the view
        $users = User::all();
        return view('admin.mailroom.index', compact('users'));
    }

    public function send(Request $request)
    {
        // Validate the request
        $request->validate([
            'to' => 'required|array',
            'mailer_subject' => 'required|string',
            'mailer_message' => 'required|string'
        ]);

        // Determine if the user selection is based on types or individual users
        $selectedUsers = [];
        if (in_array('-1', $request->get('to'))) {
            $user_type = $request->get('user');
            if ($user_type == 'student') {
                $selectedUsers = User::student()->active()->get();
            } elseif ($user_type == 'advertiser') {
                $selectedUsers = User::advertiser()->active()->get();
            }
        } else {
            $selectedUsers = User::whereIn('id', $request->to)->get();
        }

        // Send the email to the selected users
        foreach ($selectedUsers as $user) {
            Mail::to($user)
                ->send(new MailRoom($request->input('mailer_subject'), $request->input('mailer_message'), $user));
        }

        Toastr::success('Mail has been sent', 'Success');
        return redirect()->back();
    }
}
