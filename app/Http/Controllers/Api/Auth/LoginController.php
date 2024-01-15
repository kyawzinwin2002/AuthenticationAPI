<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login( Request $request )
    {
        $validators = Validator::make($request->all(),[
            "email" => "required|exists:users,email",
            "password" => "required|min:8"
        ],["email.exists" => "Email or password is incorrect!"]);

        if( $validators->fails() ){
            return $this->failResponse(
                $validators->errors()
                ,403
            );
        }

        $user = User::where("email",$request->email)->first();

        if( !Auth::attempt($request->all()) ){
            return $this->failResponse(
                ["error" => "Email or password is incorrect"]
                ,403
            );
        }

        Auth::login($user);

        return $this->successResponse([
            "user" => $user,
            "token" => $user->createToken("ApiToken")->plainTextToken
        ],200,"Login Successfully");
    }
}
