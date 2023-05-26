<?php

namespace App\Http\Controllers;

use App\Actions\UserScore\UserScoreIndexAction;
use App\DataTransferObjects\UserScoreIndexRequestDto;
use App\Exceptions\NotFoundException;
use App\Http\Requests\UserScoreIndexRequest;
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

        try
        {
            $response = $this->service->index(UserScoreIndexRequestDto::fromRequest($request));
        }
        catch(NotFoundException $e)
        {
            throw new NotFoundHttpException();
        }

        return $userScoreIndexAction->handle($response);
    }
}
