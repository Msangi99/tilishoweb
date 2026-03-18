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
     * Update authenticated user profile (name, email, phone, username, password).
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'sometimes|nullable|string|max:20',
            'username' => 'sometimes|string|max:255|unique:users,username,' . $user->id,
            'password' => 'sometimes|nullable|string|min:6|confirmed',
        ]);

        if (array_key_exists('name', $validated)) {
            $user->name = $validated['name'];
        }
        if (array_key_exists('email', $validated)) {
            $user->email = $validated['email'];
        }
        if (array_key_exists('phone', $validated)) {
            $user->phone = $validated['phone'] ?? null;
        }
        if (array_key_exists('username', $validated)) {
            $user->username = $validated['username'];
        }
        if (!empty($validated['password'] ?? null)) {
            $user->password = Hash::make($validated['password']);
        }
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated.',
            'data' => [
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
