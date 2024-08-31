<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CheckResetPasswordRequest;
use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Mail\SendOtpResetPassword;
use App\Models\Admin\Admin;
use App\Models\OtpResetPassword;
use App\Models\User;
use App\Services\User\Auth\ForgetPasswordService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgetPasswordController extends Controller
{
    
    public function sendOtpCode(ForgetPasswordService $service,ForgetPasswordRequest $request)
    {
       return $service->sendOtpCode($request->validated(),User::class);
    }


    public function validateOtpCode(ForgetPasswordService $service,CheckResetPasswordRequest $request)
    {
        return $service->validateOtpCode($request->validated(),User::class);
    }


    public function resetPassword(ForgetPasswordService $service,ResetPasswordRequest $request)
    {
        return $service->resetPassword($request->validated(),User::class);
    }
    // public function sendOtpCode(ForgetPasswordRequest $request)
    // {
    //    try {
    //         // delete all previous otp codes 
    //         OtpResetPassword::where('email', $request->email)->delete();

    //         // generate new otp code 
    //         $otpCode = mt_rand(100000, 999999);
    //         // add otp to DB
    //         OtpResetPassword::create(['email' => $request->email, 'code' => $otpCode, 'expires_at' => Carbon::now()->addHour()]);
    //         error_log("dd");
    //         // send mail to user
    //         new SendOtpResetPassword($otpCode);
    //         error_log("dd");
    //         Mail::to($request->email)->send(new SendOtpResetPassword($otpCode));

    //         return $this->sendSuccess(('messages.OtpSuccesSent'));
    //     } catch (\Throwable $e) {
    //         logger('Error while sending reset password otp',[$e]);
    //         return $this->sendError([],('messages.OtpErrorSending'),500);
    //     }
    // }


    // public function validateOtpCode(CheckResetPasswordRequest $request)
    // {
    //     $now = Carbon::now();
    //     $otpData = OtpResetPassword::where(['email' => $request->email, 'code' => $request->code])->first();

    //     if (isset($otpData) && $now->isAfter($otpData->expires_at)) {
    //         $otpData->delete();
    //         return $this->sendError([],('messages.validateOtpCodeError'),500);
    //     } else {
    //         return $this->sendSuccess(('messages.validateOtpCodeSuccess'));
    //     }
    // }


    // public function resetPassword(ResetPasswordRequest $request)
    // {
    //     $now = Carbon::now();
    //     $otpData = OtpResetPassword::where(['email' => $request->email, 'code' => $request->code])->first();

    //     if (isset($otpData) && $now->isAfter($otpData->expires_at)) {
    //         $otpData->delete();
    //         return $this->sendError([],('messages.validateOtpCodeError'),500);
    //     } else {
            
    //         $user = User::where('email', $request->email)->first();
    //         $user->update(['password' => Hash::make($request->password)]);
    //         $otpData->delete();
    //         return $this->sendSuccess(('messages.ResetPasswordSuccess'));
    //     }
    // }
    // public function resetPasswordAdmin(ResetPasswordRequest $request)
    // {
    //     $now = Carbon::now();
    //     $otpData = OtpResetPassword::where(['email' => $request->email, 'code' => $request->code])->first();

    //     if (isset($otpData) && $now->isAfter($otpData->expires_at)) {
    //         $otpData->delete();
    //         return $this->sendError([],('messages.validateOtpCodeError'),500);
    //     } else {
            
    //         $user = Admin::where('email', $request->email)->first();
    //         $user->update(['password' => Hash::make($request->password)]);
    //         $otpData->delete();
    //         return $this->sendSuccess(('messages.ResetPasswordSuccess'));
    //     }
    // }
}
