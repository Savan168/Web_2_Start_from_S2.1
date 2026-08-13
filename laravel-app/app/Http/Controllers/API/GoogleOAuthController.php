<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Socialite;

class GoogleOAuthController extends Controller
{
    public function googleOAuthRedirect(Request $request)
    {
        $callback_url = $request->query('callback_url', '');

        $redirectUrl = Socialite::driver('google')
            ->stateless()
            ->with([
                'state' => base64_encode($callback_url),
                'prompt' => 'select_account',
            ])
            ->redirect()
            ->getTargetUrl();

        return response(['redirect_url' => $redirectUrl], 200);
    }

    public function googleOAuthCallback(Request $request)
    {
        $callback_url = base64_decode($request->query('state', ''));
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect($callback_url.'?error=google_oauth_failed');
        }

        $email = $googleUser->getEmail();

        if (! $email) {
            return redirect($callback_url.'?error=missing_email');
        }

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $googleUser->getName(),
            ]
        );

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        $token = $user->createToken('auth_token', ['exchange-new-token'], now()->addMinutes(5))->plainTextToken;

        return redirect($callback_url.'?token='.urlencode($token));
    }

    public function googleOAuthExchangeToken(Request $request)
    {
        $user = $request->user();

        if (! $user->currentAccessToken()->can('exchange-new-token')) {
            return response(['message' => 'Invalid token.'], 403);
        }

        $user->currentAccessToken()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response([
            'message' => 'User signed in.',
            'user' => new UserResource($user),
            'token' => $token,
        ], 200);
    }
}
