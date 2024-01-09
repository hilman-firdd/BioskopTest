<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($data)
    {
    	$response = [
            'kode' => 0,
            'info' => "OK",
            'data'    => $data,
        ];
        return response()->json($response, 200);
    }

    public function sendError($message, $code = 404)
    {
    	$response = [
            'kode' => 1,
            'info' => "ERROR",
            'data'    => [
                'message' => $message,
            ],
        ];
        return response()->json($response, $code);
    }
}
