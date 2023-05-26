<?php

namespace App\Services;

use App\DataTransferObjects\UserScoreUpdateRequestDto;
use App\DataTransferObjects\UserUpdateRequestDto;
use App\Exceptions\NotFoundException;
use App\Models\User;
use App\Models\UserScore;

class UserService
{
    public function index(int $id): User
    {
        $user = User::query()->find($id);

        if ($user !== null) {
            return $user;
        }

        throw new NotFoundException();
    }

    public function update(UserUpdateRequestDto $dto): User
    {
        $user = User::query()->find($dto->id);
        if ($user !== null) {
            $user->update([
                'name' => $dto->name,
            ]);

            return $user;
        }

        throw new NotFoundException();
    }

    public function delete(int $id): User
    {
        $user = User::query()->find($id);
        if ($user !== null) {
            $user->delete();
            return $user;
        }

        throw new NotFoundException();
    }

    public function showScore(int $userId): int
    {
        $userScore = UserScore::query()->where('user_id', '=', $userId);

        if ($userScore->exists()) {
            return $userScore->sum('score');
        }

        throw new NotFoundException();
    }

    public function updateScore(UserScoreUpdateRequestDto $dto): int
    {
        $user = User::query()->find($dto->userId);
        if ($user !== null) {
            UserScore::create([
                'user_id'     => $dto->userId,
                'score'       => $dto->score,
                'description' => $dto->description,
            ]);

            return UserScore::query()->where('user_id', '=', $dto->userId)->sum('score');
        }

        throw new NotFoundException();
    }
}
