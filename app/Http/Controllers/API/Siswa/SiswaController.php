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
            ->orderBy('jurusan.nama', 'asc')
            ->orderBy('users.name', 'asc')
            ->get();
        
        return response()->json([
            "code"  => 200,
            "data"  => $siswa
        ], 200);
    }

    public function create(Request $request){
        $rules = [
            "nama_siswa"    => "required",
            "nisn"          => "required|unique:users,NISN",
            "password"      => "required",
            "password_konfirmasi"   => "required|same:password",
            "nama_jurusan"  => "required"
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                "code" => 400,
                "error_message" => $validator->errors()
            ], 400);
        }

        $jurusan = Jurusan::where("nama", $request->nama_jurusan)->first();

        $siswa = new User();
        $siswa->name = $request->nama_siswa;
        $siswa->NISN = $request->nisn;
        $siswa->password = bcrypt($request->password);
        $siswa->password_dec = $request->password;
        $siswa->jurusan_id = $jurusan->id;
        $siswa->role_id = 2;
        $siswa->save();

        return response()->json([
            "code"  => 201,
            "message"   => "Berhasil Membuat Siswa Baru"
        ], 201);
    }

    public function batchCreate(Request $request){
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

    public function update(Request $request){

        $rules = [
            "id"    => "required",
            "nisn"  => "required",
            "nama_siswa"    => "required",
            "nama_jurusan"  => "required",
            "password"  => "required",
        ];

        $messages = [
            "nisn.required" => "Mohon Isi NISN!",
            "nama_siswa.required" => "Mohon Isi Nama Siswa!",
            "nama_jurusan.required" => "Mohon Isi Nama Jurusan!",
            "password.required" => "Mohon Isi Password!",
            "konfirmasi_password.same" => "Konfirmasi Password Tidak Sama Dengan Password!",
        ];

        if ($request->konfirmasi_password != null) {
            $rules['konfirmasi_password'] = "same:password";
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                "code" => 400,
                "error_message" => $validator->errors()
            ], 400);
        }

        $jurusan = Jurusan::where('nama', $request->nama_jurusan)->first();

        $siswa = User::find($request->id);

        $siswa->name = $request->nama_siswa;
        $siswa->NISN = $request->nisn;
        $siswa->jurusan_id = $jurusan->id;
        $siswa->password = bcrypt($request->password);
        $siswa->password_dec = $request->password;
        $siswa->save();

        return response()->json([
            "code"  => 201,
            "message"   => "Berhasil Mengubah Data"
        ], 201);
    }

    public function destroy($id){
        User::where('id', $id)->delete();

        return response()->json([
            "code"  => 200,
            "message"   => "Berhasil Menghapus Siswa"
        ], 200);
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
