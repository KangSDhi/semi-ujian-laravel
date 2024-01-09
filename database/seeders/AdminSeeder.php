<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = array(
            array(
                'name' => 'Sigit Boworaharjo',
                'email' => 'kangteknisi@gmail.com',
                'password' => bcrypt('12345'),
                'role_id'   => 1
            )
        );

        DB::table('users')->insert($data);
    }
}
