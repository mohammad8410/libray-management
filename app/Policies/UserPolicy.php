<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function index(User $user): bool
    {
        return $user->can('view any user');
    }

    public function update(User $user): bool
    {
        return $user->can('update own info');
    }

    public function delete(User $user): bool
    {
        return $user->can('delete own account');
    }

    public function showScore(User $user, User $requestedUser): bool
    {
        return $user->can('view any score')
            ||($user->can('view own score')
            && $requestedUser->id == $user->id);
    }

    public function updateScore(User $user): bool
    {
        return $user->can('update user score');
    }
}
