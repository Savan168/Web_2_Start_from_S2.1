<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\SigninRequest;
use App\Http\Requests\User\SignupRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    function signup(SignupRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $user->sendEmailVerificationNotification($request->callback_url);

        return response([
            'message' => 'User signed up. Please check your email to verify your account.',
            'user' => new UserResource($user)
        ], 201);
    }

    function signin(SigninRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => 'Password does not match.',
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response([
            'message' => 'User signed in.',
            'user' => new UserResource($user),
            'token' => $token
        ], 200);
    }

    function signout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response([
            'message' => 'User signed out.'
        ], 200);
    }

    function verify(Request $request)
    {
        return response([
            'message' => 'Token is valid.',
            'user' => new UserResource($request->user())
        ], 200);
    }

    function verifyEmail(Request $request)
    {
        $user = User::find($request->route('id'));

        if (!$user || !hash_equals(sha1($user->getEmailForVerification()), $request->route('hash'))) {
            abort(403, 'Invalid verification link.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect($request->query('callback', config('app.frontend_url') . '/signin'));
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect($request->query('callback', config('app.frontend_url') . '/signin'));
    }

    function sendVerificationEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'callback_url' => 'required|url',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->hasVerifiedEmail()) {
            return response(['message' => 'Email already verified.'], 200);
        }

        $user->sendEmailVerificationNotification($request->callback_url);

        return response(['message' => 'Verification email sent.'], 200);
    }
}