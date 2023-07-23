<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestLoginController extends Controller
{
    public function guestLogin(Request $request)
    {
        $credentials = [
            'email' => 'welcome_guest@gmail.com',
            'password' => '1111111111',
        ];


        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->withErrors(['message' => 'ゲストログインに失敗しました。']);
        }
    }
}
