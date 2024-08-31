<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConfigurationApiController extends Controller
{

/**
     * Display a anformation api.
     */
    public function infoRequest(Request $request)
    {
         // Access various properties of the request
    $url = $request->url();
    $method = $request->method();
    $parameters = $request->all();
    $headers = $request->header();

    // Print or log the information
    $statistics = collect();
    $statistics->put('URL', $url);
    $statistics->put('Method',$method );
    $statistics->put('Parameters',$parameters );
    $statistics->put('Headers',$headers );
 

    // ... your other logic

    return JsonResource::make($statistics)->additional(['message' => 'Request information printed.']);
       
    }

}
