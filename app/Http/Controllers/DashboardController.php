<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{

    public function login(Request $request)
    {
        return view('backend.login');
    }
    public function entry(Request $request)
    {
        $user = User::where('username', $request->data)->orWhere('email', $request->data)->first();
        if (isset($user)) {
            if (Hash::check($request->password, $user->password)) {
                $data = $request->session()->put('loginId', $user->id);
                return redirect()->route('dashboard');
            } else {
                return back()
                    ->with('incorrect-password', 'Your Password is Invelid!');
            }
        } else {
            return back()
                ->with('fail', 'This Account is not Created!');
        }
    }

    public function exit()
    {
        if (Session::has('loginId')) {
            Session::pull('loginId');
            return redirect()->route('login');
        }
    }

    public function dashboard()
    {
        $users = User::all();
        return view('backend.dashboard')
        ->with('users', $users);
    }
}
