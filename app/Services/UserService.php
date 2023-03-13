<?php
namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

class  UserService {
    protected  $userRepository;

   public function __construct(UserRepository  $userRepository){
       $this->userRepository = $userRepository;
   }

   public function getToken($googleIdToken):?string{
           $googleUser = \GoogleAuthentication::getUserInfo($googleIdToken);

           if(!$googleUser) return null;

           $existingUser = $this->userRepository->getByGoogleId($googleUser['sub']);

           if($existingUser) return $existingUser->createToken("access_token")->plainTextToken;

           if($googleUser){
               $user = User::create([
                   "google_name"=>$googleUser['name'],
                   "google_user_id"=>$googleUser['sub'],
                   "google_email"=>$googleUser['email'],
                   "google_picture"=>$googleUser['picture']
               ]);
              return $user->createToken("access_token")->plainTextToken;
           }

           return null;
   }
   public function updateUser(string $id,array $attributes):bool{
       try{
          return $this->userRepository->update($id,$attributes);
       }catch (\Exception $e){
           return false;
       }
       return false;
   }
   public function updateProfileImage(int $userId,$requestImage):bool{
       try{
           $fileName =  $userId.'.'.$requestImage->extension();
           $requestImage->storeAs('public/images', $fileName);
           $imageUrl = url('storage/images/'.$fileName);
           return $this->updateUser($userId,["google_picture"=>$imageUrl]);
       }catch (\Exception $e){
           return false;
       }
       return false;
   }

}
