<?php

namespace App\Jobs;

use App\Models\Book;
use App\Models\BookUser;
use App\Models\UserScore;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DecreaseScoreForEveryExpiredDay implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = BookUser::query()->select('user_id')->get();
        $users->each(function($user){
            $userBooksId = BookUser::query()->where('user_id','=',$user->user_id)->select('book_id')->get();
            $userBooksId->each(function ($book) use($user){
                $userBook  = Book::query()->where('id','=',$book->book_id)->get();
                $isExpired  = BookUser::query()->whereTime('created_at','<',now()->timestamp - $userBook[0]->maximumTime)
                    ->where('book_id','=',$userBook[0]->id)
                    ->where('user_id','=',$user->user_id)->exists();
                if ($isExpired)
                {
                    $scoreDecreasedAlready =  UserScore::query()->where('user_id','=',$user->user_id)
                                                                ->where('created_at','<',Carbon::yesterday())
                                                                ->where('score','<',0);
                    if ($scoreDecreasedAlready->doesntExist())
                    {
                        UserScore::create([
                            'user_id' => $user->user_id,
                            'score'   => -1,
                            'description' => 'return time expiration',
                        ]);
                    }
                }
            });
        });

    }
}
