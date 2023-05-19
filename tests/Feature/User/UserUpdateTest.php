<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserUpdateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_update_a_user_info()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('update own info');

        $response = $this->actingAs($user)->put(route('user.update',[
            'name' => 'moz',
        ]));

        $response->assertOk();
        $response->assertJsonStructure(
            [
                'id',
                'name',
                'email',
            ]
        );
    }

    public function test_unauthorized_user_can_not_update_user_info()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('user.update',[
            'name' => 'moz',
        ]));

        $response->assertForbidden();
        $response->assertJson([
            'message' => 'unauthorized access.',
        ]);
    }

    public function test_unauthenticated_user_can_not_update_info()
    {
        $response = $this->put(route('user.update',[
            'name' => 'moz',
        ]));

        $this->assertGuest();
        $response->assertJson([
            'message' => 'unauthenticated user.',
        ]);
    }


}
