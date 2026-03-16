<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ApiAuthController extends Controller
{
    /**
     * Login and return a Sanctum token.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)
            ->orWhere('email', $request->username)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Username au password sio sahihi.',
            ], 401);
        }

        // Revoke any existing tokens for this device
        $user->tokens()->where('name', 'mobile-app')->delete();

        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Karibu tena!',
            'data' => [
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'username' => $user->username,
                    'role' => $user->role,
                ],
            ],
        ]);
    }

    /**
     * Return the authenticated user info.
     */
    public function user(Request $request)
    {
        $user = $request->user();
        $bus = $user->assignedBus();

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'username' => $user->username,
                    'role' => $user->role,
                ],
                'assigned_bus' => $bus ? [
                    'id' => $bus->id,
                    'plate_number' => $bus->plate_number,
                    'status' => $bus->status,
                ] : null,
            ],
        ]);
    }

    /**
     * Logout — revoke the current token.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Umeondoka salama.',
        ]);
    }
}
