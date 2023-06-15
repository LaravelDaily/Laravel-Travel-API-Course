<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * @group Auth endpoints
 */
class LoginController extends Controller
{
    /**
     * POST Login
     *
     * Login with the existing user.
     *
     * @response {"access_token":"1|a9ZcYzIrLURVGx6Xe41HKj1CrNsxRxe4pLA2oISo"}
     * @response 422 {"error": "The provided credentials are incorrect."}
     */
    public function __invoke(LoginRequest $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'error' => 'The provided credentials are incorrect.',
            ], 422);
        }

        $device = substr($request->userAgent() ?? '', 0, 255);

        return response()->json([
            'access_token' => $user->createToken($device)->plainTextToken,
        ]);
    }
}
