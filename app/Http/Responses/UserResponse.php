<?php

namespace App\Http\Responses;

use App\Models\User;

class UserResponse extends \Spatie\LaravelData\Data
{
    public int $id;
    public string $name;
    public string $email;

    public function __construct(User $user)
    {
        $this->id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
    }

}
