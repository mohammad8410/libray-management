<?php

namespace App\Actions\Book;

use App\Http\Responses\BookResponse;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;

class BookDecreaseAction
{
    public function handle(Book $book, int $decCount): JsonResponse
    {
        $bookService = new BookService();
        $book        = $bookService->decrease($book, $decCount);

        return new JsonResponse(new BookResponse($book));
    }
}
