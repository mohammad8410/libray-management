<?php

namespace App\Actions\Book;

use App\Http\Responses\BookResponse;
use App\Models\Book;
use App\Models\BookUser;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

class BookBorrowAction
{
    public function handle(Book $book): JsonResponse
    {
        $borrowedBookCount = BookUser::query()->where('book_id','=',$book->id)->count();
        $existedBookCount  = $book->number - $borrowedBookCount;

        if($existedBookCount > 0)
        {
            BookUser::create([
                'user_id' => Auth::user()->id,
                'book_id' => $book->id,
            ]);
            return new JsonResponse(new BookResponse($book));
        }

        throw new NotAcceptableHttpException();
    }

}
