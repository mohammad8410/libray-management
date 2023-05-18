<?php

namespace App\Actions\Book;

use App\Http\Responses\BookResponse;
use App\Models\Book;
use Illuminate\Http\JsonResponse;

class BookDecreaseAction
{
    public function handle(Book $book, int $decCount): JsonResponse
    {
        $book->decrement('number',$decCount);

        return new JsonResponse(new BookResponse($book));
    }

}
