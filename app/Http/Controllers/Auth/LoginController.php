<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $rfidData = $request->input('rfid');
        $user = User::where('rfid', $rfidData)->first();

        if ($user) {
            Auth::login($user);
            return response()->json(['success' => true, 'redirect' => route('dashboard')]);
        } else {
            return response()->json(['success' => false, 'message' => 'RFID tidak dikenal']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }

    /**
     * Handle the user after they are authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->route('dashboard');
    }
}
