<?php

namespace App\DataTransferObjects;

use App\Http\Requests\UserScoreUpdateRequest;

class UserScoreUpdateRequestDto
{
    public function __construct(
        public readonly ?string $description,
        public readonly int $score,
        public readonly int $userId,
    )
    {
    }

    public static function fromRequest(UserScoreUpdateRequest $request,int $userId): self
    {
        return new self(
            $request->validated('description'),
            $request->validated('score'),
            $userId,
        );
    }
}
