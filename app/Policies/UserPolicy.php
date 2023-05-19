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
}
