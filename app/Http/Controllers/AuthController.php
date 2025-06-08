<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use function Laravel\Prompts\password;

class AuthController extends Controller
{
    //menampilkan Login form
    public function showLoginForm()
    {
        return Inertia::render('Auth/Login');
    }
    //Login Logic
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Debug 1: Cek apakah user berhasil diambil
            // $user = Auth::user();
            // if (!$user) {
            //     \Log::error('User not found after authentication');
            //     abort(500, 'Authentication error');
            // }

            // // Debug 2: Cek role
            // \Log::debug('Authenticated user role', [
            //     'id' => $user->id,
            //     'role' => $user->role
            // ]);

            return $this->redirectToRole(Auth::user()->role);
            // Atau alternatif:
            // return $this->redirectToRole($request->user()->role);
        }

        return back()->withErrors([
            'email' => 'Email or Password does not match',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }

    public function redirectToRole($role)
    {
        return match($role) {
            'admin' => redirect()->intended('admin/dashboard'),
            'editor' => redirect()->intended('editor/home'),
            'writer' => redirect()->intended('writer/home'),
            default => redirect()->intended('/')
        };
    }
}
