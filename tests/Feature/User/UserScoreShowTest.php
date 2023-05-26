<?php

namespace Tests\Feature\User;

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
        $expectedScore = 5;
        $user = User::factory()->create();
        $user->givePermissionTo('view own score');
        UserScore::factory($expectedScore)->withUser($user)->create([
            'score' => 1,
        ]);

        $response = $this->actingAs($user)->get(route('user-score.show',[
            'user' => 1,
        ]));

        $response->assertOk();
        $response->assertJson([
            'score' => $expectedScore,
        ]);
    }

    public function test_super_admin_can_view_any_score()
    {
        $expectedScore = 5;
        $admin = User::factory()->create();
        $admin->givePermissionTo('view any score');
        $user  = User::factory()->create();
        $userScore = UserScore::factory($expectedScore)->withUser($user)->create([
            'score' => 1,
        ]);

        $response = $this->actingAs($admin)->get(route('user-score.show',[
            'user' => 2,
        ]));

        $response->assertOk();
        $response->assertJson([
            'score' => $expectedScore,
        ]);
    }

    public function test_unauthorized_user_can_not_view_scores()
    {
        $user = User::factory()->create();
        User::factory()->create();

        $response = $this->actingAs($user)->get(route('user-score.show',[
            'user' => 2,
        ]));

        $response->assertForbidden();
        $response->assertJson([
            'message' => 'unauthorized access.',
        ]);
    }

    public function test_unauthenticated_user_can_not_view_user_score()
    {
        $response = $this->get(route('user-score.show',[
            'user' => 1
        ]));

        $this->assertGuest();
        $response->assertJson([
            'message' => 'unauthenticated user.',
        ]);
    }

    public function test_resource_not_found_for_show_user_score()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view any score');

        $response = $this->actingAs($user)->get(route('user-score.show',[
            'user' => 2,
        ]));

        $response->assertNotFound();
        $response->assertJson([
            'message' => 'resource not found.',
        ]);
    }
}
