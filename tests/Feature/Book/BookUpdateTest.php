<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookUpdateTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_update_a_book_record()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('update a book');
        Book::factory()->create();
        $expectedISBN = \Str::random(10);

        $response = $this->actingAs($user)->put(route('book.update', [
                'id' => 1,
            ]),
            [
                'isbn'        => $expectedISBN,
                'name'        => 'asdfg',
                'maximumTime' => 80000,
                'year'        => 2000,
                'volume'      => 1,
                'pages'       => 300,
                'price'       => 100,
                'authors'     => [
                    'moz',
                    'boz',
                ],
                'translators' => [
                    'toz',
                    'goz',
                ],
            ]
        );

        $response->assertStatus(200);
        $this->assertDatabaseHas(Book::class,
        [
            'isbn' => $expectedISBN,
        ]);
    }

    public function test_unauthorized_user_can_not_update_a_book_record()
    {
        $user = User::factory()->create();
        Book::factory()->create();
        $expectedISBN = \Str::random(10);

        $response = $this->actingAs($user)->put(route('book.update', [
                'id' => 1,
            ]),
            [
                'isbn'        => $expectedISBN,
                'name'        => 'asdfg',
                'maximumTime' => 80000,
                'year'        => 2000,
                'volume'      => 1,
                'pages'       => 300,
                'price'       => 100,
                'authors'     => [
                    'moz',
                    'boz',
                ],
                'translators' => [
                    'toz',
                    'goz',
                ],
            ]
        );

        $response->assertForbidden();
        $response->assertJson([
            'message' => 'unauthorized access.',
        ]);
    }

    public function test_unauthenticated_user_can_not_update_a_book_record()
    {
        Book::factory()->create();
        $expectedISBN = \Str::random(10);

        $response = $this->put(route('book.update',
            [
                'id' => 1,
            ]),
            [
                'isbn'        => $expectedISBN,
                'name'        => 'asdfg',
                'maximumTime' => 80000,
                'year'        => 2000,
                'volume'      => 1,
                'pages'       => 300,
                'price'       => 100,
                'authors'     => [
                    'moz',
                    'boz',
                ],
                'translators' => [
                    'toz',
                    'goz',
                ],
            ]
        );

        $this->assertGuest();
        $response->assertJson([
            'message' => 'unauthenticated user.',
        ]);
    }

    public function test_not_found_for_updating()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('update a book');
        $expectedISBN = \Str::random(10);

        $response = $this->actingAs($user)->put(route('book.update',[
            'id' => 1,
        ]),
            [
                'isbn'        => $expectedISBN,
                'name'        => 'asdfg',
                'maximumTime' => 80000,
                'year'        => 2000,
                'volume'      => 1,
                'pages'       => 300,
                'price'       => 100,
                'authors'     => [
                    'moz',
                    'boz',
                ],
                'translators' => [
                    'toz',
                    'goz',
                ],
            ]
        );

        $response->assertNotFound();
        $response->assertJson([
            'message' => 'resource not found.',
        ]);
    }
}
