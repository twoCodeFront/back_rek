<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\{User, RefreshToken};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate(['email' => 'required|email', 'password' => 'required']);
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $accessToken = $user->createToken('web', [], now()->addMinutes(15))
            ->plainTextToken;

        $plainRefresh = Str::random(64);
        RefreshToken::updateOrCreate(
            ['user_id' => $user->id],
            ['token' => hash('sha256', $plainRefresh),
                'expires_at' => now()->addDays(14)]
        );

        Log::info('User logged in', ['user_id' => $user->id]);
        return response()->json([
            'access_token' => $accessToken,
            'refresh_token' => $plainRefresh,
            'user' => $user,
        ], 200)->cookie(
            'refresh_token', $plainRefresh,
            60 * 24 * 14,
            '/', null, true, true, false, 'Strict'
        );

    }

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->user()->token()->delete();

        RefreshToken::where('user_id', $request->user()->id)->delete();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate(
            [
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'name' => 'required|string|max:255',
            ]
        );

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user->assignRole('admin');

        return response()->json([
            'access_token' => $user->createToken('web', [], now()->addMinutes(15)),
            'user' => $user,
        ]);
    }

    public function refresh(Request $request): \Illuminate\Http\JsonResponse
    {
        $plain = $request->cookie('refresh_token');
        if (!$plain) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $row = RefreshToken::where('token', hash('sha256', $plain))
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$row) {
            return response()->json(['error' => 'Invalid'], 401);
        }

        $user = $row->user;

        //rotacja tokena

        $newPlain = Str::random(64);
        $row->update(
            [
                'token' => $newPlain,
                'expires_at' => now()->addDays(14)
            ]
        );

        $accessToken = $user->createToken('web', [], now()->addMinutes(15))
            ->plainTextToken;

        return response()->json([
            'access_token' => $accessToken,
            'refresh_token' => $newPlain,
        ])->cookie(
            'refresh_token', $newPlain,
            60 * 24 * 14,
            '/', null, true, true, false, 'Strict'
        );
    }
}
