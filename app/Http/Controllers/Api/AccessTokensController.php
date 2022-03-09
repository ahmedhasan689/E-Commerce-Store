<?php

namespace App\Http\Controllers\Api;

use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Laravel\Sanctum\PersonalAccessToken;

class AccessTokensController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required'],
            'password' => ['required'],
            'device_name' => ['required'],
            'abilities' => ['nullable'],
        ]);

        $user = User::where('email', $request->username)
                ->orWhere('mobile', $request->username)
                ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return Response::json([
                'message' => 'Invalid Username And Password Combination',
            ], 401);
        }

        $abilities = $request->input('abilities', ['*']); // string

        if($abilities && is_string($abilities)) {
            $abilities = explode(',', $abilities);
        }

        $token = $user->createToken($request->device_name, $abilities);

        // $access_token = $user->tokens()->latest()->first();

        // $access_token = PersonalAccessToken::findToken($token->plainTextToken);

        // $access_token->forceFill([
        //     'ip' => $request->ip(),
        // ])->save();


        return Response::json([
            'token' => $token->plainTextToken,
            'user' => $user,
        ]);

    }

    public function destroy()
    {
        $user = Auth::guard('sanctum')->user();

        // Revoke ( Delete ) All User Token
        // $user->tokens()->delete();

        // Revoke The Current User Token
        $user->currentAccessToken()->delete();
    }

}
