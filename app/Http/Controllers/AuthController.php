<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(){
        return view('login');
    }

    public function loginSubmit(Request $request){
        
        $request->validate([
            'text_username' => 'required',
            'text_password' => 'required',
        ]);

        echo 'ok!';
    }

    public function logout(){

    }
}
