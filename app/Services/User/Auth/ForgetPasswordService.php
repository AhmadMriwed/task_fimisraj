<?php


namespace App\Services\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CheckResetPasswordRequest;
use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Mail\SendOtpResetPassword;
use App\Models\Admin\Admin;
use App\Models\OtpResetPassword;
use App\Models\User;
use Carbon\Carbon;
use Google\Service\Docs\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgetPasswordService extends Controller
{
    
    public function sendOtpCode( $attribute,$typeModel)
    {
       try {
        $now = Carbon::now();
        $otpData = OtpResetPassword::where(['email' => $attribute['email'],'type_model' => class_basename($typeModel)])->first();

        if($otpData&&!$now->isAfter($otpData->expires_at))
       {
         // حساب الفرق بين الأوقات
        $difference = $now->diff($otpData->expires_at);
        return $this->sendError(null,__('Time out, wait '.$difference->format('%H:%I:%S')),422);
       }   
        // delete all previous otp codes 
             OtpResetPassword::where('type_model', class_basename($typeModel))->where('email', $attribute['email'])->delete();
           
            // generate new otp code 
             $otpCode = mt_rand(100000, 999999);

            // add otp to DB
             OtpResetPassword::create(['email' => $attribute['email'], 'code' => $otpCode, 'expires_at' => Carbon::now()->addHour(),'type_model'=>class_basename($typeModel)]);
            
            // send mail to user
            new SendOtpResetPassword($otpCode);
     
            $result=Mail::to($attribute['email'])->send(new SendOtpResetPassword($otpCode));
       
            return $this->sendSuccess(null,__('messages.otpSuccesSent'));
        } catch (\Throwable $e) {
            logger('Error while sending reset password otp',[$e]);
            return $this->sendError($e->getMessage(),__('messages.otpErrorSending'),500);
        }
    }


    public function validateOtpCode( $attribute,$typeModel)
    {
      
        $now = Carbon::now();
        $otpData = OtpResetPassword::where(['email' => $attribute['email'],'type_model' => class_basename($typeModel), 'code' => $attribute['code']])->first();

        if (isset($otpData) && $now->isAfter($otpData->expires_at)) {
            $otpData->delete();
            return $this->sendError([],__('messages.validateOtpCodeError'),500);
        } else {
            return $this->sendSuccess(null,__('messages.validateOtpCodeSuccess'));
            
            
        }
    }


    public function resetPassword( $attribute,$typeModel)
    {
        $now = Carbon::now();
        $otpData = OtpResetPassword::where(['email' => $attribute['email'],'type_model' => class_basename($typeModel), 'code' => $attribute['code']])->first();

        if (isset($otpData) && $now->isAfter($otpData->expires_at)) {
            $otpData->delete();
            return $this->sendError([],__('messages.resetPasswordError'),500);
        } else {
            
            $user = $typeModel::where('email', $attribute['email'])->first();
            $user->update(['password' => Hash::make($attribute['password'])]);
            $otpData->delete();
            return $this->sendSuccess(null,__('messages.resetPasswordSuccess'));
        }
    }
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
