<?php

namespace App\Actions\Book;

use App\Http\Responses\BookResponse;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

class BookDecreaseAction
{
    public function handle(Book $book, int $decCount): JsonResponse
    {
        if ($decCount < $book->number)
        {
            $book->decrement('number',$decCount);

            return new JsonResponse(new BookResponse($book));
        }
        throw new NotAcceptableHttpException();
    }

}
