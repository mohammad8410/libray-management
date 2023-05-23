<?php

namespace App\Services;

use App\DataTransferObjects\BookIndexRequestDto;
use App\Http\Requests\BookCreateRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Models\Book;
use App\Models\BookUser;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

class BookService
{
    public function index(BookIndexRequestDto $dto): LengthAwarePaginator
    {
        $bookQuery = Book::query();

        if ($dto->search !== null) {
            $bookQuery->where('isbn', '=', $dto->search)
                ->orWhere('name', '=', $dto->search)
                ->orWhere('authors', '=', $dto->search)
                ->orWhere('translators', '=', $dto->search);
        }

        return $bookQuery->paginate(perPage: $dto->perPage, page: $dto->page);
    }

    public function store(BookCreateRequest $request): Book
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

    public function update(BookUpdateRequest $request, Book $book): Book
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

    public function show(Book $book): Book
    {
        return $book;
    }

    public function delete(Book $book): Book
    {
        $book->delete();

        return $book;
    }

    public function increaseStock(Book $book, int $incCount): Book
    {
        $book->increment('number', $incCount);

        return $book;
    }

    public function decreaseStock(Book $book, int $decCount): Book
    {
        if ($decCount < $book->number) {
            $book->decrement('number', $decCount);

            return $book;
        }
        throw new NotAcceptableHttpException();
    }

    public function borrow(Book $book): Book
    {
        $borrowedBookCount = BookUser::query()->where('book_id', '=', $book->id)->count();
        $existedBookCount  = $book->number - $borrowedBookCount;

        if ($existedBookCount > 0) {
            BookUser::create([
                'user_id' => Auth::user()->id,
                'book_id' => $book->id,
            ]);
            return $book;
        }

        throw new NotAcceptableHttpException();
    }

    public function returning(Book $book): Book
    {
        $borrowQuery    = BookUser::query()->where('user_id', '=', Auth::user()->id)
            ->where('book_id', '=', $book->id);
        $userHasTheBook = $borrowQuery->exists();

        if ($userHasTheBook) {
            $borrowQuery->delete();
            return $book;
        }
        throw new NotAcceptableHttpException();
    }


}
