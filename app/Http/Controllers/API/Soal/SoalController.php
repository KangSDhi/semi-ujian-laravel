<?php

namespace App\Http\Controllers\API\Soal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        
    }
}
