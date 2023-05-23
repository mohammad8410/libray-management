<?php

namespace App\Services;

use App\Http\Requests\BookCreateRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Http\Responses\BookResponse;
use App\Models\Book;
use App\Models\BookUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

class BookService
{
    public function index(Request $request)
    {
        $bookQuery  = Book::query();
        $queryParam = $request->get('search');

        if ($queryParam !== null) {
            $bookQuery->where('isbn', '=', $queryParam)
                ->orWhere('name', '=', $queryParam)
                ->orWhere('authors', '=', $queryParam)
                ->orWhere('translators', '=', $queryParam);
        }

        $per_page  = $request->get('per_page', config('pagination.default_page_size', 15));
        $page      = $request->get('page', config('pagination.default_page', 1));

        return $bookQuery->paginate(perPage: $per_page, page: $page);
    }

    public function store(BookCreateRequest $request)
    {
        return Book::create([
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
    }

    public function update(BookUpdateRequest $request, Book $book)
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

        return $book;
    }

    public function show(Book $book)
    {
        return $book;
    }

    public function delete(Book $book)
    {
        $book->delete();

        return $book;
    }

    public function increase(Book $book, int $incCount)
    {
        $book->increment('number',$incCount);

        return $book;
    }

    public function decrease(Book $book, int $decCount)
    {
        if ($decCount < $book->number)
        {
            $book->decrement('number',$decCount);

            return $book;
        }
        throw new NotAcceptableHttpException();
    }

    public function borrow(Book $book)
    {
        $borrowedBookCount = BookUser::query()->where('book_id','=',$book->id)->count();
        $existedBookCount  = $book->number - $borrowedBookCount;

        if($existedBookCount > 0)
        {
            BookUser::create([
                'user_id' => Auth::user()->id,
                'book_id' => $book->id,
            ]);
            return $book;
        }

        throw new NotAcceptableHttpException();
    }


}
