<?php

namespace App\Actions\User;

use App\Http\Controllers\Pagination\Pagination;
use App\Http\Requests\UserIndexRequest;
use App\Http\Responses\BookResponse;
use App\Http\Responses\UserResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class UserIndexAction
{
    public function handle(UserIndexRequest $request): JsonResponse
    {
        $userQuery  = User::query();

        $per_page  = $request->get('per_page', config('pagination.default_page_size', 15));
        $page      = $request->get('page', config('pagination.default_page', 1));
        $userQuery = $userQuery->paginate(perPage: $per_page, page: $page);

        return Response::json(Pagination::fromModelPaginatorAndData(
            $userQuery,
            collect($userQuery->items())->map(fn($item) => new UserResponse($item))->toArray()
        ));
    }
}
