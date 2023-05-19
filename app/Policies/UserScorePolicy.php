<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserScore;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserScorePolicy
{
    use HandlesAuthorization;

    public function index(User $user): bool
    {
        return $user->can('view any score');
    }

    public function show(User $user, UserScore $userScore): bool
    {
        return $user->can('view any score')
           || ($user->can('view own score')
            && $user->id == $userScore->user_id);
    }

    public function update(User $user): bool
    {
        return $user->can('update user score');
    }
}
