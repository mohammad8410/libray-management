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
}
