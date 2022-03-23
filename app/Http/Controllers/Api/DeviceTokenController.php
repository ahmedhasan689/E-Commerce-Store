<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DeviceTokenController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'device' => 'required',
        ]);

        $user = Auth::guard('sanctum')->user();

        $user->deviceTokens()->create($request->all());

        return;
    }
}
