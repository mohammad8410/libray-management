<?php

namespace App\Http\Controllers;

use App\Actions\UserScore\UserScoreIndexAction;
use App\Actions\UserScore\UserScoreShowAction;
use App\Http\Requests\UserScoreIndexRequest;
use App\Models\User;
use App\Models\UserScore;
use Illuminate\Http\Request;

class UserScoreController extends Controller
{
    public function index(UserScoreIndexRequest $request, UserScoreIndexAction $userScoreIndexAction)
    {
        $this->authorize('index',UserScore::class);

        return $userScoreIndexAction->handle($request);
    }

    public function show(UserScore $userScore, UserScoreShowAction $userScoreShowAction)
    {
        $this->authorize('show',$userScore);

        return $userScoreShowAction->handle($userScore);
    }


}
