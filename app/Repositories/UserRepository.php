<?php
namespace App\Repositories;

use App\Models\User;

interface UserRepository
{
    public function create(array $attributes): User;
    public function getByGoogleId(string $googleId):?User;
    public function update(string $id,array $attributes):bool;
}
