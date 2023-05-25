<?php

namespace App\Exceptions;

class NotFoundException extends \Exception
{
    public function ErrorMessage(): array
    {
        return [
            'message' => 'resource not found.',
        ];
    }
}
