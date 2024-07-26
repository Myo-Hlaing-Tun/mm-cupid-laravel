<?php

namespace App\Http\Controllers\auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginStoreRequest;

class AuthController extends Controller
{
    public function loginForm(){
        return view('test.login');
    }
    public function login(LoginStoreRequest $request){
        $credentials = Auth::guard('admin')->attempt([
            'username' => $request->get('username'),
            'password' => $request->get('password'),
            'deleted_at' => null
        ]);
        if($credentials){
            return redirect('student');
        }
        else{
            return redirect()->back();
        }
    }

    public function getLogout(){
        Auth::guard('admin')->logout();
        return redirect('login');
    }
}
