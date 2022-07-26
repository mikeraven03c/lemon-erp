<?php

namespace App\Packages\Users\Contracts;

use App\Packages\Users\Models\User;
use App\Packages\Users\DataTransferObjects\CreateUserData;
use App\Packages\Users\DataTransferObjects\UpdateUserData;

interface UserContract
{
    public function store(CreateUserData $dto);
    public function update(User $user, UpdateUserData $dto);
    public function delete(array $ids);
}
