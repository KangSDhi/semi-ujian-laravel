<?php

namespace App\Http\Controllers\API\Kelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    public function index(){
        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();

        return response()->json([
            "code"  => 200,
            "data"  => $kelas
        ], 200);
    }

    public function getKelasByJoinTingkatAndJurusan(){
        $kelas = Kelas::join('tingkat', 'kelas.tingkat_id', '=', 'tingkat.id')
            ->join('jurusan', 'kelas.jurusan_id', '=', 'jurusan.id')
            ->select('kelas.id', 'kelas.nama_kelas', 'kelas.tingkat_id', 'tingkat.nama_tingkat', 'kelas.jurusan_id', 'jurusan.nama_jurusan')
            ->orderBy('kelas.nama_kelas', 'asc')
            ->get();
        return response()->json([
            "code"  => 200,
            "data"  => $kelas
        ], 200);
    }

    public function create(Request $request){
        $rules = [
            'nama_kelas' => 'required|unique:kelas,nama_kelas',
            'tingkat_id' => 'required',
            'jurusan_id' => 'required',
        ];

        $messages = [
            'nama_kelas.required' => 'Nama Kelas harus diisi',
            'tingkat_id.required' => 'Tingkat harus diisi',
            'jurusan_id.required' => 'Jurusan harus diisi',
            'nama_kelas.unique' => 'Nama Kelas sudah terdaftar',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return response()->json([
                "code" => 400,
                "error_message" => $validator->errors()
            ], 400);
        }

        $kelas = new Kelas;
        $kelas->tingkat_id = $request->tingkat_id;
        $kelas->jurusan_id = $request->jurusan_id;
        $kelas->nama_kelas = $request->nama_kelas;
        $kelas->save();

        return response()->json([
            "code" => 201,
            "message" => "Berhasil Membuat Kelas Baru",
            "data" => $kelas
        ], 201);
    }

    public function update(Request $request)
    {
        $rules = [
            'nama_kelas' => 'required|unique:kelas,nama_kelas,'.$request->id,
            'tingkat_id' => 'required',
            'jurusan_id' => 'required',
        ];

        $messages = [
            'nama_kelas.required' => 'Nama Kelas harus diisi',
            'tingkat_id.required' => 'Tingkat harus diisi',
            'jurusan_id.required' => 'Jurusan harus diisi',
            'nama_kelas.unique' => 'Nama Kelas sudah terdaftar',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return response()->json([
                "code" => 400,
                "error_message" => $validator->errors()
            ], 400);
        }

        $kelas = Kelas::find($request->id);
        $kelas->nama_kelas = $request->nama_kelas;
        $kelas->tingkat_id = $request->tingkat_id;
        $kelas->jurusan_id = $request->jurusan_id;
        $kelas->save();

        return response()->json([
            "code" => 201,
            "message" => "Berhasil Merubah Kelas",
            "data" => $kelas
        ], 201);
    }

    public function destroy($id)
    {
        Kelas::where('id', $id)->delete();

        return response()->json([
            "code" => 200,
            "message" => "Berhasil Menghapus Kelas",
        ], 200);
    }
}
