<?php

namespace App\Http\Controllers\API\Chart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class SiswaChartController extends Controller
{
    public function chartSiswaTotalTingkatJurusan(){

        $data = User::join('kelas', 'users.kelas_id', 'kelas.id')
            ->join('tingkat', 'kelas.tingkat_id', 'tingkat.id')
            ->join('jurusan', 'kelas.jurusan_id', 'jurusan.id')
            ->select(DB::raw('count(*) as total, tingkat.nama_tingkat, jurusan.nama_jurusan'))
            ->where('users.role_id', 2)
            ->groupBy('jurusan.nama_jurusan', 'tingkat.nama_tingkat')
            ->orderBy('tingkat.nama_tingkat')
            ->orderBy('jurusan.nama_jurusan')
            ->get();

        return response()->json([
            "code"  => 200,
            "data"  => $data
        ], 200);
    }
}
