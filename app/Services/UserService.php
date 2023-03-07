<?php
namespace App\Services;

use App\Repositories\UserRepository;

class  UserService {
    protected  $userRepository;

   public function __construct(UserRepository  $userRepository){
       $this->userRepository = $userRepository;
   }

   public function getToken($googleIdToken){
           $googleUser = \GoogleAuthentication::getUserInfo($googleIdToken);

           if($googleUser){
               $user = User::create([
                   "google_name"=>$googleUser['name'],
                   "google_user_id"=>$googleUser['sub'],
                   "google_email"=>$googleUser['email'],
                   "google_picture"=>$googleUser['picture']
               ]);
               return $user->createToken();
           }
           return null;
   }
}
