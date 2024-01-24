<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index() {
        return Inertia::render(
            'Auth/Login'
        );
    }

    public function login (Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $authenticate = Auth::attempt(['email' => $request->email, 'password' => $request->password]);

        if(!$authenticate){
            return redirect('/auth/login')->with("message", ['text' => 'Email or password is wrong', 'type' => "error"]);
        }

        $user = Auth::user();

        return redirect('/')->with("message", ['text' => 'Login success', 'type' => "success"]);
    }

    public function logout (Request $request) {
        Auth::logout();

        return redirect('/auth/login');
    }
}
