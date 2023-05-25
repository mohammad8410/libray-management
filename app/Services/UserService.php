<?php

namespace App\Services;

use App\DataTransferObjects\UserUpdateRequestDto;
use App\Exceptions\NotFoundException;
use App\Http\Requests\UserUpdateRequest;
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

    public function update(UserUpdateRequestDto $dto)
    {
        $user = User::query()->find($dto->id);
        if($user !== null)
        {
            $user->update([
                'name' => $dto->name,
            ]);

            return $user;
        }

        throw new NotFoundException();
    }
}
