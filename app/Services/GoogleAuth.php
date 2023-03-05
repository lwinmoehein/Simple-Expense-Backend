<?php
namespace App\Services;

use Google\Client;

class GoogleAuth {
//    protected  $clientId;
//    public function __contruct(){
//        $this->clientId = config('services.google_auth.client_id');
//    }
    public function getUserInfo($key){
        $client = new Client(['client_id' =>config('services.google_auth.client_id') ]);
        $payload = $client->verifyIdToken($key);
        if ($payload) {
            return $payload;
        } else {
           return null;
        }
    }
}
