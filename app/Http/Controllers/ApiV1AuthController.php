<?php

namespace App\Http\Controllers;

use App\Services\GoogleAuth;
use Illuminate\Http\Request;

class ApiV1AuthController extends Controller
{
    //
    public function test($token){
        return response()->json(GoogleAuth::getUserInfo($token));
    }
}
