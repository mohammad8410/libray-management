<?php

namespace App\Http\Responses;

use App\Models\UserScore;

class UserScoreResponse extends \Spatie\LaravelData\Data
{
    public int $score;
    public int $user_id;
    public ?string $description;

    public function __construct(UserScore $userScore)
    {
        $this->score  = $userScore->score;
        $this->user_id = $userScore->user_id;
        $this->description = $userScore->description;
    }
}
