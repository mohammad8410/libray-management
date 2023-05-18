<?php

namespace App\Actions\Book;

use App\Http\Responses\BookResponse;
use App\Models\Book;
use App\Models\BookUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

class BookReturnAction
{
    public function handle(Book $book): JsonResponse
    {
        $borrowQuery     = BookUser::query()->where('user_id','=',Auth::user()->id)
                                            ->where('book_id','=',$book->id);
        $userHasTheBook  = $borrowQuery->exists();

        if ($userHasTheBook)
        {
            $borrowQuery->delete();
            return new JsonResponse(new BookResponse($book));
        }

        throw new NotAcceptableHttpException();
    }
}
