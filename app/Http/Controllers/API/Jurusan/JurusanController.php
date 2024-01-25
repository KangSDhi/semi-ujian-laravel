<?php

namespace App\Http\Controllers\API\Jurusan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jurusan;

class JurusanController extends Controller
{
    public function index(){
        $jurusan = Jurusan::all();

        return response()->json([
            "code"  => 200,
            "data"  => $jurusan
        ], 200);
    }
}
