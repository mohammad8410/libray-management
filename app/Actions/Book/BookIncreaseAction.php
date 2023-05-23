<?php

namespace App\Actions\Book;



use App\Http\Responses\BookResponse;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;

class BookIncreaseAction
{
    public function handle(Book $book, int $incCount): JsonResponse
    {
        $bookService = new BookService();
        $book        = $bookService->increase($book,$incCount);

        return new JsonResponse(new BookResponse($book));
    }
}
