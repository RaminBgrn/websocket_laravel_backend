<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function successResponse($statusCode, $data,  $message = "successfully")
    {
        return response()->json([
            'status' => $statusCode,
            'message' => $message,
            'data' => $data
        ],  $statusCode, ['Content-Type' => 'application/json'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    public function errorResponse($message, $statusCode)
    {
        return response()->json([
            "status" => $statusCode,
            "message" => $message
        ], $statusCode);
    }
}
