<?php

namespace App\Http\Controllers\API\Error;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function error401(){
        return response()->json([
            "code"  => 401,
            "error_message" => "Unauthorized"
        ], 401);
    }
}
