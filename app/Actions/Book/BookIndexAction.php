<?php

use App\Http\Requests\BookIndexRequest;
use App\Models\Book;
use App\Http\Controllers\Pagination\Pagination;
use Illuminate\Http\JsonResponse;

class BookIndexAction
{
    public function handle(BookIndexRequest $request): JsonResponse
    {
        $bookQuery = Book::query();
        $queryParam = $request->get('search');

        if($queryParam !== null)
        {
            $bookQuery->where('isbn','=',$queryParam)
            ->orWhere('name','=',$queryParam)
            ->orWhere('authors','=',$queryParam)
            ->orWhere('translators','=',$queryParam);
        }

        $per_page = $request->get('per_page',15);
        $page     = $request->get('page',1);
        $bookQuery= $bookQuery->paginate($per_page,$page);

        return response()->json($bookQuery,200);
    }

}
