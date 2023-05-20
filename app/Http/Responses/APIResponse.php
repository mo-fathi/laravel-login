<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Response;

class APIResponse extends Response
{

    public static function json($message = null, $errors = false , $data = null,$code = 200)
    {
        return response()->json(
            $data =
            [
                'message' => $message,
                'errors' => $errors,
                'data' => $data,
            ],
            $status = $code
            );
    }
}
