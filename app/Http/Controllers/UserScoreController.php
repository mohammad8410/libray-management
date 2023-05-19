<?php

namespace App\Http\Controllers;

use App\Actions\UserScore\UserScoreIndexAction;
use App\Http\Requests\UserScoreIndexRequest;
use App\Models\UserScore;
use Illuminate\Http\Request;

class UserScoreController extends Controller
{
    public function index(UserScoreIndexRequest $request, UserScoreIndexAction $userScoreIndexAction)
    {
        $this->authorize('index',UserScore::class);

        return $userScoreIndexAction->handle($request);
    }
}
