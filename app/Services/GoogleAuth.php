<?php
namespace App\Services;

use Google\Client;

class GoogleAuth {
    public function getUserInfo($key):?array{
        $client = new Client(['client_id' =>config('services.google_auth.client_id') ]);
        $payload = $client->verifyIdToken($key);
        if ($payload) {
            return $payload;
        } else {
           return null;
        }
    }
}
