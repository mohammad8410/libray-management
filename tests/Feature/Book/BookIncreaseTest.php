<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookIncreaseTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_count_of_a_book_increased()
    {
        $incCount = 5;
        $expectedCount = 7;
        $user = User::factory()->create();
        $user->givePermissionTo('increase book count');
        Book::factory()->create([
            'number' => $expectedCount - $incCount,
        ]);

        $response = $this->actingAs($user)->post(route('book.increase',[
            'id' => 1,
            'incCount' => $incCount,
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
            'number' => $expectedCount,
        ]);
    }

    public function test_unauthorized_user_can_not_increase_count_of_a_book()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->actingAs($user)->post(route('book.increase',[
            'id' => 1,
            'incCount' => 5,
        ]));

        $response->assertForbidden();
        $response->assertJson([
            'message' => 'unauthorized access.',
        ]);
    }

    public function test_unauthenticated_user_can_not_increase_count_of_a_book()
    {
        Book::factory()->create();

        $response = $this->post(route('book.increase',[
            'id' => 1,
            'incCount' => 5,
        ]));

        $this->assertGuest();
        $response->assertJson([
            'message' => 'unauthenticated user.',
        ]);
    }

    public function test_resource_not_found_for_count_increase()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('increase book count');

        $response = $this->actingAs($user)->post(route('book.increase',[
            'id' => 1,
            'incCount' => 5,
        ]));

        $response->assertNotFound();
        $response->assertJson([
            'message' => 'resource not found.',
        ]);
    }
}
