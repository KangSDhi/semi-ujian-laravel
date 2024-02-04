<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $getKelas = DB::table('kelas')->get();
        
        $subKelas = '';

        $dataSubKelas = array();

        for ($i=0; $i < count($getKelas) ; $i++) { 
            
            if (str_contains($getKelas[$i]->nama_kelas, 'TKRO')) {
                for ($j=0; $j < 3 ; $j++) { 
                    $dataSubKelas = array(
                        'kelas_id' => $getKelas[$i]->id,
                        'nama_sub_kelas' => $getKelas[$i]->nama_kelas."-".strval($j+1),
                        'created_at'    => date("Y-m-d H:i:s"),
                        'updated_at'    => date("Y-m-d H:i:s"),
                    );

                    DB::table('sub_kelas')->insert($dataSubKelas);
                }
            }elseif (str_contains($getKelas[$i]->nama_kelas, 'KI') || str_contains($getKelas[$i]->nama_kelas, 'MEKA') || str_contains($getKelas[$i]->nama_kelas, 'TP')) {
                $dataSubKelas = array(
                    'kelas_id' => $getKelas[$i]->id,
                    'nama_sub_kelas' => $getKelas[$i]->nama_kelas,
                    'created_at'    => date("Y-m-d H:i:s"),
                    'updated_at'    => date("Y-m-d H:i:s"),
                );

                DB::table('sub_kelas')->insert($dataSubKelas);
                
            }else{
                for ($j=0; $j < 2 ; $j++) { 
                    $dataSubKelas = array(
                        'kelas_id' => $getKelas[$i]->id,
                        'nama_sub_kelas' => $getKelas[$i]->nama_kelas."-".strval($j+1),
                        'created_at'    => date("Y-m-d H:i:s"),
                        'updated_at'    => date("Y-m-d H:i:s"),
                    );

                    DB::table('sub_kelas')->insert($dataSubKelas);
                }
            }            
        }
    }
}
