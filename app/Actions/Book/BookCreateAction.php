<?php

namespace App\Actions\Book;

use App\Http\Requests\BookCreateRequest;
use App\Http\Responses\BookResponse;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;

class BookCreateAction
{
    public function handle(BookCreateRequest $request): JsonResponse
    {
        $bookService = new BookService();
        $book        = $bookService->store($request);

        return new JsonResponse(new BookResponse($book),201);
    }

}
