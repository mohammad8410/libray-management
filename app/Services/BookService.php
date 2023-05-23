<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Collection;

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

}
