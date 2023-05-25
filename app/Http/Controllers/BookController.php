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
use App\DataTransferObjects\BookCreateRequestDto;
use App\DataTransferObjects\BookUpdateRequestDto;
use App\Exceptions\NotFoundException;
use App\Http\Requests\BookCreateRequest;
use App\Http\Requests\BookIndexRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Models\Book;
use App\Services\BookService;
use App\DataTransferObjects\BookIndexRequestDto;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        $response = $this->bookService->index(BookIndexRequestDto::fromRequest($request));

        return $bookIndexAction->handle($response);
    }

    public function store(BookCreateRequest $request, BookCreateAction $bookCreateAction)
    {
        $this->authorize('store',Book::class);

        $response = $this->bookService->store(BookCreateRequestDto::fromRequest($request));

        return $bookCreateAction->handle($response);
    }

    public function update(BookUpdateRequest $request, int $id, BookUpdateAction $bookUpdateAction)
    {
        $this->authorize('update',Book::class);

        try
        {
            $response = $this->bookService->update(BookUpdateRequestDto::fromRequest($request),$id);
        }
        catch(NotFoundException $e)
        {
            throw new NotFoundHttpException();
        }

        return $bookUpdateAction->handle($response);
    }

    public function show(int $id, BookShowAction $bookShowAction)
    {
        $this->authorize('show', Book::class);

        try
        {
            $response = $this->bookService->show($id);
        }
        catch(NotFoundException $e)
        {
            throw new NotFoundHttpException();
        }

        return $bookShowAction->handle($response);
    }

    public function delete(int $id, BookDeleteAction $bookDeleteAction)
    {
        $this->authorize('delete', Book::class);

        $response = $this->bookService->delete($id);

        return $bookDeleteAction->handle($response);
    }

    public function increase(int $id, int $incCount, BookIncreaseAction $bookIncreaseAction)
    {
        $this->authorize('increase',Book::class);

        $response = $this->bookService->increaseStock($id,$incCount);

        return $bookIncreaseAction->handle($response);
    }

    public function decrease(int $id, int $decCount, BookDecreaseAction $bookDecreaseAction)
    {
        $this->authorize('decrease',Book::class);

        $response = $this->bookService->decreaseStock($id,$decCount);

        return $bookDecreaseAction->handle($response);
    }

    public function borrow(int $id, BookBorrowAction $bookBorrowAction)
    {
        $this->authorize('borrow',Book::class);

        $response = $this->bookService->borrow($id);

        return $bookBorrowAction->handle($response);
    }

    public function returning(int $id, BookReturnAction $bookReturnAction)
    {
        $this->authorize('returning',Book::class);

        $response = $this->bookService->returning($id);

        return $bookReturnAction->handle($response);
    }
}
