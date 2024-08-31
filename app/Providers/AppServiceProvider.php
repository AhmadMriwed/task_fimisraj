<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('data', function ($data, $message = null) {
            $responseData = ['data' => $data];
            if ($message !== null) {
                $responseData['message'] = $message;
            }
            return Response::json($responseData);
        });
        // Response::macro('data', function ($data) {
        //     return Response::json(['data' => $data]);
        // });

        Response::macro('error', function ($message, $status = 400) {
            return Response::json([
                'message' => $message,
            ], $status);
        });
    }
}
