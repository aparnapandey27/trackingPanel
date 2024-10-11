<?php

namespace App\Http\Controllers\Employee\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\GeneralException;
use App\Models\User;

class LoginAsController extends Controller
{
    /**
     * Login to any other user account from admin panel
     * Created by Ruhul Ameen
     * Email: contact@ruhulameen.com / ruhulameen788@gmail.com
     */
    public function LoginAs(User $user, Request $request)
    {

        if (session()->has('admin_user_id') && session()->has('temp_user_id')) {

            if (Auth::id() == $user->id || session()->get('admin_user_id') == $user->id) {
                echo "Dont try to login yourself";
            }

            // Overwrite temp user ID.
            session(['temp_user_id' => $user->id]);

            Auth::loginUsingId($user->id);

            return redirect('login');
        }

        $this->flushTempSession();

        session(['admin_user_id' => Auth::id()]);
        session(['admin_user_name' => Auth::user()->name]);
        session(['temp_user_id' => $user->id]);

        Auth::loginUsingId($user->id);

        return redirect('login');
    }

    /**
     * Logout current connected user
     * and  back to admin again
     */
    public function LogoutAs()
    {


        if (session()->has('admin_user_id') && session()->has('temp_user_id')) {

            $admin_id = session()->get('admin_user_id');

            $this->flushTempSession();

            Auth::loginUsingId((int) $admin_id);

            return redirect('login');
        } else {
            $this->flushTempSession();
            Auth::logout();

            return redirect('/login');
        }
    }


    /**
     * Flush all seesion that we have created on the admin login scenario
     */
    private function flushTempSession()
    {
        session()->forget('admin_user_id');
        session()->forget('admin_user_name');
        session()->forget('temp_user_id');
    }
}
