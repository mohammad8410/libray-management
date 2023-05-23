<?php

namespace App\Actions\Book;

use App\Http\Controllers\Pagination\Pagination;
use App\Http\Responses\BookResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class BookIndexAction
{
    public function handle(LengthAwarePaginator $response): JsonResponse
    {
        return Response::json(Pagination::fromModelPaginatorAndData(
            $response,
            collect($response->items())->map(fn($item) => new BookResponse($item))->toArray()
        ));
    }

}
