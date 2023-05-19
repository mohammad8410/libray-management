<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserScorePolicy
{
    use HandlesAuthorization;

    public function index(User $user): bool
    {
        return $user->can('view any score');
    }
}
