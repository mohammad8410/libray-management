<?php

namespace App\Services;


use App\DataTransferObjects\UserScoreIndexRequestDto;
use App\DataTransferObjects\UserScoreUpdateRequestDto;
use App\Exceptions\NotFoundException;
use App\Models\UserScore;
use Illuminate\Pagination\LengthAwarePaginator;
use function PHPUnit\Framework\isEmpty;

class UserScoreService
{
    public function index(UserScoreIndexRequestDto $dto): LengthAwarePaginator
    {
        $userScoreQuery = UserScore::query()->where('user_id','=',$dto->id);

        if ($userScoreQuery->doesntExist())
        {
            throw new NotFoundException();
        }

        $queryParam     = $dto->sort;
        $perPage        = $dto->perPage;
        $page           = $dto->page;

        if ($queryParam !== null)
        {
            if ($queryParam)
            {
                $userScoreQuery->orderBy('created_at', 'asc');
            }
            else
            {
                $userScoreQuery->orderBy('created_at', 'desc');
            }
        }

        return $userScoreQuery->paginate(perPage: $perPage, page: $page);
    }

    public function show(int $userId): UserScore
    {
        $userScore =  UserScore::query()->where('user_id','=',$userId);

        if (!isEmpty($userScore->get()))
        {
            return $userScore;
        }

        throw new NotFoundException();
    }

    public function update(UserScoreUpdateRequestDto $dto): UserScore
    {
        $userScore = UserScore::query()->find($dto->id);
        if ($userScore !== null)
        {
            $userScore->update([
                'score' => $dto->newScore,
            ]);

            return $userScore;
        }

        throw new NotFoundException();
    }
}
