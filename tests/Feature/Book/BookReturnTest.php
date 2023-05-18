<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use App\Models\BookUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReturnTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_returning_a_book()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('return a book');
        $book = Book::factory()->create();
        BookUser::factory()->withUser($user)->withBook($book)->create();

        $response = $this->actingAs($user)->post(route('book.return',[
            'book' => 1
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
        $this->assertDatabaseHas(BookUser::class,[
            'deleted_at' => now(),
        ]);
    }

    public function test_returning_a_book_that_does_not_exist_in_borrow_records()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('return a book');
        $book = Book::factory()->create();

        $response = $this->actingAs($user)->post(route('book.return',[
            'book' => 1,
        ]));

        $response->assertStatus(406);
        $response->assertJson([
            'message' => 'Not Acceptable.',
        ]);
    }

    public function test_unauthenticated_user_can_not_return_a_book()
    {
        $response = $this->post(route('book.return',[
            'book' => 1,
        ]));

        $this->assertGuest();
        $response->assertJson([
            'message' => 'unauthenticated user.',
        ]);
    }

    public function test_unauthorized_user_can_not_return_a_book()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->actingAs($user)->post(route('book.return',[
            'book' => 1,
        ]));

        $response->assertForbidden();
        $response->assertJson([
            'message' => 'unauthorized access.',
        ]);
    }

    public function test_resource_not_found_for_return()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('return a book');

        $response = $this->actingAs($user)->post(route('book.return',[
            'book' => 1,
        ]));


        $response->assertNotFound();
        $response->assertJson([
            'message' => 'resource not found.',
        ]);
    }
}
