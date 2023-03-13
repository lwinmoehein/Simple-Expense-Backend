<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\UpdateUser;
use App\Http\Requests\UpdateUserImage;
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
                        "token"=>$token
                    ]
                ]);
        }catch (\Exception $e){
          return $this->respondUnAuthenticated();
        }

        return $this->respondUnAuthenticated();
    }
    public function update(UpdateUser  $request){
        $isUserUpdated = $this->userService->updateUser(auth()->user()->id,$request->validated());

        if($isUserUpdated)
            return $this->respondNoContent();

        return $this->respondError("Cannot update user.");
    }
    public function updateProfileImage(UpdateUserImage $request){
        $isImageUpdated = $this->userService->updateProfileImage(auth()->user()->id,$request->google_picture);

        if($isImageUpdated)
            return $this->respondNoContent();

        return $this->respondError("Cannot update user image.");
    }
    public function get(){
        try{
                return $this->respondWithSuccess([
                    "data"=>[
                        "user"=>auth()->user()
                    ]
                ]);
        }catch (\Exception $e){
            return $this->respondError();
        }
    }
}
