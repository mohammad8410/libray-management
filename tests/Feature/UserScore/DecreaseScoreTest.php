<?php

namespace Tests\Feature\UserScore;

use App\Jobs\DecreaseScoreForEveryExpiredDay;
use App\Models\Book;
use App\Models\BookUser;
use App\Models\User;
use App\Models\UserScore;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DecreaseScoreTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_score_decrease_for_expired_borrows()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view own score');
        $book = Book::factory()->create([
            'maximumTime' => 7*24*60*60,
        ]);
        BookUser::factory()->withUser($user)->withBook($book)->create([
            'created_at' => new Carbon('first day of last month'),
        ]);

        DecreaseScoreForEveryExpiredDay::dispatch();
        $this->assertDatabaseHas(UserScore::class,[
            'score' => -1,
        ]);
        DecreaseScoreForEveryExpiredDay::dispatch();
        $response = $this->actingAs($user)->get(route('user-score.show',[
            'user' => 1
        ]));

        $response->assertOk();
        $response->assertJson([
            'score' => -2,
        ]);
    }

    public function test_score_decrease_for_unexpired_borrows()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view own score');
        $book = Book::factory()->create([
            'maximumTime' => 7*24*60*60,
        ]);
        BookUser::factory()->withUser($user)->withBook($book)->create([
            'created_at' => Carbon::yesterday(),
        ]);

        DecreaseScoreForEveryExpiredDay::dispatch();
        $this->assertDatabaseMissing(UserScore::class,[
            'score' => -1,
        ]);
        $response = $this->actingAs($user)->get(route('user-score.show',[
            'user' => 1,
        ]));

        $response->assertOk();
        $response->assertJson([
            'score' => 0,
        ]);
    }
}
