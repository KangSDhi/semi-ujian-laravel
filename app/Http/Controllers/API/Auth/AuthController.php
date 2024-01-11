<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AdminResource;
use App\Http\Resources\SiswaResource;

class AuthController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            "emailOrNisn" => "required",
            "password"  => "required"
        ], [
            "emailOrNisn.required" => "Email Atau NISN Kosong!",
            "password.required" => "Password Kosong!"
        ]);

        if($validator->fails()){
            return response()->json([
                'success'   => false,
                'errors'    => $validator->errors()
            ], 422);
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
                'success' => false,
                'error' => 'Email, NISN atau Password Salah!'
            ], 401);
        }


        $user = auth()->guard('jwt')->user();

        if ($user->role_id == 1) {
            $data = new AdminResource($user);
        } elseif ($user->role_id == 2) {
            $data = new SiswaResource($user);
        }

        return response()->json([
            'success'   => true,
            'user'      => $data,
            'token'     => $token
        ], 200);
    }
}
