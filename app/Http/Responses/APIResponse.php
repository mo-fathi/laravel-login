<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Response;

class APIResponse extends Response
{

    public static function json($message = null, $errors = false , $data = null)
    {
        return response()->json(
            [
                'message' => $message,
                'errors' => $errors,
                'data' => $data,
            ]
            );
    }
}
