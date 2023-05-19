<?php

namespace App\Actions\UserScore;

use App\Http\Responses\UserScoreResponse;
use App\Models\User;
use App\Models\UserScore;
use Illuminate\Http\JsonResponse;

class UserScoreShowAction
{
    public function handle(UserScore $userScore): JsonResponse
    {
        return new JsonResponse(new UserScoreResponse($userScore));
    }
}
