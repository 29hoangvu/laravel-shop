<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
            'role'     => 'required|in:users,staff',
        ]);

        $credentials = $request->only('email', 'password');
        $guard = $request->role === 'staff' ? 'staff' : 'web';

        if (Auth::guard($guard)->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended($guard === 'staff' ? '/staff/dashboard' : '/dashboard');
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không đúng.',
        ]);
    }
}
