<?php

namespace App\Actions\Book;

use App\Http\Responses\BookResponse;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;

class BookDeleteAction
{
    public function handle(Book $book): JsonResponse
    {
        $bookService = new BookService();
        $book        = $bookService->delete($book);

        return new JsonResponse(new BookResponse($book));
    }

}
