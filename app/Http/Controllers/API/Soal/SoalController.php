<?php

namespace App\Http\Controllers\API\Soal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Soal;
use App\Models\Jurusan;
use App\Models\Tingkat;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use App\Rules\WaktuSelesaiRule;
use Carbon\Carbon;

class SoalController extends Controller
{
    public function getSoalByUser(){
        $getUser = auth('jwt')->user();
        $getToday = Carbon::now('Asia/Jakarta')->format("Y-m-d");

        $getSoal = DB::table(function($query) use ($getToday){
            $query->select(DB::raw('id, nama_soal, link, jurusan_id, tingkat_id, waktu_mulai, waktu_selesai'))
                ->from('soal')
                ->where('waktu_mulai', 'LIKE', $getToday.'%');
        })->where(function($query) use ($getUser){
            $query->where('tingkat_id', '=', $getUser->kelas->tingkat_id);
        })->where(function($query) use ($getUser){
            $query->whereNull('jurusan_id')
                ->orWhere('jurusan_id', '=', $getUser->kelas->jurusan_id);
        })
        ->orderBy('waktu_mulai', 'asc')
        ->get();

        return response()->json([
            "code"  => 200,
            "data"  => $getSoal
        ], 200);
    }

    public function getSoalJoinJurusanTingkat(){

        $soal = Cache::remember('soal', now()->addMinutes(15), function(){
            $dataSoal = Soal::leftJoin('jurusan', 'soal.jurusan_id', 'jurusan.id')
                ->join('tingkat', 'soal.tingkat_id', 'tingkat.id')
                ->select('soal.id', 'soal.nama_soal', 'soal.link', 'soal.waktu_mulai', 'soal.waktu_selesai', 'jurusan.nama_jurusan', 'tingkat.nama_tingkat')
                ->orderBy('tingkat.nama_tingkat', 'asc')
                ->orderBy('jurusan.nama_jurusan', 'asc')
                ->orderBy('soal.waktu_mulai', 'asc')
                ->get();
            
            return $dataSoal;
        });

        return response()->json([
            "code"  => 200,
            "data"  => $soal
        ], 200); 
    }

    

    public function create(Request $request){
        // dd(strtotime($request->waktu_selesai));
        $rules = [
            "nama_soal"     => "required",
            "link"          => "required",
            "nama_tingkat"  => "required",
            "waktu_mulai"   => "required|date",
            "waktu_selesai"  => ['required', 'date', new WaktuSelesaiRule()],
        ];

        $messages = [
            "nama_soal.required"    => "Mohon Isi Nama Soal!",
            "link.required"         => "Mohon Isi Link Soal!",
            "nama_tingkat.required" => "Mohon Isi Tingkat",
            "waktu_mulai.required"  => "Mohon Isi Waktu Mulai!",
            "waktu_selesai.required"  => "Mohon Isi Waktu Selesai!",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                "code" => 400,
                "error_message" => $validator->errors()
            ], 400);
        }

        $tingkat = Tingkat::where('nama_tingkat', $request->nama_tingkat)->first();

        if ($request->nama_jurusan != null) {
            $jurusan = Jurusan::where('nama_jurusan', $request->nama_jurusan)->first();
            $jurusan_id = $jurusan->id;
        } else {
            $jurusan_id = null;
        }

        $soal = new Soal();
        $soal->nama_soal = $request->nama_soal;
        $soal->jurusan_id = $jurusan_id;
        $soal->tingkat_id = $tingkat->id;
        $soal->link = $request->link;
        $soal->waktu_mulai = $request->waktu_mulai;
        $soal->waktu_selesai = $request->waktu_selesai;
        $soal->save();

        Cache::forget('soal');

        return response()->json([
            "code"  => 201,
            "message"   => "Berhasil Membuat Soal Baru"
        ], 201);

    }

    public function update(Request $request){
        $rules = [
            "id"            => "required",
            "nama_soal"     => "required",
            "nama_tingkat"  => "required",
            "link"          => "required",
            "waktu_mulai"   => "required",
            "waktu_selesai" => ['required', 'date', new WaktuSelesaiRule()],
        ];

        $messages = [
            "nama_soal.required"    => "Mohon Isi Nama Soal!",
            "nama_tingkat.required" => "Mohon Isi Tingkat Soal!",
            "link.required"         => "Mohon Isi Link Soal!",
            "waktu_mulai.required"  => "Mohon Isi Waktu Mulai!",
            "waktu_selesai.required"  => "Mohon Isi Waktu Selesai!",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);


        if ($validator->fails()) {
            return response()->json([
                "code"  => "400",
                "error_message" => $validator->errors()
            ], 400);
        }

        $tingkat = Tingkat::where('nama_tingkat', $request->nama_tingkat)->first();

        if ($request->nama_jurusan != null) {
            $jurusan = Jurusan::where('nama_jurusan', $request->nama_jurusan)->first();
            $jurusan_id = $jurusan->id;
        } else {
            $jurusan_id = null;
        }
        

        $soal = Soal::find($request->id);
        $soal->nama_soal = $request->nama_soal;
        $soal->jurusan_id = $jurusan_id;
        $soal->tingkat_id = $tingkat->id;
        $soal->link = $request->link;
        $soal->waktu_mulai = $request->waktu_mulai;
        $soal->waktu_selesai = $request->waktu_selesai;
        $soal->save();

        Cache::forget('soal');

        return response()->json([
            "code"  => 201,
            "message"   => "Berhasil Mengubah Data"
        ], 201);
    }

    public function destroy($id){
        Soal::where('id', $id)->delete();

        Cache::forget('soal');

        return response()->json([
            "code"  => 200,
            "message"   => "Berhasil Menghapus Soal"
        ], 200);
    }
}
