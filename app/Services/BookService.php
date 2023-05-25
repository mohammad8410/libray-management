<?php

namespace App\Services;

use App\DataTransferObjects\BookCreateRequestDto;
use App\DataTransferObjects\BookIndexRequestDto;
use App\DataTransferObjects\BookUpdateRequestDto;
use App\Exceptions\NotAcceptableException;
use App\Exceptions\NotFoundException;
use App\Models\Book;
use App\Models\BookUser;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    public function store(BookCreateRequestDto $request): Book
    {
        return Book::create([
            'isbn'        => $request->isbn,
            'name'        => $request->name,
            'maximumTime' => $request->maximumTime,
            'authors'     => $request->authors,
            'translators' => $request->translators,
            'year'        => $request->year,
            'number'      => $request->number,
            'pages'       => $request->pages,
            'price'       => $request->price,
            'volume'      => $request->volume,
        ]);
    }

    public function update(BookUpdateRequestDto $request, int $id): Book
    {
        $book = Book::query()->find($id);
        if ($book !== null)
        {
            $book->update([
                'isbn'        => $request->isbn,
                'name'        => $request->name,
                'year'        => $request->year,
                'pages'       => $request->pages,
                'price'       => $request->price,
                'maximumTime' => $request->maximumTime,
                'authors'     => $request->authors,
                'translators' => $request->translators,
                'volume'      => $request->volume,
            ]);

            return $book;
        }

        throw new NotFoundException();
    }

    public function show(int $id): Book
    {
        $book = Book::query()->find($id);
        if ($book !== null) {
            return $book;
        }

        throw new NotFoundException();
    }

    public function delete(int $id): Book
    {
        $book = Book::query()->find($id);
        if($book !== null)
        {
            $book->delete();
            return $book;
        }

        throw new NotFoundException();
    }

    public function increaseStock(int $id, int $incCount): Book
    {
        $book = Book::query()->find($id);
        if($book !== null)
        {
            $book->increment('number', $incCount);

            return $book;
        }

        throw new NotFoundException();
    }

    public function decreaseStock(int $id, int $decCount): Book
    {
        $book = Book::query()->find($id);
        if($book !== null)
        {
            if ($decCount < $book->number) {
                $book->decrement('number', $decCount);

                return $book;
            }

            throw new NotAcceptableException();
        }

        throw new NotFoundException();
    }

    public function borrow(int $id): Book
    {
        $book = Book::query()->find($id);
        if($book !== null)
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

            throw new NotAcceptableException();
        }
        throw new NotFoundException();
    }

    public function returning(int $id): Book
    {
        $book = Book::query()->find($id);
        if ($book !== null)
        {
            $borrowQuery    = BookUser::query()->where('user_id', '=', Auth::user()->id)
                ->where('book_id', '=', $book->id);
            $userHasTheBook = $borrowQuery->exists();

            if ($userHasTheBook) {
                $borrowQuery->delete();
                return $book;
            }

            throw new NotAcceptableException();
        }

        throw new NotFoundException();
    }


}
