<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->can('view any book');
    }
    public function store(User $user): bool
    {
        return $user->can('store a book');
    }

    public function update(User $user): bool
    {
        return $user->can('update a book');
    }

    public function show(User $user): bool
    {
        return $user->can('view any book');
    }

    public function delete(User $user): bool
    {
        return $user->can('delete a book');
    }

    public function increase(User $user): bool
    {
        return $user->can('increase book count');
    }

}
