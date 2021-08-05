<?php

namespace App\Services;

class Response
{
    public function unprocessable ($validator)
    {
        $message = $validator->errors()->first();
        return response()->json(['message' => $message], 422);
    }

    public function ok ($payload)
    {
        return response()->json($payload, 200);
    }

    public function bad ($message)
    {
        return response()->json(['message' => $message], 400);
    }

    public function unauthorized($message)
    {
        return response()->json(['message' => $message], 401);
    }
}