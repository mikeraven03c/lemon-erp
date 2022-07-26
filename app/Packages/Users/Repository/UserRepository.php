<?php

namespace App\Packages\Users\Repository;

use App\Packages\Users\Models\User;
use App\Packages\Users\Contracts\UserContract;
use App\Packages\Users\DataTransferObjects\CreateUserData;
use App\Packages\Users\DataTransferObjects\UpdateUserData;

class UserRepository implements UserContract
{
    public function store(CreateUserData $userData) : User
    {
        return User::create($userData->toArray());
    }

    public function update(User $user, UpdateUserData $userData) : User
    {
        $user->update($userData->toArray());
        return $user;
    }

    public function delete(array $ids) {
        return User::destroy($ids);
    }
}
