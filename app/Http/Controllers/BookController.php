<?php


namespace App\Http\Controllers;

use App\Actions\Book\BookBorrowAction;
use App\Actions\Book\BookCreateAction;
use App\Actions\Book\BookDecreaseAction;
use App\Actions\Book\BookDeleteAction;
use App\Actions\Book\BookIncreaseAction;
use App\Actions\Book\BookIndexAction;
use App\Actions\Book\BookReturnAction;
use App\Actions\Book\BookShowAction;
use App\Actions\Book\BookUpdateAction;
use App\Http\Requests\BookCreateRequest;
use App\Http\Requests\BookIndexRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Models\Book;
use App\Services\BookService;

class BookController extends Controller
{
    protected BookService $bookService;

    public function __construct()
    {
        $this->bookService = new BookService();
    }

    public function index(BookIndexRequest $request, BookIndexAction $bookIndexAction)
    {
        $this->authorize('index', Book::class);

        $response = $this->bookService->index($request);

        return $bookIndexAction->handle($response);
    }

    public function store(BookCreateRequest $request, BookCreateAction $bookCreateAction)
    {
        $this->authorize('store',Book::class);

        $response = $this->bookService->store($request);

        return $bookCreateAction->handle($response);
    }

    public function update(BookUpdateRequest $request, Book $book, BookUpdateAction $bookUpdateAction)
    {
        $this->authorize('update',Book::class);

        $response = $this->bookService->update($request,$book);

        return $bookUpdateAction->handle($response);
    }

    public function show(Book $book, BookShowAction $bookShowAction)
    {
        $this->authorize('show', Book::class);

        $response = $this->bookService->show($book);

        return $bookShowAction->handle($response);
    }

    public function delete(Book $book, BookDeleteAction $bookDeleteAction)
    {
        $this->authorize('delete', Book::class);

        $response = $this->bookService->delete($book);

        return $bookDeleteAction->handle($response);
    }

    public function increase(Book $book, int $incCount, BookIncreaseAction $bookIncreaseAction)
    {
        $this->authorize('increase',Book::class);

        $response = $this->bookService->increase($book,$incCount);

        return $bookIncreaseAction->handle($response);
    }

    public function decrease(Book $book, int $decCount, BookDecreaseAction $bookDecreaseAction)
    {
        $this->authorize('decrease',Book::class);

        $response = $this->bookService->decrease($book,$decCount);

        return $bookDecreaseAction->handle($response);
    }

    public function borrow(Book $book, BookBorrowAction $bookBorrowAction)
    {
        $this->authorize('borrow',Book::class);

        $response = $this->bookService->borrow($book);

        return $bookBorrowAction->handle($response);
    }

    public function returning(Book $book, BookReturnAction $bookReturnAction)
    {
        $this->authorize('returning',Book::class);

        $response = $this->bookService->returning($book);

        return $bookReturnAction->handle($response);
    }
}
