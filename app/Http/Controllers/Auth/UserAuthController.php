<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserUpdatePasswordRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\Auth\UserAuthResource;
use App\Http\Resources\UserResource;
use App\Services\User\Auth\UserAuthService;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Facades\Socialite;
use Auth;
use App\Models\User;


class UserAuthController extends Controller
{
    public function getMyProfile(): UserResource
    {
        return UserResource::make(auth()->user());
    }
    public function register(UserRegisterRequest $request): UserAuthResource
    {

        return UserAuthResource::make(UserAuthService::register($request->validated()));
    }

    public function login(UserLoginRequest $request): JsonResponse|UserAuthResource
    {

        return UserAuthService::login($request->validated());
    }


    public function logout()
    {
        auth()->user->currentAccessToken()->delete();
    }

}
