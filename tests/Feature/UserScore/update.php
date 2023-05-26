<?php

namespace Tests\Feature\UserScore;

use App\Models\User;
use App\Models\UserScore;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserScoreUpdateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_update_user_score()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('update user score');
        UserScore::factory()->create();


        $response = $this->actingAs($user)->put(route('user-score.update',[
            'userScore' => $user->id,
        ]),[
            'newScore' => 10,
        ]);

        $response->assertOk();
        $this->assertDatabaseHas(UserScore::class,[
            'score' => 10,
        ]);
    }

    public function test_unauthorized_user_can_not_update_score()
    {
        $user = User::factory()->create();
        UserScore::factory()->withUser($user)->create();

        $response = $this->actingAs($user)->put(route('user-score.update',[
            'userScore' => 1
        ]),[
            'newScore' => 10,
        ]);

        $response->assertForbidden();
        $response->assertJson([
            'message' => 'unauthorized access.',
        ]);
    }

    public function test_unauthenticated_user_can_not_update_score()
    {
        $response = $this->put(route('user-score.update',[
            'userScore' => 1,
        ]),[
            'newScore' => 1,
        ]);

        $this->assertGuest();
        $response->assertJson([
            'message' => 'unauthenticated user.',
        ]);
    }

    public function test_resource_not_found_for_score_update()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('update user score');
        $response = $this->actingAs($user)->put(route('user-score.update',[
            'userScore' => 10,
        ]),[
            'newScore' => 1,
        ]);

        $response->assertNotFound();
        $response->assertJson([
            'message' => 'resource not found.',
        ]);
    }
}
