<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookDeleteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_delete_a_book()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('delete a book');
        $book = Book::factory()->create();

        $response = $this->actingAs($user)->delete(route('book.delete',[
            'id' => 1
        ]));

        $response->assertOk();
        $this->assertSoftDeleted($book);
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

    public function test_unauthenticated_user_can_not_delete_a_book_record()
    {
        Book::factory()->create();

        $response = $this->delete(route('book.delete',[
            'id' => 1
        ]));

        $this->assertGuest();
        $response->assertJson([
            'message' => 'unauthenticated user.',
        ]);
    }

    public function test_unauthorized_user_can_not_delete_a_record()
    {
        $user = User::factory()->create();
        Book::factory()->create();

        $response = $this->actingAs($user)->delete(route('book.delete',[
            'id' => 1
        ]));

        $response->assertForbidden();
        $response->assertJson([
            'message' => 'unauthorized access.',
        ]);
    }

    public function test_resource_not_found_for_delete()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('delete a book');

        $response = $this->actingAs($user)->delete(route('book.delete',[
            'id' => 1
        ]));

        $response->assertNotFound();
        $response->assertJson([
            'message' => 'resource not found.',
        ]);
    }
}
