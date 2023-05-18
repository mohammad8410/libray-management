<?php


namespace App\Http\Controllers;

use App\Actions\Book\BookCreateAction;
use App\Actions\Book\BookIndexAction;
use App\Actions\Book\BookShowAction;
use App\Actions\Book\BookUpdateAction;
use App\Http\Requests\BookCreateRequest;
use App\Http\Requests\BookIndexRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(BookIndexRequest $request, BookIndexAction $bookIndexAction)
    {
        $this->authorize('index', Book::class);

        return $bookIndexAction->handle($request);
    }

    public function store(BookCreateRequest $request, BookCreateAction $bookCreateAction)
    {
        $this->authorize('store',Book::class);

        return $bookCreateAction->handle($request);
    }

    public function update(BookUpdateRequest $request, Book $book, BookUpdateAction $bookUpdateAction)
    {
        $this->authorize('update',Book::class);

        return $bookUpdateAction->handle($request, $book);
    }

    public function show(Book $book, BookShowAction $bookShowAction)
    {
        $this->authorize('show', Book::class);

        return $bookShowAction->handle($book);
    }

}
