<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
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

    /**
     * @throws ValidationException
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        return $this->userService->forgotPasswordNotify($request);
    }

    public function reset(ResetPasswordRequest $request)
    {
        return $this->userService->resetPassword($request);
    }
}
