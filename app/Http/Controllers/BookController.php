<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookIndexRequest;
use BookIndexAction;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(BookIndexRequest $request, BookIndexAction $bookIndexAction)
    {
        return $bookIndexAction->handle($request);
    }
}
