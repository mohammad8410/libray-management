<?php

namespace App\Actions\User;

use App\Http\Responses\UserResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserIndexAction
{
    public function handle(int $userId): JsonResponse
    {
        $user = User::query()->where('id','=',$userId)->first();

        if ($user === null)
        {
            throw new NotFoundHttpException();
        }

        return new JsonResponse(new UserResponse($user));
    }
}
