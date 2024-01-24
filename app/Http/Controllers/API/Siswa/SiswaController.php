<?php

namespace App\Http\Controllers\API\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jurusan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    public function index(){
        $siswa = User::join('jurusan', 'users.jurusan_id', 'jurusan.id')
            ->select(DB::raw('users.id, 
            users.NISN as nisn, 
            users.name as nama_siswa,
            jurusan.nama as nama_jurusan,
            users.password_dec'))
            ->where('role_id', 2)
            ->get();
        
        return response()->json([
            "code"  => 200,
            "data"  => $siswa
        ], 200);
    }

    public function batchCreate(Request $request){
        // dd($request->data);
        $rules = [
            "data.*.nama_siswa" => "required",
            "data.*.nisn"   => "required",
            "data.*.jurusan"    => "required"
        ];

        $messages = [];

        foreach($request->data as $key => $value){
            $messages["data.$key.nama_siswa"] = "Baris Ke-".strval($key+2)." Nama Siswa Kosong!";
            $messages["data.$key.nisn"] = "Baris Ke-".strval($key+2)." NISN Kosong!";
            $messages["data.$key.jurusan"] = "Baris Ke-".strval($key+2)." Jurusan Kosong!";
        }


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                "code" => 400,
                "error_message" => $validator->errors()
            ], 400);
        }

        $dataRequest = $request->data;

        $dataStore = [];

        // $data[0]['password'] = "ssss";

        // dd($data[0]);

        // foreach($data as $key => $item){

        // }

        foreach ($dataRequest as $key => $value) {
            $pass = $this->generatePassword();

            $jurusan = Jurusan::where('nama', $dataRequest[$key]['jurusan'])->first();

            $dataStore[$key]['name'] = $dataRequest[$key]['nama_siswa'];
            $dataStore[$key]['NISN'] = $dataRequest[$key]['nisn'];
            $dataStore[$key]['password'] = bcrypt($pass);
            $dataStore[$key]['password_dec'] = $pass;
            $dataStore[$key]['role_id'] = 2;
            $dataStore[$key]['jurusan_id'] = $jurusan->id;
        }

        DB::beginTransaction();
        try {
            DB::table('users')->insert($dataStore);
            DB::commit();

            return response()->json([
                "code"  => 201
            ], 201);
        } catch (\Exception $exception) {
            DB::rollback();

            return resonse()->json([
                "code"  => 500,
                "error_message" => "internal server error"
            ], 500);
        }

    }

    public function generatePassword($length = 10){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
