<?php

namespace App\DataTransferObjects;

use App\Http\Requests\UserUpdateRequest;

class UserUpdateRequestDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
    )
    {
    }

    public static function fromRequest(int $userId,UserUpdateRequest $request): self
    {
        return new self(
            $userId,
            $request->validated('name'),
        );
    }
}
