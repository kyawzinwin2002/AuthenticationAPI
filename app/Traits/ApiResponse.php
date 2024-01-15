<?php

namespace App\Traits;

trait ApiResponse
{
    public function successResponse( $data , $statusCode = 200, $message="OK")
    {
        return $this->response([
            "status" => true,
            "message" => $message,
            "data" => $data
        ],$statusCode);
    }

    public function failResponse( $errors, $statusCode, $message="Something went wrong!" )
    {
        return $this->response([
            "status" => false,
            "message" => $message,
            "errors" => $errors
        ],$statusCode);
    }

    public function response( $data, $statusCode )
    {
        return response()->json($data,$statusCode);
    }
}
