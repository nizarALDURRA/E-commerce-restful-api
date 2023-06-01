<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Models\User;
use App\Service\SessionsService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponseTrait;
    public function register(StoreUserRequest $request): JsonResponse
    {
        User::create($request->validated());
        return $this->CreatedResponse();
    }

    public function login(LoginRequest $request,SessionsService $sessionsService): JsonResponse
    {
        if(Auth::attempt($request->except('login')))
        {
            $sessionsService->CreateSessions($request->user());
            return $this->DataResponse($request->user()->createToken("auth_token")->plainTextToken);
        }
        return $this->failureResponse('These credentials do not match our records.');
    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();
        return $this->SuccessResponse('Successfully logged out');
    }
}
