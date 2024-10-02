<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdmloginController extends Controller
{
    public function index()
    {
        $users = User::get();
        if ($users->count() > 0) {
            return AuthResource::collection($users);
            return response()->json([
                'status' => Response::HTTP_OK
            ],Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'No record availble'], 200);
        }
    }

    public function store(Request $request){
        // Validasi data input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);



        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid credentials',
                'errors' => $validator->messages(),
            ], 422);
        }

        // Mencari pengguna berdasarkan email
        $user = User::where('email', $request->email)->first();
        $role = $user->role;

        // Memeriksa apakah pengguna ada dan password benar
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        if ($role != 'admin') {
            return response()->json([
                'message' => 'Acces denied : Admin only',
            ], 401);
        }
        

        // Membuat token untuk pengguna jika menggunakan Laravel Sanctum
        // $token = $user->createToken('MyApp')->plainTextToken;

        return response()->json([
            'message' => 'Login admin successful',
            // 'token' => $token,
        ]);
    }
}
