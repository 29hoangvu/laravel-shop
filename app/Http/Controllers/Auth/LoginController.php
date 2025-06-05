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
            'password' => 'required|string',
            'role'     => 'required|in:user,staff',
        ]);

        $credentials = [
            'email'    => $request->email,    // khớp đúng cột DB
            'password' => $request->password, // khớp đúng cột DB
        ];


        $role = $request->role;

        if ($role === 'staff') {
            if (Auth::guard('staff')->attempt($credentials)) {
                // Đăng nhập thành công staff
                $request->session()->regenerate();
                session(['role' => 'staff']);
                return redirect()->intended('/staff/dashboard');
            }
        } elseif ($role === 'user') {
            if (Auth::guard('web')->attempt($credentials)) {
                // Đăng nhập thành công user
                $request->session()->regenerate();
                session(['role' => 'user']);
                return redirect()->intended('home');
            }
        }

        // Nếu không thành công
        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác hoặc vai trò không phù hợp.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        $role = session('role', 'web');
        Auth::guard($role)->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
