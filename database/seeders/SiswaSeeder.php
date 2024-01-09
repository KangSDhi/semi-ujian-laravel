<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $pass = $this->generateRandomString();

        $data = array(
            array(
                'name' => 'ABDUL ROHMAN',
                'NISN'  => '0284844',
                'password' => bcrypt($pass),
                'password_dec' => $pass,
                'role_id'   => 2,
                'jurusan_id'    => 2
            )
        );

        DB::table('users')->insert($data);


    }

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
