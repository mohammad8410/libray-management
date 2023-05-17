<?php

namespace App\Actions\Book;

use App\Http\Requests\BookCreateRequest;
use App\Http\Responses\BookResponse;
use App\Models\Book;
use Illuminate\Http\Response;

class BookCreateAction
{
    public function handle(BookCreateRequest $request): Response
    {
        $book = Book::create([
            'isbn'        => $request->get('isbn'),
            'name'        => $request->get('name'),
            'maximumTime' => $request->get('maximumTime'),
            'authors'     => $request->get('authors'),
            'translators' => $request->get('translators'),
            'year'        => $request->get('year'),
            'number'      => $request->get('number'),
            'pages'       => $request->get('pages'),
            'price'       => $request->get('price'),
            'volume'      => $request->get('volume'),
        ]);

        return response(new BookResponse($book),201);
    }

}
