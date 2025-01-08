<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(){
        return view('login');
    }

    public function loginSubmit(Request $request){
        
        $request->validate([
            'text_username' => 'required|email',
            'text_password' => 'required|min:6|max:16',
        ]);

        //echo 'ok!';

        $username = $request->input('text_username');
        $password = $request->input('text_password');

        $user = User::where('username', $username)
                    ->where('deleted_at', NULL)
                    ->first();

        if(!$user || !password_verify($password, $user->password)){
            return redirect()
                ->back()
                ->withInput()
                ->with('loginError', 'Incorrect username or password');
        }

        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username
            ]
        ]);

        echo 'successful login';
    }

    public function logout(){
        session()->forget('user');

        return redirect()->to('/login');
    }
}
