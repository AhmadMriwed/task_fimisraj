<?php

namespace App\Services\User\Auth;

use App\Enums\AccountType;
use App\Enums\UserTypes;
use App\Events\UserEmailVerificationEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

use Illuminate\Auth\Events\Registered;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use App\Http\Resources\Auth\UserAuthResource;
use App\Models\User;
use App\Models\UserIds;
use App\Traits\Media;
use Illuminate\Support\Facades\Log;

class UserAuthService 
{
    use Media;
    public static function register(array $attributes): Model|Builder
    {

        
        $user = User::query()->create($attributes);
        VerifyEmail::createUrlUsing(function()  use ($user){
            return URL::temporarySignedRoute(
                'verification.verify.user',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                [
                    'id' => $user->getKey(),
                    'hash' => sha1($user->email),
                ]
            );
        });
        event(new Registered($user));
        return $user;
    }

    public static function login(array $attributes): JsonResponse|UserAuthResource
    {

        try {
            $user = User::where('email', '=', $attributes['email'])->firstOrFail();
            throw_if(!Hash::check($attributes['password'], $user->password), new \Exception('Wrong password'));
            return UserAuthResource::make($user);
        } catch (\Throwable $e) {
            return \response()->json(['general' => $e->getMessage()], 403);
        }
    }



    public static function resendVerificationEmail( $user)
    {
        event(new UserEmailVerificationEvent($user));
    }
    public static function update(array $attributes, $user): UserResource|JsonResponse
    {
        try {
            $user->update($attributes);
            return UserResource::make($user);
        } catch (\Throwable $e) {
            return \response()->json(['general' => $e->getMessage()], 403);
        }
    }
    public  function updateImage($image, $user)
    {
        if(!is_null($image)){
            $imagePath = $this->upload_file($image, "Users");
 
            $user->update(['image'=>$imagePath??null]);
        }
        return $user->image;
    }

    public static function updatePassword(array $attributes, $user): UserResource|JsonResponse
    {
        try {
            throw_if(!Hash::check($attributes['old_password'], $user->password), new \Exception('Wrong password'));
            $user->update(['password' => $attributes['new_password']]);
            return UserResource::make($user);
        } catch (\Throwable $e) {
            return \response()->json(['general' => $e->getMessage()], 403);
        }
    }
}
