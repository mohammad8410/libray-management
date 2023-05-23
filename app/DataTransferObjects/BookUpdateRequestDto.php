<?php

namespace App\DataTransferObjects;

use App\Http\Requests\BookUpdateRequest;

class BookUpdateRequestDto
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
    )
    {
    }
    public static function fromRequest(BookUpdateRequest $request): BookUpdateRequestDto
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
        );
    }

}
