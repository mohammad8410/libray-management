<?php

namespace App\DataTransferObjects;

use App\Http\Requests\UserScoreUpdateRequest;

class UserScoreUpdateRequestDto
{
    public function __construct(
        public readonly int $newScore,
        public readonly int $id,
    )
    {
    }

    public static function fromRequest(UserScoreUpdateRequest $request,int $id): self
    {
        return new self(
            $request->validated('newScore'),
            $id,
        );
    }
}
