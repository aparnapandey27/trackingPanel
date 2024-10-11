<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Auth;


class AdminAdvertiserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::advertiser()->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function (User $user) {
                    $name = '<a title="' . $user->name . '" style="text-decoration:none" href="' . route('admin.advertiser.show', $user->id) . '">' . $user->name . '</a>';

                    return $name;
                })
                ->editColumn('status', function (User $user) {
                    if ($user->status == 1) {
                        $btn = '<span class="badge bg-success-subtle text-success text-uppercase">Active</span>';
                    } elseif ($user->status == 2) {
                        $btn = '<span class="badge bg-danger-subtle text-danger text-uppercase">Rejected</span>';
                    } elseif ($user->status == 3) {
                        $btn = '<span class="badge bg-danger-subtle text-danger text-uppercase">Closed</span>';
                    } else {
                        $btn = '<span class="badge bg-warning-subtle text-warning text-uppercase">Pending</span>';
                    }

                    return $btn;
                })


                ->editColumn('created_at', function (User $user) {
                    return $user->created_at->format('d-M-Y' . '  -  ' . 'h:i A');
                })

                ->addColumn('action', function (User $user) {

                    $btn = '<a href="javascript:void(0)" onclick="updateStatus(' . $user->id . ', 1)" class="btn btn-info btn-sm" title="approved this account"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="currentColor" fill-rule="evenodd" d="M3 13.5a.5.5 0 0 1-.5-.5V3a.5.5 0 0 1 .5-.5h9.25a.75.75 0 0 0 0-1.5H3a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V9.75a.75.75 0 0 0-1.5 0V13a.5.5 0 0 1-.5.5H3Zm12.78-8.82a.75.75 0 0 0-1.06-1.06L9.162 9.177L7.289 7.241a.75.75 0 1 0-1.078 1.043l2.403 2.484a.75.75 0 0 0 1.07.01L15.78 4.68Z" clip-rule="evenodd"/></svg></a>
                            <a href="javascript:void(0)" onclick="updateStatus(' . $user->id . ', 2)" class="btn btn-primary btn-sm" title="reject this account"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M6.793 6.793a1 1 0 0 1 1.414 0L12 10.586l3.793-3.793a1 1 0 1 1 1.414 1.414L13.414 12l3.793 3.793a1 1 0 0 1-1.414 1.414L12 13.414l-3.793 3.793a1 1 0 0 1-1.414-1.414L10.586 12L6.793 8.207a1 1 0 0 1 0-1.414Z" clip-rule="evenodd"/></svg></a>
                            <a href="javascript:void(0)" onclick="updateStatus(' . $user->id . ', 3)" class="btn btn-warning btn-sm" title="close this account"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2c5.5 0 10 4.5 10 10s-4.5 10-10 10S2 17.5 2 12S6.5 2 12 2m0 2c-1.9 0-3.6.6-4.9 1.7l11.2 11.2c1-1.4 1.7-3.1 1.7-4.9c0-4.4-3.6-8-8-8m4.9 14.3L5.7 7.1C4.6 8.4 4 10.1 4 12c0 4.4 3.6 8 8 8c1.9 0 3.6-.6 4.9-1.7Z"/></svg></a>
                            <a href="' . route('admin.advertiser.edit', $user->id) . '" title="Edit" class="btn btn-info btn-sm"title="approved this account"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m16.474 5.408l2.118 2.117m-.756-3.982L12.109 9.27a2.118 2.118 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621Z"/><path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3"/></g></svg></a>
                            <a href="javascript:void(0)" onclick="deleteAdvertiser(' . $user->id . ')" class="btn btn-danger btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.413-.588T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.588 1.413T17 21H7ZM17 6H7v13h10V6ZM9 17h2V8H9v9Zm4 0h2V8h-2v9ZM7 6v13V6Z"/></svg></a>
                            <a href="' . route('admin.loginAs', $user->id) . '" class="btn btn-info btn-sm" title="Sign in to this account"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M12 21v-2h7V5h-7V3h7q.825 0 1.413.588T21 5v14q0 .825-.588 1.413T19 21h-7Zm-2-4l-1.375-1.45l2.55-2.55H3v-2h8.175l-2.55-2.55L10 7l5 5l-5 5Z"/></svg></a>';
                    return $btn;
                })
                ->addColumn('checkbox', '<input type="checkbox" name="offer_checkbox[]" class="checkbox c-checkbox offer_checkbox" value="{{$id}}" />')
                ->rawColumns(['checkbox', 'action', 'status', 'name'])
                ->make(true);
        }
        return view('admin.advertisers.manage');
    }

    public function create()
    {
        return view('admin.advertisers.create');
    }

    public function store(Request $request)
    {

        try {
            // dd($request->all());
            $request->validate([
                'name' => 'required|string|max:255',
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|string|max:10',
                'address' => 'required|string|max:255',
                'zipcode' => 'sometimes|nullable|string|max:20',
                'status' => 'required|in:0,1',
            ]);

            User::create([
                'company_name' => $request->name,
                'name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'zipcode' => $request->zipcode,
                'password' => Hash::make('12345678'),
                'role' => 'advertiser',
                'status' => $request->status,
            ]);

            return redirect()->route('admin.advertisers.manage');
        } catch (\Exception $e) {
            Log::error('Error saving advertiser: ' . $e->getMessage());

            return redirect()->back()->with('error', 'There was an error adding the advertiser. Please try again.');
        }
    }

    public function manage()
{
    $advertisers = User::where('role', 'advertiser')->get();

    // Adding status badge HTML
    foreach ($advertisers as $advertiser) {
        if ($advertiser->status == 1) {
            $advertiser->status_badge = '<span class="badge bg-success-subtle text-success text-uppercase">Active</span>';
        } elseif ($advertiser->status == 2) {
            $advertiser->status_badge = '<span class="badge bg-danger-subtle text-danger text-uppercase">Rejected</span>';
        } elseif ($advertiser->status == 3) {
            $advertiser->status_badge = '<span class="badge bg-danger-subtle text-danger text-uppercase">Closed</span>';
        } else {
            $advertiser->status_badge = '<span class="badge bg-warning-subtle text-warning text-uppercase">Pending</span>';
        }
    }

    return view('admin.advertisers.manage', compact('advertisers'));
}


    public function confirm($id)
{
    try {
        $advertiser = User::findOrFail($id);
        $advertiser->status = 1;
        $advertiser->save();

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        Log::error('Error confirming advertiser: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Something went wrong. Please try again.'], 500);
    }
}

    public function disable($id)
{
    try {
        $advertiser = User::findOrFail($id);
        $advertiser->status = 0;
        $advertiser->save();

        return redirect()->route('advertisers.index');
    } catch (\Exception $e) {
        Log::error('Error disabling advertiser ID ' . $id . ': ' . $e->getMessage());
        return redirect()->back()->with('error', 'Something went wrong. Please try again.');
    }
}

    public function reject($id)
{
    try {
        $advertiser = User::findOrFail($id);
        $advertiser->status = 0;
        $advertiser->save();

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        Log::error('Error rejecting advertiser ID ' . $id . ': ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Something went wrong. Please try again.'], 500);
    }
}

    public function edit($id)
    {
        $advertiser = User::findOrFail($id);
        return view('admin.advertisers.edit', compact('advertiser'));
    }

    public function destroy($id)
{
    try {
        $advertiser = User::findOrFail($id);
        $advertiser->delete();
        // Session::flash('success', 'advertiser deleted successfully.');
        return redirect()->route('admin.advertisers.manage');
    } catch (\Exception $e) {
        Log::error('Error deleting advertiser: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Something went wrong. Please try again.');
    }
}


    public function update(Request $request, $id)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:100',
            'status' => 'required|string|in:0,1',
        ]);

        $advertiser = User::findOrFail($id);
        $advertiser->company_name = $request->company_name;
        $advertiser->name = $request->name;
        $advertiser->email = $request->email;
        $advertiser->phone = $request->phone;
        $advertiser->address = $request->address;
        $advertiser->status = $request->status;
        $advertiser->save();

        return redirect()->route('admin.advertisers.manage');
    }

    // public function show($id)
    // {
    //     $advertiser = User::findOrFail($id);
    //     return view('admin.advertisers.show', compact('advertiser'));
    // }

    public function showRegistrationForm()
    {
        return view('auth.advertiserRegister');
    }

    public function register(Request $request)
    {
        $request->validate([
            'company' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|integer|max:12',
            'email' => 'required|string|email|max:255|unique:users',
            'address' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'status' => 'required|in:0,1',
        ]);

        $advertiser = User::create([
            'company_name' => $request->company,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'status' => $request->status,
        ]);

        auth()->login($advertiser);

        return redirect()->route('admin.dashboard');
    }

    // public function loginAs(Request $request, $id)
    // {
    //     $advertiser = User::findOrFail($id);

    //     Auth::login($advertiser);

    //     return redirect()->route('dashboard')->with('success', 'Logged in as ' . $advertiser->name);
    // }

//     public function login(Request $request)
// {
//     $credentials = $request->only('email', 'password');

//     if (Auth::guard('advertiser')->attempt($credentials)) {
//         // Authentication passed...
//         return redirect()->intended('dashboard');
//     }

//     return back()->withErrors([
//         'email' => 'The provided credentials do not match our records.',
//     ]);
// }


}
