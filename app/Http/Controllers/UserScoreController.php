<?php

namespace App\Http\Controllers;

use App\Actions\UserScore\UserScoreIndexAction;
use App\Actions\UserScore\UserScoreShowAction;
use App\Actions\UserScore\UserScoreUpdateAction;
use App\DataTransferObjects\UserScoreIndexRequestDto;
use App\DataTransferObjects\UserScoreUpdateRequestDto;
use App\Exceptions\NotFoundException;
use App\Http\Requests\UserScoreIndexRequest;
use App\Http\Requests\UserScoreUpdateRequest;
use App\Models\UserScore;
use App\Services\UserScoreService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        try
        {
            $response = $this->service->show($userScore->id);
        }
        catch(NotFoundException $e)
        {
            throw new NotFoundHttpException();
        }

        return $userScoreShowAction->handle($response);
    }

    public function update(UserScoreUpdateRequest $request, int $userScore, UserScoreUpdateAction $userScoreUpdateAction)
    {
        $this->authorize('update',UserScore::class);

        try
        {
            $response = $this->service->update(UserScoreUpdateRequestDto::fromRequest($request,$userScore));
        }
        catch(NotFoundException $e)
        {
            throw new NotFoundHttpException();
        }

        return $userScoreUpdateAction->handle($response);
    }


}
