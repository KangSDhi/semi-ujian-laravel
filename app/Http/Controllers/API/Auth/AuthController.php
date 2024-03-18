<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AdminResource;
use App\Http\Resources\SiswaResource;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            "emailOrNisn" => "required",
            "password"  => "required"
        ], [
            "emailOrNisn.required" => "Email Atau ID Peserta Kosong!",
            "password.required" => "Password Kosong!"
        ]);

        if($validator->fails()){
            return response()->json([
                'code'   => 400,
                'error_message' => $validator->errors()
            ], 400);
        }

        if(filter_var($request->emailOrNisn, FILTER_VALIDATE_EMAIL)){
            $credentials = array(
                'email' => $request->emailOrNisn,
                'password'  => $request->password,
            );
        } else {
            $credentials = array(
                'NISN' => $request->emailOrNisn,
                'password'  => $request->password,
            );
        }

        if (!$token = auth()->guard('jwt')->setTTL(1440)->attempt($credentials)) {
            return response()->json([
                'code' => 400,
                'error_message' => 'Email, ID Peserta atau Password Salah!'
            ], 400);
        }


        $user = auth()->guard('jwt')->user();

        if ($user->role_id == 1) {
            $data = new AdminResource($user);
        } elseif ($user->role_id == 2) {
            $data = new SiswaResource($user);
        }

        return response()->json([
            'code'   => 200,
            'data'  => [
                'user'      => $data,
                'token'     => $token
            ]
        ], 200);
    }

    public function logout(){
        auth()->guard('jwt')->logout();
        return response()->json([
            "code"  => 200,
            "message"   => "Logout Berhasil"
        ], 200);
    }

    public function check(){
        $user = auth()->guard('jwt')->user();
        $data["role_id"] = $user->role_id;
        $data["nama_user"] = $user->name;
        if ($user->role_id == 2) {
            $data["kelas"] = $user->kelas->nama_kelas;
        }
        return response()->json([
            "code"  => 200,
            "data"  => $data
        ], 200);
    }
}
