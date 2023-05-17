<?php

namespace App\Actions\Book;

use App\Http\Requests\BookUpdateRequest;
use App\Http\Responses\BookResponse;
use App\Models\Book;
use Illuminate\Http\Response;

class BookUpdateAction
{
    public function handle(BookUpdateRequest $request, Book $book): Response
    {
        $book->update([
            'isbn'        => $request->get('isbn'),
            'name'        => $request->get('name'),
            'year'        => $request->get('year'),
            'pages'       => $request->get('pages'),
            'price'       => $request->get('price'),
            'maximumTime' => $request->get('maximumTime'),
            'authors'     => $request->get('authors'),
            'translators' => $request->get('translators'),
            'volume'      => $request->get('volume'),
        ]);

        return response(new BookResponse($book),200);
    }

}
