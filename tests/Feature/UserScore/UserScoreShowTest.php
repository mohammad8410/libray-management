<?php

namespace Tests\Feature\UserScore;

use App\Models\User;
use App\Models\UserScore;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserScoreShowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_show_user_score()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view own score');
        $score = UserScore::factory()->withUser($user)->create();

        $response = $this->actingAs($user)->get(route('user-score.show',[
            'userScore' => 1,
        ]));

        $response->assertOk();
        $response->assertJson([
            'score' => $score->score,
            'user_id' => $user->id,
        ]);
    }

    public function test_unauthorized_access_to_user_score()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view own score');
        UserScore::factory()->withUser($user)->create();
        UserScore::factory()->create();

        $response = $this->actingAs($user)->get(route('user-score.show',[
            'userScore' => 2,
        ]));

        $response->assertForbidden();
        $response->assertJson([
            'message' => 'unauthorized access.',
        ]);
    }

    public function test_unauthenticated_user_can_not_see_score()
    {
        $response = $this->get(route('user-score.show',[
            'userScore' => 1,
        ]));

        $this->assertGuest();
        $response->assertJson([
            'message' => 'unauthenticated user.'
        ]);
    }

    public function test_resource_not_found_for_show_score()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view any score');

        $response = $this->actingAs($user)->get(route('user-score.show',[
            'userScore' => 2,
        ]));

        $response->assertNotFound();
        $response->assertJson([
            'message' => 'resource not found.',
        ]);
    }
}
