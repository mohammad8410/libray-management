<?php

namespace App\Services;


use App\DataTransferObjects\UserScoreIndexRequestDto;
use App\DataTransferObjects\UserScoreUpdateRequestDto;
use App\Exceptions\NotFoundException;
use App\Models\UserScore;
use Illuminate\Pagination\LengthAwarePaginator;

class UserScoreService
{
    public function index(UserScoreIndexRequestDto $dto): LengthAwarePaginator
    {
        $userScoreQuery = UserScore::query();
        $queryParam     = $dto->sort;
        $perPage        = $dto->perPage;
        $page           = $dto->page;

        if ($queryParam !== null)
        {
            if ($queryParam)
            {
                $userScoreQuery->orderBy('score', 'asc');
            }
            else
            {
                $userScoreQuery->orderBy('score', 'desc');
            }
        }

        return $userScoreQuery->paginate(perPage: $perPage, page: $page);
    }

    public function show(int $id): UserScore
    {
        $userScore =  UserScore::query()->find($id);

        if ($userScore !== null)
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
