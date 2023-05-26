<?php

namespace App\Actions\User;

use Illuminate\Http\JsonResponse;

class ShowUserScoreAction
{
    public function handle(int $score): JsonResponse
    {
        return new JsonResponse([
            'score' => $score,
        ]);
    }
}
