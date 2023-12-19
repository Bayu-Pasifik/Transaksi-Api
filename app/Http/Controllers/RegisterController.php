<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "email" => "required|email|unique:users",
            "password" => "required|confirmed|min:8",
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => "Validasi Gagal", "errors" => $validator->errors()], 422);
        }

        try {
            $user = User::create([
                "email" => $request->email,
                "password" => bcrypt($request->password),
                "name" => $request->name
            ]);

            return response()->json(["message" => "Berhasil Register", "data" => $user]);
        } catch (\Throwable $th) {
            return response()->json(["message" => $th->getMessage()], 500);
        }
    }
}
