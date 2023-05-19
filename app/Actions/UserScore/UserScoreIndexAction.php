<?php

namespace App\Actions\UserScore;

use App\Http\Controllers\Pagination\Pagination;
use App\Http\Requests\UserScoreIndexRequest;
use App\Http\Responses\UserScoreResponse;
use App\Models\UserScore;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class UserScoreIndexAction
{
    public function handle(UserScoreIndexRequest $request): JsonResponse
    {
        $userScoreQuery = UserScore::query();
        $queryParam = $request->get('sort');

        if ($queryParam !== null)
        {
            if ($queryParam)
            {
                $userScoreQuery->orderBy('score','asc');
            }
            else
            {
                $userScoreQuery->orderBy('score','desc');
            }
        }

        $per_page  = $request->get('per_page', config('pagination.default_page_size', 15));
        $page      = $request->get('page', config('pagination.default_page', 1));
        $userScoreQuery = $userScoreQuery->paginate(perPage: $per_page, page: $page);

        return Response::json(Pagination::fromModelPaginatorAndData(
            $userScoreQuery,
            collect($userScoreQuery->items())->map(fn($item) => new UserScoreResponse($item))->toArray()
        ));
    }
}
