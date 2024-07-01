<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyAuthController extends Controller
{
    //
    public function login() {
        return view('layouts/login');
    }
    public function proc_login(Request $request) {
        $request->validate([
            'email' => ['required','email','exists:sys_users'],
            'password' => ['required']
        ], [
            'email.required' => 'Email khong duoc de trong',
            'email.email' => 'Phai o dang email',
            'email.exists' => 'Email chua duoc dang ky',
            'password.required' => 'Password khong duoc de trong',
        ]);
        $data = $request->only('email', 'password');
        $check = auth('my_sys')->attempt($data);
        if($check) {
            return redirect()->route('sys_user.home');
        }
        auth('my_sys')->logout();
        return redirect()->back();
    }
}
