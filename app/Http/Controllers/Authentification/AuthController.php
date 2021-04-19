<?php

namespace App\Http\Controllers\Authentification;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    function login (Request $request) {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
        if (!auth()->attempt($loginData)) {
            return response(['error'=> 'Mail ou mot de passe incorrect']);
        }
        return auth()->user()->createToken('AuthToken');
    }


    function register (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email:rfc',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors()->messages();
        }

        $fields = $request->request->all();



        if (User::where('email', $fields['email'])->first()){
            return response([
                'status' => 'error',
                'error' => 'An user with same email already exist'
            ], 400);

        }


        $fields['password'] = Hash::make($fields['password']);

        $fields['roles'] = ['USER'];
        $user = User::create($fields);


        return response(['status' => 'created', 'token' => $user->createToken('AuthToken'), $user]);
    }
}
