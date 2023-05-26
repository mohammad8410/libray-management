<?php

namespace App\DataTransferObjects;

use App\Http\Requests\UserScoreIndexRequest;

class UserScoreIndexRequestDto
{
    public function __construct(
        public readonly int $id,
        public readonly ?bool $sort,
        public readonly int $perPage,
        public readonly int $page,
    )
    {
    }

    public static function fromRequest(UserScoreIndexRequest $request): self
    {
        return new self(
            $request->validated('id'),
            $request->validated('sort'),
            $request->validated('perPage',config('pagination.default_page_size',15)),
            $request->validated('page',config('pagination.default_page',1)),
        );
    }
}
