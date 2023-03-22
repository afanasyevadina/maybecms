<?php

namespace Altenic\MaybeCms\Http\Controllers\Api;

use Altenic\MaybeCms\Http\Controllers\Controller;
use Altenic\MaybeCms\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if ($user && Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'name' => $user->name,
                'email' => $user->email,
                'token' => $user->createToken($user->email)->plainTextToken,
            ]);
        }
        return response()->noContent(401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();
        return response()->noContent(200);
    }
}
