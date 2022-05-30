<?php

namespace App\Services;

use App\Models\Profile;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use JetBrains\PhpStorm\ArrayShape;

class UserService
{
    #[ArrayShape(['email' => "", 'password' => "", 'token' => "mixed"])]
    public function createUser($request): array
    {
        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'api_token' => Str::random(60)
        ]);

        $profile = Profile::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
        ]);

        $user->profile()->save($profile);

        return [
            'email' => $request->email,
            'password' => $request->password,
            'token' => $this->setAuthToken($user)
        ];
    }

    private function setAuthToken($user)
    {
        return $user->createToken("AuthToken")->plainTextToken;
    }

    #[ArrayShape(['status' => "mixed"])]
    public function forgotPasswordNotify($request): array
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return [
                'status' => __($status)
            ];
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }

    public function resetPassword($request
    ): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                $user->tokens()->delete();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response([
                'message' => 'Password reset successfully.'
            ]);
        }

        return response([
            'message' => __($status)
        ], 500);
    }
}
