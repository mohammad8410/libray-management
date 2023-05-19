<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserDeleteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_delete_a_user()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('delete own account');

        $response = $this->actingAs($user)->delete(route('user.delete'));

        $response->assertStatus(204);
        $this->assertSoftDeleted($user);
    }

    public function test_unauthenticated_user_can_not_delete_account()
    {
        $response = $this->delete(route('user.delete'));

        $this->assertGuest();
        $response->assertJson([
            'message' => 'unauthenticated user.',
        ]);
    }

    public function test_unauthorized_user_can_not_delete_account()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->delete(route('user.delete'));

        $response->assertForbidden();
        $response->assertJson([
            'message' => 'unauthorized access.',
        ]);
    }
}
