<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validators = Validator::make($request->all(),[
            "name" => "required|string|min:3",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:8|confirmed"
        ]);

        if( $validators->fails() ){
            return $this->failResponse([
                $validators->errors()
            ],403);
        }

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        return $this->successResponse([
            "user" => $user,
            "token" => $user->createToken("ApiToken")->plainTextToken
        ],200,"Registered Successfully");
    }
}
