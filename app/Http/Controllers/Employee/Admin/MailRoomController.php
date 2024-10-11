<?php

namespace App\Http\Controllers\Employee\Admin;

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
        return view('admin.mailroom.index');
    }

    public function send(Request $request)
    {
        //return $request->all();
        $request->validate([
            'to'      => 'required',
            'mailer_subject' => 'required'
        ]);
        if (in_array('-1', $request->get('to'))) {
            $user_type = $request->get('user');
            if ($user_type == 'student') {
                $users = User::student()->active()->get();
                foreach ($users as $user) {
                    Mail::to($user)
                        ->send(new MailRoom($request->input('mailer_subject'), $request->input('mailer_message'), $user));
                }
                Toastr::success('Mail has been sent', 'Success');
                return redirect()->back();
            }
            if ($user_type == 'advertiser') {
                $users = User::advertiser()->active()->get();
                foreach ($users as $user) {
                    Mail::to($user)
                        ->send(new MailRoom($request->input('mailer_subject'), $request->input('mailer_message'), $user));
                }
            }
            Toastr::success('Mail has been sent', 'Success');
            return redirect()->back();
        } else {
            $users = User::whereIn('id', $request->to)->get();
            foreach ($users as $user) {
                Mail::to($user)
                    ->send(new MailRoom($request->input('mailer_subject'), $request->input('mailer_message'), $user));
            }
            Toastr::success('Mail has been sent', 'Success');
            return redirect()->back();
        }
    }
}
