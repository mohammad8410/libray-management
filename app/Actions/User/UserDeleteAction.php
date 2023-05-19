<?php

namespace App\Actions\User;

use App\Http\Responses\UserResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserDeleteAction
{
    public function handle(): JsonResponse
    {
        $user = Auth::user();
        $user->delete();

        return new JsonResponse(new UserResponse($user),204);
    }

}
