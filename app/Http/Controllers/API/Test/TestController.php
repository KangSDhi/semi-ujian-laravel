<?php

namespace App\Http\Controllers\API\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(){
        return response()->json([
            "code" => 200,
            "message" => "Ok Gan"
        ], 200);
    }
}
