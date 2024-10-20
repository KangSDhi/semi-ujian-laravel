<?php

namespace App\Http\Controllers\API\Jurusan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Validator;

class JurusanController extends Controller
{
    public function index(){
        $jurusan = Jurusan::all();

        return response()->json([
            "code"  => 200,
            "data"  => $jurusan
        ], 200);
    }

    public function create(Request $request){
        $rules = [
            "nama_jurusan" => "required|unique:jurusan,nama_jurusan",
        ];

        $messages = [
            "nama_jurusan.required" => "Nama Jurusan harus diisi",
            "nama_jurusan.unique" => "Nama Jurusan sudah terdaftar",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return response()->json([
                "code" => 400,
                "error_message" => $validator->errors()
            ], 400);
        }

        $jurusan = new Jurusan;
        $jurusan->nama_jurusan = $request->nama_jurusan;
        $jurusan->save();

        return response()->json([
            "code" => 200,
            "message" => "Berhasil Membuat Jurusan Baru",
            "data" => $jurusan
        ], 201);
    }

    public function update(Request $request){
        $rules = [
            "nama_jurusan" => "required|unique:jurusan,nama_jurusan,".$request->id,
        ];

        $messages = [
            "nama_jurusan.required" => "Nama Jurusan harus diisi",
            "nama_jurusan.unique" => "Nama Jurusan sudah terdaftar",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return response()->json([
                "code" => 400,
                "error_message" => $validator->errors()
            ], 400);
        }

        $jurusan = Jurusan::find($request->id);
        $jurusan->nama_jurusan = $request->nama_jurusan;
        $jurusan->save();

        return response()->json([
            "code" => 201,
            "message" => "Berhasil Merubah Jurusan",
            "data" => $jurusan
        ], 201);
    }

    public function destroy($id){
        Jurusan::where('id', $id)->delete();

        return response()->json([
            "code" => 200,
            "message" => "Berhasil Menghapus Jurusan",
        ], 200);
    }
}
