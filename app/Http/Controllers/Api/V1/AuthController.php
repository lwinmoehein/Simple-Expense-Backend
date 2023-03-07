<?php

namespace App\Http\Controllers\Api\V1;

use App\Repositories\UserMySQLRepository;
use App\Repositories\UserRepository;
use App\Services\UserService;

class AuthController extends ApiController
{

    protected  $userService;
    public function __construct(UserMySQLRepository  $userRepository)
    {
        $this->userService = new UserService($userRepository);
    }

    /**
     * @OA\Get(
     *     path="/api/get-access-token/{googleIdToken}",
     *     summary="Get app token by using google id token",
     *     @OA\Parameter(
     *         description="use google id token from firebase authentication.",
     *         in="path",
     *         name="googleIdToken",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="returns a sanctum token if successful."
     *     )
     * )
     */
    public function getAccessToken($googleIdToken){

        try{
            $token = $this->userService->getToken($googleIdToken);
            if($token)
                return $this->respondWithSuccess(["token"=>$token]);
        }catch (\Exception $e){
          return $this->respondNotFound("Invalid google id token.");
        }

        return $this->respondUnAuthenticated();
    }
}
