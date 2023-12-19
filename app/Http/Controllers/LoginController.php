<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $token = Auth::user()->createToken('token-name')->plainTextToken;
            return response()->json([
                'message' => 'Berhasil Login',
                'token' => $token
            ]);
        }

        return response()->json(['message' => 'Invalid login credentials'], 401);
    }
}
