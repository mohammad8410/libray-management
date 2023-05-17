<?php


namespace App\Http\Controllers;

use App\Actions\Book\BookCreateAction;
use App\Actions\Book\BookIndexAction;
use App\Http\Requests\BookCreateRequest;
use App\Http\Requests\BookIndexRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(BookIndexRequest $request, BookIndexAction $bookIndexAction)
    {
        return $bookIndexAction->handle($request);
    }

    public function store(BookCreateRequest $request, BookCreateAction $bookCreateAction)
    {
        $this->authorize('store',Book::class);

        return $bookCreateAction->handle($request);
    }

}
