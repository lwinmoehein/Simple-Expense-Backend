<?php

namespace App\Http\Controllers\Api\V1;

use App\Repositories\UserMySQLRepository;
use App\Repositories\UserRepository;
use App\Services\UserService;

class AuthController extends ApiController
{
    /**
     * @OA\Get(
     *     path="/api/test/23",
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */
    protected  $userService;
    public function __construct(UserMySQLRepository  $userRepository)
    {
        $this->userService = new UserService($userRepository);
    }

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
