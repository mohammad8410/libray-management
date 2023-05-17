<?php

namespace Feature\Book;

use App\Models\Book;
use App\Models\User;
use Tests\TestCase;

class BookStoreTest extends TestCase
{

    public function test_book_created_successfully()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('store a book');

        $response = $this->actingAs($user)->post(route('book.store',[
            'isbn' => \Str::random(10),
            'name' => 'efghs',
            'maximumTime' => 80000,
            'authors' => [
                'moz',
                'boz',
                'toz',
            ],
            'translators' => [
                'goz',
                'soz',
            ],
            'year' => 2000,
            'volume' => 1,
            'pages' => 200,
            'price' => 100,
            'number' => 2,
        ]));

        $response->assertStatus(201);
        $this->assertDatabaseHas(Book::class,[
            'name' => 'efghs',
        ]);
    }

    public function test_unauthorized_user_can_not_store_a_book()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('book.store',[
            'isbn' => \Str::random(10),
            'name' => 'efghs',
            'maximumTime' => 80000,
            'authors' => [
                'moz',
                'boz',
                'toz',
            ],
            'translators' => [
                'goz',
                'soz',
            ],
            'year' => 2000,
            'volume' => 1,
            'pages' => 200,
            'price' => 100,
            'number' => 2,
        ]));

        $response->assertForbidden();
        $response->assertJson([
            'message' => 'unauthorized access.'
        ]);
    }

    public function test_unauthenticated_user_can_not_store_a_book()
    {
        $response = $this->post(route('book.store',[
            'isbn' => \Str::random(10),
            'name' => 'efghs',
            'maximumTime' => 80000,
            'authors' => [
                'moz',
                'boz',
                'toz',
            ],
            'translators' => [
                'goz',
                'soz',
            ],
            'year' => 2000,
            'volume' => 1,
            'pages' => 200,
            'price' => 100,
            'number' => 2,
        ]));

        $this->assertGuest();
        $response->assertJson([
            'message' => 'unauthenticated user.',
        ]);
    }
}
