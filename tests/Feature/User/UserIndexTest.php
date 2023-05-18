<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserIndexTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_index_users()
    {
        $expectedCount = config('pagination.default_page_size');
        $user = User::factory()->create();
        $user->givePermissionTo('view any user');
        User::factory($expectedCount)->create();

        $response = $this->actingAs($user)->get(route('user.index',[
            'per_page' => $expectedCount,
            'page'     => 1,
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
                        'id',
                        'name',
                        'email',
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
        $this->assertDatabaseCount(User::class,$expectedCount+1);
    }


}
