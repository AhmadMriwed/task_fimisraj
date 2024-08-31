<?php

use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Budget\BudgetController;
use App\Http\Controllers\Expense\ExpenseController;
use App\Http\Controllers\MailBox\ReplayBoxController;
use App\Http\Controllers\MailBox\RequestBoxController;
use App\Http\Controllers\MailBox\RequestTypeController;
use App\Http\Controllers\MailBox\UserSearchController;
use App\Http\Controllers\PlantsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware([])->group(function () {
    Route::post('register', [UserAuthController::class, 'register']);
    Route::post('login', [UserAuthController::class, 'login']);
    Route::post('forgot-password', [ForgetPasswordController::class, 'sendOtpCode'] );
    Route::post('validate-forgot-password-otp',[ForgetPasswordController::class, 'validateOtpCode']);
    Route::post('reset-password',[ForgetPasswordController::class, 'resetPassword']);
});

Route::middleware(['auth:sanctum'])->group(function () {


    //Auth
        Route::put('updatePassword', [UserAuthController::class, 'updatePassword']);
        Route::get('', [UserAuthController::class, 'getMyProfile']);
        Route::delete('logout', [UserAuthController::class, 'logout']);
        Route::get('resendVerificationEmail', [UserAuthController::class, 'resendVerificationEmail']);
        // Route::put('updateLanguage', [UserAuthController::class, 'updateLanguage']);
        // Route::put('updateFcmToken', [UserAuthController::class, 'updateFcmToken']);
        Route::post('updateProfile', [UserAuthController::class, 'update']);

    
    /// Budget
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('budgets', BudgetController::class);
    });    
    

    /// Expense
    Route::group(['prefix' => 'expenses'], function () {
        Route::apiResource('', ExpenseController::class);

        // Export Expenses as Excel
        Route::get('/export', [ExpenseController::class, 'export']);
    
            // Export Expense Reports as Excel
            Route::get('/report/export', [ExpenseController::class, 'exportReport']);

             // showInvestmentRecommendations
        Route::get('/showInvestmentRecommendations', [ExpenseController::class, 'showInvestmentRecommendations']);
    
        });
        
       
   
    
    });

