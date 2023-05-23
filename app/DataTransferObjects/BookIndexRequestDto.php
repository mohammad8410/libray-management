<?php

namespace App\DataTransferObjects;

use App\Http\Requests\BookIndexRequest;

class BookIndexRequestDto
{
    public function __construct(
        public readonly ?string $search,
        public readonly int $perPage,
        public readonly int $page
    )
    {
    }

    public static function fromRequest(BookIndexRequest $request): BookIndexRequestDto
    {
        return new self(
            $request->validated('search'),
            $request->validated('perPage',config('pagination.default_page_size',15)),
            $request->validated('page',config('pagination.default_page',1)),
        );
    }

}
