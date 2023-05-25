<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookDecreaseTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_decrease_count_of_a_book()
    {
        $countInDB = 10;
        $decCount = 5;
        $user = User::factory()->create();
        $user->givePermissionTo('decrease book count');
        $book = Book::factory()->create([
            'number' => $countInDB,
        ]);

        $response = $this->actingAs($user)->post(route('book.decrease',[
            'id' => 1,
            'decCount' => $decCount,
        ]));

        $response->assertOk();
        $response->assertJsonStructure(
            [
                'id',
                'isbn',
                'name',
                'authors',
                'translators',
                'year',
                'volume',
                'pages',
                'price',
                'number',
                'maximumTime',
                'created_at',
                'updated_at',
                'deleted_at',
            ]
        );
        $this->assertDatabaseHas(Book::class,[
            'number' => $countInDB-$decCount,
        ]);
    }
    public function test_unauthorized_user_can_not_decrease_count_of_a_book()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->actingAs($user)->post(route('book.decrease',[
            'id' => 1,
            'decCount' => 1,
        ]));

        $response->assertForbidden();
        $response->assertJson([
            'message' => 'unauthorized access.',
        ]);
    }

    public function test_unauthenticated_user_can_not_decrease_count_of_a_book()
    {
        Book::factory()->create();

        $response = $this->post(route('book.decrease',[
            'id' => 1,
            'decCount' => 1,
        ]));

        $this->assertGuest();
        $response->assertJson([
            'message' => 'unauthenticated user.',
        ]);
    }

    public function test_resource_not_found_for_count_decrease()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('decrease book count');

        $response = $this->actingAs($user)->post(route('book.decrease',[
            'id' => 1,
            'decCount' => 1,
        ]));

        $response->assertNotFound();
        $response->assertJson([
            'message' => 'resource not found.',
        ]);
    }

    public function test_not_acceptable_count_decrease()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('decrease book count');
        $book = Book::factory()->create([
            'number' => 1
        ]);

        $response = $this->actingAs($user)->post(route('book.decrease',[
            'id' => 1,
            'decCount' => 2,
        ]));

        $response->assertStatus(406);
        $response->assertJson([
            'message' => 'not acceptable.',
        ]);
    }
}
