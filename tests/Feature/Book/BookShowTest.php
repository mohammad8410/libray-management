<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookShowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_book_show_structure()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view any book');
        Book::factory()->create();

        $response = $this->actingAs($user)->get(route('book.show',[
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
    }

    public function test_resource_not_found_for_show()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('book.show',['book' => 1]));

        $response->assertNotFound();
        $response->assertJson([
            'message' => 'resource not found.',
        ]);
    }

    public function test_unauthenticated_access_to_view_a_book()
    {
        Book::factory()->create();

        $response = $this->get(route('book.show',['book' => 1]));

        $this->assertGuest();
        $response->assertJson([
            'message' => 'unauthenticated user.'
        ]);
    }
}
