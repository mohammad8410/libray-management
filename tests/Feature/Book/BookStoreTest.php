<?php

namespace Feature\Book;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookStoreTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_book_created_successfully()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('store a book');
        $expectedISBN = \Str::random(10);

        $response = $this->actingAs($user)->post(route('book.store',
            [
                'isbn'        => $expectedISBN,
                'name'        => 'efghs',
                'maximumTime' => 80000,
                'authors'     => [
                    'moz',
                    'boz',
                    'toz',
                ],
                'translators' => [
                    'goz',
                    'soz',
                ],
                'year'        => 2000,
                'volume'      => 1,
                'pages'       => 200,
                'price'       => 100,
                'number'      => 2,
            ]
        ));

        $response->assertStatus(201);
        $this->assertDatabaseHas(Book::class,
            [
                'isbn' => $expectedISBN,
            ]
        );
    }

    public function test_unauthorized_user_can_not_store_a_book()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('book.store', [
            'isbn'        => 'asdffg',
            'name'        => 'efghs',
            'maximumTime' => 80000,
            'authors'     => [
                'moz',
                'boz',
                'toz',
            ],
            'translators' => [
                'goz',
                'soz',
            ],
            'year'        => 2000,
            'volume'      => 1,
            'pages'       => 200,
            'price'       => 100,
            'number'      => 2,
        ]));

        $response->assertForbidden();
        $response->assertJson([
            'message' => 'unauthorized access.'
        ]);
    }

    public function test_unauthenticated_user_can_not_store_a_book()
    {
        $response = $this->post(route('book.store', [
            'isbn'        => 'asdhgkid',
            'name'        => 'efghs',
            'maximumTime' => 80000,
            'authors'     => [
                'moz',
                'boz',
                'toz',
            ],
            'translators' => [
                'goz',
                'soz',
            ],
            'year'        => 2000,
            'volume'      => 1,
            'pages'       => 200,
            'price'       => 100,
            'number'      => 2,
        ]));

        $this->assertGuest();
        $response->assertJson([
            'message' => 'unauthenticated user.',
        ]);
    }

    public function test_isbn_duplication_should_be_unprocessable()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('store a book');
        $book = Book::factory()->create();
        $ISBN = $book->isbn;

        $response = $this->actingAs($user)->postJson(route('book.store',
            [
                'isbn'        => $ISBN,
                'name'        => 'efghs',
                'maximumTime' => 80000,
                'authors'     => [
                    'moz',
                    'boz',
                    'toz',
                ],
                'translators' => [
                    'goz',
                    'soz',
                ],
                'year'        => 2000,
                'volume'      => 1,
                'pages'       => 200,
                'price'       => 100,
                'number'      => 2,
            ]
        ));

        $response->assertUnprocessable();
    }
}
