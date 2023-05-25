<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\User;

class UserService
{
    public function index(int $id): User
    {
        $user = User::query()->find($id);

        if ($user !== null)
        {
            return $user;
        }

        throw new NotFoundException();
    }
}
