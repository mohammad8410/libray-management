<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookPolicy
{
    use HandlesAuthorization;

    public function store(User $user): bool
    {
        return $user->can('store a book');
    }

    public function update(User $user): bool
    {
        return $user->can('update a book');
    }
}
