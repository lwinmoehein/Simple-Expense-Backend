<?php
namespace App\Repositories;

use App\Models\User;

class UserMySQLRepository implements UserRepository
{
    public function create(array $attributes): User
    {
        return User::create($attributes);
    }

    public function getByGoogleId(string $googleId): ?User
    {
        return User::where("google_user_id",$googleId)->get()->first();
    }

    public function update(string $id,array $attributes): bool
    {
        $updateRowCount = User::where('id',$id)->update($attributes);

        return $updateRowCount>0;
    }
}
