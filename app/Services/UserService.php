<?php
namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class  UserService {
    protected  $userRepository;

   public function __construct(UserRepository  $userRepository){
       $this->userRepository = $userRepository;
   }

   public function getToken($googleIdToken){
           $googleUser = \GoogleAuthentication::getUserInfo($googleIdToken);

           if($googleUser){
               $user = User::updateOrCreate([
                   "google_name"=>$googleUser['name'],
                   "google_user_id"=>$googleUser['sub'],
                   "google_email"=>$googleUser['email'],
                   "google_picture"=>$googleUser['picture']
               ]);
              return $user->createToken("access_token");
           }
           return null;
   }
}
