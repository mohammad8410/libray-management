<?php

namespace App\Actions\Book;

use App\Http\Requests\BookUpdateRequest;
use App\Http\Responses\BookResponse;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\Response;

class BookUpdateAction
{
    public function handle(BookUpdateRequest $request, Book $book): Response
    {
        $bookService = new BookService();
        $book        = $bookService->update($request,$book);

        return response(new BookResponse($book),200);
    }
}
