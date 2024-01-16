<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    public function send(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return $this->successResponse([],200,"Verification link sent!");
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return $this->successResponse([],200);
    }
}
