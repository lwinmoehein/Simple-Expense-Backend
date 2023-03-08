<?php

namespace App\Http\Controllers\Api\V1;

use App\Repositories\UserRepository;
use App\Services\UserService;

class AuthController extends ApiController
{

    protected  $userService;
    public function __construct(UserRepository  $userRepository)
    {
        $this->userService = new UserService($userRepository);
    }

    public function getAccessToken($googleIdToken){
        if(!$googleIdToken)
            return $this->respondUnAuthenticated();

        try{
            $token = $this->userService->getToken($googleIdToken);
            if($token)
                return $this->respondWithSuccess([
                    "data"=>[
                        "token"=>$token->plainTextToken
                    ]
                ]);
        }catch (\Exception $e){
          return $this->respondUnAuthenticated();
        }

        return $this->respondUnAuthenticated();
    }
}
