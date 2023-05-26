<?php

namespace Tests\Feature\User;

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
        UserScore::factory()->withUser($user)->create([
            'score' => 5,
        ]);


        $response = $this->actingAs($user)->put(route('user-score.update',[
            'user' => $user->id,
        ]),[
            'score' => -10,
        ]);

        $response->assertOk();
        $response->assertJson([
            'score' => -5,
        ]);
    }

    public function test_unauthorized_user_can_not_update_scores()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('user-score.update',[
            'user' => 1,
        ]),[
            'score' => 10,
        ]);

        $response->assertForbidden();
        $response->assertJson([
            'message' => 'unauthorized access.',
        ]);
    }

    public function test_unauthenticated_user_can_not_update_scores()
    {
        $response = $this->put(route('user-score.update',[
            'user' => 1,
        ]),[
            'score' => 10
        ]);

        $this->assertGuest();
        $response->assertJson([
            'message' => 'unauthenticated user.',
        ]);
    }

    public function test_resource_not_found_for_update()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('update user score');

        $response = $this->actingAs($user)->put(route('user-score.update',[
            'user' => 2,
        ]),[
            'score' => 10,
        ]);

        $response->assertNotFound();
        $response->assertJson([
            'message' => 'resource not found.',
        ]);
    }
}
