<?php

namespace App\Http\Controllers;


class ApiV1AuthController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/test",
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */
    public function test($token){
//        return response()->json(GoogleAuth::getUserInfo($token));
        return response()->json(GoogleAuthentication::getHello());
    }
}
