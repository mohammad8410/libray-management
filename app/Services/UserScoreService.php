<?php

namespace App\Services;


use App\DataTransferObjects\UserScoreIndexRequestDto;
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
}
