<?php

namespace App\Actions\Book;

use App\Http\Controllers\Pagination\Pagination;
use App\Http\Requests\BookIndexRequest;
use App\Http\Responses\BookResponse;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class BookIndexAction
{
    public function handle(BookIndexRequest $request): JsonResponse
    {
        $bookService    = new BookService();
        $paginatedBooks = $bookService->index($request);

        return Response::json(Pagination::fromModelPaginatorAndData(
            $paginatedBooks,
            collect($paginatedBooks->items())->map(fn($item) => new BookResponse($item))->toArray()
        ));
    }

}
