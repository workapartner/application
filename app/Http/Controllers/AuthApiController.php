<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\Company;
use App\Models\Profile;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthApiController extends Controller
{
    private UserService $userService;

    /**
     * AuthApiController constructor.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function register(RegisterUserRequest $request)
    {
        try {
            $user = $this->userService->createUser($request);

            return response()->json([
                'status' => true,
                'message' => 'Sign up successful',
                'email' => $user['email'],
                'password' => $user['password'],
                'token' => $user['token'],

            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function login(Request $request)
    {
        $validation = $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|min:6'
        ]);

        if (!Auth::attempt($validation)) {
            return response()->json([
                'message' => 'Something wrong with email or password.'
            ], 401);
        }

        return response()->json([
            'status' => true,
            'message' => 'Sign in successful',
            'token' => Auth::user()->createToken("AuthToken")->plainTextToken
        ], 200);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();

        return response()->json([
            'message' => 'You\'re successfully logged out from the system.'
        ]);
    }

    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return User::all();
    }

    public function list(): \Illuminate\Database\Eloquent\Collection
    {
        return Company::all();
    }
}
