<?php

namespace Tests\Feature\UserScore;

use App\Models\User;
use App\Models\UserScore;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserScoreIndexTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_index_user_scores()
    {
        $expectedCount = config('pagination.default_page_size');
        $user = User::factory()->create();
        $user->givePermissionTo('view any score');
        UserScore::factory()->withUser($user)->create();
        UserScore::factory($expectedCount)->create();


        $response = $this->actingAs($user)->get(route('user-scores.index',[
            'sort' => 1, //asc
            'per_page' => $expectedCount,
            'page' => 1,
        ]));

        $response->assertOk();
        $response->assertJsonStructure(
            [
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next'
                ],
                'data' => [
                    [
                        'score',
                        'user_id',
                    ]
                ],
                'meta' => [
                    'current_page',
                    'from',
                    'last_page',
                    'links',
                    'path',
                    'per_page',
                    'to',
                    'total'
                ]
            ]
        );
        $response->assertJsonCount($expectedCount,'data');
    }


    public function test_unauthorized_user_can_not_see_user_scores()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('user-scores.index'));

        $response->assertForbidden();
        $response->assertJson([
            'message' => 'unauthorized access.',
        ]);
    }

    public function test_unauthenticated_user_can_not_see_user_scores()
    {
        $response = $this->get(route('user-scores.index'));

        $this->assertGuest();
        $response->assertJson([
            'message' => 'unauthenticated user.',
        ]);
    }

}
