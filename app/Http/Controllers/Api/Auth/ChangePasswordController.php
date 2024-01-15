<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{
    public function change(Request $request)
    {
        $validators = Validator::make($request->all(),[
            "oldPassword" => "required|min:8",
            "password" => "required|min:8|confirmed"
        ]);

        if($validators->fails()){
            return $this->failResponse([
                $validators->errors()
            ],401);
        }

        if(!Hash::check($request->oldPassword, Auth::user()->password)){
            return $this->failResponse([
                "error" => "Password is incorrect"
            ],401);
        }

        $user = User::find(Auth::id());
        $user->password = Hash::make($request->password);
        $user->update();

        return $this->successResponse([],200,"Changed Password Successfully.");
    }
}
