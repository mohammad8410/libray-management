<?php

namespace App\Exceptions;

class NotAcceptableException extends \Exception
{
    public function ErrorMessage(): array
    {
        return [
            'message' => 'not acceptable.',
        ];
    }
}
