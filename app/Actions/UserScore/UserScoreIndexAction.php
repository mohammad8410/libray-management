<?php

namespace App\Actions\UserScore;

use App\Http\Controllers\Pagination\Pagination;
use App\Http\Responses\UserScoreResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Response;

class UserScoreIndexAction
{
    public function handle(LengthAwarePaginator $userScorePaginated): JsonResponse
    {
        return Response::json(Pagination::fromModelPaginatorAndData(
            $userScorePaginated,
            collect($userScorePaginated->items())->map(fn($item) => new UserScoreResponse($item))->toArray()
        ));
    }
}
