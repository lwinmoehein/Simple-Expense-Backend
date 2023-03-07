<?php
namespace App\Repositories;

use App\Models\User;

class UserMySQLRepository implements UserRepository
{
    public function create(array $attributes): User
    {
        return User::create($attributes);
    }
}
