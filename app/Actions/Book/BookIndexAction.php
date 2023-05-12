<?php

namespace App\Actions\Book;

use App\Http\Controllers\Pagination\Pagination;
use App\Http\Requests\BookIndexRequest;
use App\Http\Responses\BookResponse;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class BookIndexAction
{
    public function handle(BookIndexRequest $request): JsonResponse
    {
        $bookQuery  = Book::query();
        $queryParam = $request->get('search');

        if ($queryParam !== null) {
            $bookQuery->where('isbn', '=', $queryParam)
                ->orWhere('name', '=', $queryParam)
                ->orWhere('authors', '=', $queryParam)
                ->orWhere('translators', '=', $queryParam);
        }

        $per_page  = $request->get('per_page', 5);
        $page      = $request->get('page', 1);
        $bookQuery = $bookQuery->paginate(perPage: $per_page, page: $page);

        return Response::json(Pagination::fromModelPaginatorAndData(
            $bookQuery,
            collect($bookQuery->items())->map(fn($item) => new BookResponse($item))->toArray()
        ));
    }

}
