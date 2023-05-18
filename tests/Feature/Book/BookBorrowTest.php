<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use App\Models\BookUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookBorrowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_borrow_a_book()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('borrow a book');
        $book = Book::factory()->create();

        $response = $this->actingAs($user)->post(route('book.borrow',[
            'book' => 1,
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
    }

    public function test_borrow_a_book_that_does_not_exist()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user2->givePermissionTo('borrow a book');
        $book = Book::factory()->create([
            'number' => 1,
        ]);
        BookUser::factory()->withUser($user1)->withBook($book)->create();

        $response = $this->actingAs($user2)->post(route('book.borrow',[
            'book' => 1,
        ]));

        $response->assertStatus(406);
        $response->assertJson([
            'message' => 'Not Acceptable.',
        ]);
    }

    public function test_unauthenticated_user_can_not_borrow_a_book()
    {
        $response = $this->post(route('book.borrow',[
            'book' => 1
        ]));

        $this->assertGuest();
        $response->assertJson([
            'message' => 'unauthenticated user.',
        ]);
    }

    public function test_resource_not_found_for_borrow()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('borrow a book');

        $response = $this->actingAs($user)->post(route('book.borrow',[
            'book' => 1,
        ]));

        $response->assertNotFound();
        $response->assertJson([
            'message' => 'resource not found.',
        ]);
    }

    public function test_unauthorized_user_can_not_borrow_a_book()
    {
        $user = User::factory()->create();
        Book::factory()->create();

        $response = $this->actingAs($user)->post(route('book.borrow',[
            'book' => 1,
        ]));

        $response->assertForbidden();
        $response->assertJson([
            'message' => 'unauthorized access.',
        ]);
    }

}
