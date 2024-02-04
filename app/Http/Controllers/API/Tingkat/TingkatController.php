<?php

namespace App\Http\Controllers\API\Tingkat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tingkat;

class TingkatController extends Controller
{
    public function index(){
        $tingkat = Tingkat::all();

        return response()->json([
            "code"  => 200,
            "data"  => $tingkat
        ], 200);
    }
}
