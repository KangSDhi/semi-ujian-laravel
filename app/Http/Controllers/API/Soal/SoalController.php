<?php

namespace App\Http\Controllers\API\Soal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Soal;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Validator;

class SoalController extends Controller
{
    public function getSoalByUser(){
        $getUser = auth('jwt')->user();
        $getToday = date("Y-m-d");

        $getSoal = DB::table(function($query) use ($getToday){
            $query->select(DB::raw('id, nama_soal, link, jurusan_id, waktu_mulai'))
                ->from('soal')
                ->where('waktu_mulai', 'LIKE', $getToday.'%');
        })->where(function($query) use ($getUser){
            $query->whereNull('jurusan_id')
                ->orWhere('jurusan_id', '=', $getUser->jurusan_id);
        })
        ->orderBy('waktu_mulai', 'asc')
        ->get();

        return response()->json([
            "code"  => 200,
            "data"  => $getSoal
        ], 200);
    }

    public function getSoalJoinJurusan(){
        $getSoal = Soal::leftJoin('jurusan', 'soal.jurusan_id', 'jurusan.id')
            ->select(DB::raw('soal.id, soal.nama_soal, soal.link, soal.waktu_mulai, jurusan.nama as nama_jurusan'))
            ->get();
        
        return response()->json([
            "code"  => 200,
            "data"  => $getSoal
        ], 200); 
    }

    public function create(Request $request){
        $rules = [
            "nama_soal"     => "required",
            "link"          => "required",
            "waktu_mulai"   => "required"
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                "code" => 400,
                "error_message" => $validator->errors()
            ], 400);
        }

        if ($request->nama_jurusan != null) {
            $jurusan = Jurusan::where('nama', $request->nama_jurusan)->first();
            $jurusan_id = $jurusan->id;
        } else {
            $jurusan_id = null;
        }

        $soal = new Soal();
        $soal->nama_soal = $request->nama_soal;
        $soal->jurusan_id = $jurusan_id;
        $soal->link = $request->link;
        $soal->waktu_mulai = $request->waktu_mulai;
        $soal->save();

        return response()->json([
            "code"  => 201,
            "message"   => "Berhasil Membuat Soal Baru"
        ], 201);

    }

    public function update(Request $request){
        $rules = [
            "id"            => "required",
            "nama_soal"     => "required",
            "link"          => "required",
            "waktu_mulai"   => "required"
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                "code"  => "400",
                "error_message" => $validator->errors()
            ], 400);
        }

        if ($request->nama_jurusan != null) {
            $jurusan = Jurusan::where('nama', $request->nama_jurusan)->first();
            $jurusan_id = $jurusan->id;
        } else {
            $jurusan_id = null;
        }
        

        $soal = Soal::find($request->id);
        $soal->nama_soal = $request->nama_soal;
        $soal->jurusan_id = $jurusan_id;
        $soal->link = $request->link;
        $soal->waktu_mulai = $request->waktu_mulai;
        $soal->save();

        return response()->json([
            "code"  => 201,
            "message"   => "Berhasil Mengubah Data"
        ], 201);
    }

    public function destroy($id){
        Soal::where('id', $id)->delete();

        return response()->json([
            "code"  => 200,
            "message"   => "Berhasil Menghapus Soal"
        ], 200);
    }
}
