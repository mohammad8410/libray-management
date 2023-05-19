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
        $user = User::factory()->create();
        $user->givePermissionTo('view any user');
        $user2 = User::factory()->create([
            'name' => 'moz',
        ]);

        $response = $this->actingAs($user)->get(route('user.index',[
            'id' => 2,
        ]));

        $response->assertOk();
        $response->assertJsonStructure(
            [
                'id',
                'name',
                'email',
            ]
        );
        $response->assertSeeText('moz');
    }

    public function test_unauthorized_user_can_not_see_other_users_info()
    {
        $user1 = User::factory()->create([
            'name' => 'moz',
        ]);
        User::factory()->create();

        $response = $this->actingAs($user1)->get(route('user.index',[
            'id' => 2,
        ]));

        $response->assertOk();
        $response->assertSeeText('moz');
    }

    public function test_unauthenticated_user_can_not_access_to_user_index()
    {
        $response = $this->get(route('user.index',[
            'id' => 1
        ]));

        $this->assertGuest();
        $response->assertJson([
            'message' => 'unauthenticated user.',
        ]);
    }

    public function test_resource_not_found_for_user_index()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view any user');

        $response = $this->actingAs($user)->get(route('user.index',[
            'id' => 2,
        ]));

        $response->assertNotFound();
        $response->assertJson([
            'message' => 'resource not found.',
        ]);
    }

}
