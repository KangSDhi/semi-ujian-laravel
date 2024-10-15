<?php

namespace App\Http\Controllers\API\Tingkat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tingkat;
use Illuminate\Support\Facades\Validator;

class TingkatController extends Controller
{
    public function index(){
        $tingkat = Tingkat::all();

        return response()->json([
            "code"  => 200,
            "data"  => $tingkat
        ], 200);
    }

    public function create(Request $request){
        $rules = [
            "tingkat" => "required|unique:tingkat,nama_tingkat",
        ];

        $messages = [
            "tingkat.required" => "Tingkat tidak boleh kosong",
            "tingkat.unique" => "Tingkat sudah ada",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return response()->json([
                "code" => 400,
                "error_message" => $validator->errors()
            ], 400);
        }

        $tingkat = new Tingkat;
        $tingkat->nama_tingkat = $request->tingkat;
        $tingkat->save();

        return response()->json([
            "code" => 201,
            "message" => "Berhasil Membuat Tingkat Baru",
            "data" => $tingkat
        ], 201);
    }

    public function update(Request $request){

        $rules = [
            "tingkat" => "required|unique:tingkat,nama_tingkat,".$request->id,
        ];

        $messages = [
            "tingkat.required" => "Tingkat tidak boleh kosong",
            "tingkat.unique" => "Tingkat sudah ada",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return response()->json([
                "code" => 400,
                "error_message" => $validator->errors()
            ], 400);
        }

        $tingkat = Tingkat::find($request->id);
        $tingkat->nama_tingkat = $request->tingkat;
        $tingkat->save();

        return response()->json([
            "code" => 201,
            "message" => "Berhasil Merubah Tingkat",
            "data" => $tingkat
        ], 201);
    }

    public function destroy($id)
    {
        Tingkat::where('id', $id)->delete();

        return response()->json([
            "code" => 200,
            "message" => "Berhasil Menghapus Tingkat",
        ], 200);
    }
}
