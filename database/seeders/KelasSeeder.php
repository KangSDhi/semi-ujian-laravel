<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $getJurusan = DB::table('jurusan')->get();

        $getTingkat = DB::table('tingkat')->get();

        $jurusan = "";

        // dd(count($getJurusan));
        for ($i=0; $i < count($getJurusan) ; $i++) { 
            // echo $getJurusan[$i]->nama_jurusan."\n";
            if ($getJurusan[$i]->nama_jurusan == "Teknik Konstruksi dan Properti") {
                $jurusan = "TKP";
            }
            if ($getJurusan[$i]->nama_jurusan == "Desain Pemodelan dan Informasi Bangunan") {
                $jurusan = "DPIB";
            }
            if ($getJurusan[$i]->nama_jurusan == "Kimia Industri") {
                $jurusan = "KI";
            }
            if ($getJurusan[$i]->nama_jurusan == "Teknik Geomatika") {
                $jurusan = "GMT";
            }
            if ($getJurusan[$i]->nama_jurusan == "Teknik Installasi Tenaga Listrik") {
                $jurusan = "TITL";
            }
            if ($getJurusan[$i]->nama_jurusan == "Teknik Komputer dan Jaringan") {
                $jurusan = "TKJ";
            }
            if ($getJurusan[$i]->nama_jurusan == "Teknik Mekatronika") {
                $jurusan = "MEKA";
            }
            if ($getJurusan[$i]->nama_jurusan == "Teknik Kendaraan Ringan Otomotif") {
                $jurusan = "TKRO";
            }
            if ($getJurusan[$i]->nama_jurusan == "Teknik Pengelasan") {
                $jurusan = "TP";
            }
            if ($getJurusan[$i]->nama_jurusan == "Teknik Elektronika Industri") {
                $jurusan = "TEI";
            }

            for ($j=0; $j < count($getTingkat) ; $j++) { 

                if (str_contains($jurusan, 'TKRO')) {
                    for ($h=0; $h < 3 ; $h++) { 
                        $dataKelas = array(
                            array(
                                'jurusan_id'    => $getJurusan[$i]->id,
                                'tingkat_id'    => $getTingkat[$j]->id,
                                'nama_kelas'    => $getTingkat[$j]->nama_tingkat."-".$jurusan."-".strval($h+1),
                                'created_at'    => date("Y-m-d H:i:s"),
                                'updated_at'    => date("Y-m-d H:i:s"),
                            ),
                        );

                        DB::table('kelas')->insert($dataKelas);
                    }
                }elseif(str_contains($jurusan, 'KI') || str_contains($jurusan, 'MEKA') || str_contains($jurusan, 'TP')){
                    $dataKelas = array(
                        array(
                            'jurusan_id'    => $getJurusan[$i]->id,
                            'tingkat_id'    => $getTingkat[$j]->id,
                            'nama_kelas'    => $getTingkat[$j]->nama_tingkat."-".$jurusan,
                            'created_at'    => date("Y-m-d H:i:s"),
                            'updated_at'    => date("Y-m-d H:i:s"),
                        ),
                    );

                    DB::table('kelas')->insert($dataKelas);
                }else{
                    for ($h=0; $h < 2 ; $h++) { 
                        $dataKelas = array(
                            array(
                                'jurusan_id'    => $getJurusan[$i]->id,
                                'tingkat_id'    => $getTingkat[$j]->id,
                                'nama_kelas'    => $getTingkat[$j]->nama_tingkat."-".$jurusan."-".strval($h+1),
                                'created_at'    => date("Y-m-d H:i:s"),
                                'updated_at'    => date("Y-m-d H:i:s"),
                            ),
                        );

                        DB::table('kelas')->insert($dataKelas);
                    }
                } 
            }
        }
    }
}
