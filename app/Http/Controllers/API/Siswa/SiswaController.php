<?php

namespace App\Http\Controllers\API\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jurusan;
use App\Models\SubKelas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    public function index(){
        $siswa = User::join('sub_kelas', 'users.sub_kelas_id', 'sub_kelas.id')
            ->select(DB::raw('users.id, 
            users.NISN as nisn, 
            users.name as nama_siswa,
            nama_sub_kelas,
            users.password_dec'))
            ->where('role_id', 2)
            ->orderBy('sub_kelas.nama_sub_kelas', 'asc')
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
            "nama_sub_kelas"  => "required"
        ];

        $messages = [
            "nama_siswa.required"           => "Mohon Isi Nama Siswa!",
            "nisn.required"                 => "Mohon Isi NISN!",
            "nisn.unique"                   => "NISN Sudah Terdaftar!",
            "password.required"             => "Mohon Isi Password!",
            "password_konfirmasi.required"  => "Mohon Isi Konfirmasi Password!",
            "password_konfirmasi.same"      => "Password Konfirmasi Tidak Sama Dengan Password!",
            "nama_sub_kelas.required"       => "Mohon Isi Sub Kelas!"
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                "code" => 400,
                "error_message" => $validator->errors()
            ], 400);
        }

        $subKelas = SubKelas::where("nama_sub_kelas", $request->nama_sub_kelas)->first();

        $siswa = new User();
        $siswa->name = $request->nama_siswa;
        $siswa->NISN = $request->nisn;
        $siswa->password = bcrypt($request->password);
        $siswa->password_dec = $request->password;
        $siswa->sub_kelas_id = $subKelas->id;
        $siswa->role_id = 2;
        $siswa->save();

        return response()->json([
            "code"  => 201,
            "message"   => "Berhasil Membuat Siswa Baru"
        ], 201);
    }

    public function batchCreate(Request $request){
        // dd($request->all());
        $rules = [
            "data.*.nama_siswa" => "required",
            "data.*.nisn"   => "required|unique:users,NISN",
            "data.*.sub_kelas"    => "required"
        ];

        $messages = [];

        foreach($request->data as $key => $value){
            $messages["data.$key.nama_siswa.required"] = "Baris Ke-".strval($key+2)." Nama Siswa Kosong!";
            $messages["data.$key.nisn.required"] = "Baris Ke-".strval($key+2)." NISN Kosong!";
            $messages["data.$key.nisn.unique"] = "Baris Ke-".strval($key+2)." NISN Sudah Terdaftar!";
            $messages["data.$key.sub_kelas.required"] = "Baris Ke-".strval($key+2)." Sub Kelas Kosong!";
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

            $subKelas = SubKelas::where('nama_sub_kelas', $dataRequest[$key]['sub_kelas'])->first();

            $dataStore[$key]['name'] = $dataRequest[$key]['nama_siswa'];
            $dataStore[$key]['NISN'] = $dataRequest[$key]['nisn'];
            $dataStore[$key]['password'] = bcrypt($pass);
            $dataStore[$key]['password_dec'] = $pass;
            $dataStore[$key]['role_id'] = 2;
            $dataStore[$key]['sub_kelas_id'] = $subKelas->id;
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

            return response()->json([
                "code"  => 500,
                "error_status"  => "Internal Server Error!",
                "error_message" => $exception->getMessage(),
            ], 500);
        }

    }

    public function update(Request $request){

        $rules = [
            "id"    => "required",
            "nisn"  => "required",
            "nama_siswa"    => "required",
            "nama_sub_kelas"  => "required",
            "password"  => "required",
        ];

        $messages = [
            "nisn.required" => "Mohon Isi NISN!",
            "nama_siswa.required" => "Mohon Isi Nama Siswa!",
            "nama_sub_kelas.required" => "Mohon Isi Sub Kelas!",
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

        $subKelas = SubKelas::where('nama_sub_kelas', $request->nama_sub_kelas)->first();

        $siswa = User::find($request->id);

        $siswa->name = $request->nama_siswa;
        $siswa->NISN = $request->nisn;
        $siswa->sub_kelas_id = $subKelas->id;
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
