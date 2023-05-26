<?php

namespace App\Http\Controllers;

use App\Actions\User\ShowUserScoreAction;
use App\Actions\User\UpdateUserScoreAction;
use App\Actions\User\UserDeleteAction;
use App\Actions\User\UserIndexAction;
use App\Actions\User\UserUpdateAction;
use App\DataTransferObjects\UserScoreUpdateRequestDto;
use App\DataTransferObjects\UserUpdateRequestDto;
use App\Exceptions\NotFoundException;
use App\Http\Requests\UserIndexRequest;
use App\Http\Requests\UserScoreUpdateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    protected UserService $userService;
    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function index(UserIndexRequest $request, UserIndexAction $userIndexAction)
    {
        $userId = Auth::user()->can('view any user')? $request->get('id') : Auth::user()->id;

        try
        {
            $response = $this->userService->index($userId);
        }
        catch (NotFoundException $e)
        {
            throw new NotFoundHttpException();
        }

        return $userIndexAction->handle($response);
    }

    public function update(UserUpdateRequest $request, UserUpdateAction $userUpdateAction)
    {
        $this->authorize('update', User::class);

        try
        {
            $response = $this->userService->update(UserUpdateRequestDto::fromRequest(Auth::user()->id,$request));
        }
        catch(NotFoundException $e)
        {
            throw new NotFoundHttpException();
        }

        return $userUpdateAction->handle($response);
    }

    public function delete(UserDeleteAction $userDeleteAction)
    {
        $this->authorize('delete', User::class);

        try
        {
            $response = $this->userService->delete(Auth::user()->id);
        }
        catch(NotFoundException $e)
        {
            throw new NotFoundHttpException();
        }

        return $userDeleteAction->handle($response);
    }

    public function showScore(User $user,ShowUserScoreAction $showUserScoreAction)
    {
        $this->authorize('showScore',$user);

        try
        {
            $response = $this->userService->showScore($user->id);
        }
        catch (NotFoundException $e)
        {
            throw new NotFoundHttpException();
        }

        return $showUserScoreAction->handle($response);
    }

    public function updateScore(int $id,UserScoreUpdateRequest $request, UpdateUserScoreAction $updateUserScoreAction)
    {
        $this->authorize('updateScore',User::class);

        try
        {
            $response = $this->userService->updateScore(UserScoreUpdateRequestDto::fromRequest($request,$id));
        }
        catch(NotFoundException $e)
        {
            throw new NotFoundHttpException();
        }

        return $updateUserScoreAction->handle($response);
    }
}
