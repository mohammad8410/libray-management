<?php

namespace App\Actions\UserScore;

use App\Http\Requests\UserScoreUpdateRequest;
use App\Http\Responses\UserScoreResponse;
use App\Models\UserScore;
use Illuminate\Http\JsonResponse;

class UserScoreUpdateAction
{
    public function handle(UserScoreUpdateRequest $request,UserScore $userScore): JsonResponse
    {
        $userScore->update([
            'score' => $request->get('newScore'),
        ]);

        return new JsonResponse(new UserScoreResponse($userScore));
    }

}
