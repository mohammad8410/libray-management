<?php

namespace App\Actions\UserScore;

use App\Http\Requests\UserScoreUpdateRequest;
use App\Http\Responses\UserScoreResponse;
use App\Models\UserScore;
use Illuminate\Http\JsonResponse;

class UserScoreUpdateAction
{
    public function handle(UserScore $userScore): JsonResponse
    {
        return new JsonResponse(new UserScoreResponse($userScore));
    }

}
