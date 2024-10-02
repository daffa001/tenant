<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use Illuminate\Http\Response;
// use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
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

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required',
            'password' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'All fields are mendetory',
                'error' => $validator->messages(),
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'user'
        ]);


        return response()->json([
            'message' => 'User Created Succesfully',
            'data' => new AuthResource($user),

        ], 200);
    }
}
