<?php

namespace App\DataTransferObjects;

use App\Http\Requests\BookCreateRequest;

class BookCreateRequestDto
{
    public function __construct(
            public readonly string $isbn,
            public readonly int $maximumTime,
            public readonly string $name,
            public readonly array $authors,
            public readonly ?array $translators,
            public readonly int $year,
            public readonly int $volume,
            public readonly int $pages,
            public readonly int $price,
            public readonly int $number,
    )
    {
    }
    public static function fromRequest(BookCreateRequest $request): BookCreateRequestDto
    {
        return new self(
            $request->validated('isbn'),
            $request->validated('maximumTime'),
            $request->validated('name'),
            $request->validated('authors'),
            $request->validated('translators'),
            $request->validated('year'),
            $request->validated('volume'),
            $request->validated('pages'),
            $request->validated('price'),
            $request->validated('number'),
        );
    }
}
