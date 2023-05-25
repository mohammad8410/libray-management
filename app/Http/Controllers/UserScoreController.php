<?php

namespace App\Http\Controllers;

use App\Actions\UserScore\UserScoreIndexAction;
use App\Actions\UserScore\UserScoreShowAction;
use App\Actions\UserScore\UserScoreUpdateAction;
use App\DataTransferObjects\UserScoreIndexRequestDto;
use App\Http\Requests\UserScoreIndexRequest;
use App\Http\Requests\UserScoreUpdateRequest;
use App\Models\UserScore;
use App\Services\UserScoreService;

class UserScoreController extends Controller
{
    protected UserScoreService $service;

    public function __construct()
    {
        $this->service = new UserScoreService();
    }

    public function index(UserScoreIndexRequest $request, UserScoreIndexAction $userScoreIndexAction)
    {
        $this->authorize('index',UserScore::class);

        $response = $this->service->index(UserScoreIndexRequestDto::fromRequest($request));

        return $userScoreIndexAction->handle($response);
    }

    public function show(UserScore $userScore, UserScoreShowAction $userScoreShowAction)
    {
        $this->authorize('show',$userScore);

        return $userScoreShowAction->handle($userScore);
    }

    public function update(UserScoreUpdateRequest $request, UserScore $userScore, UserScoreUpdateAction $userScoreUpdateAction)
    {
        $this->authorize('update',UserScore::class);

        return $userScoreUpdateAction->handle($request,$userScore);
    }


}
