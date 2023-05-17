<?php

namespace Feature\Book;

use App\Models\Book;
use App\Models\User;
use Tests\TestCase;

class BookIndexTest extends TestCase
{
    public function test_book_index_structure()
    {
        $expectedCount = config('pagination.default_page_size');
        $user = User::factory()->create();
        Book::factory($expectedCount+1)->create();

        $response = $this->actingAs($user)->get(route('book.index'));

        $response->assertOk();
        $response->assertJsonCount($expectedCount, 'data');
        $response->assertJsonStructure(
            [
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next'
                ],
                'data' => [
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
                ],
                'meta' => [
                    'current_page',
                    'from',
                    'last_page',
                    'links',
                    'path',
                    'per_page',
                    'to',
                    'total'
                ]
            ]
        );
    }

    public function test_unauthenticated_user_can_not_see_book_index()
    {
        Book::factory()->create();

        $response = $this->get(route('book.index'));

        $this->assertGuest();
        $response->assertJson([
            'message' => 'unauthenticated user.',
        ]);
    }

    public function test_search_parameter()
    {
        $user = User::factory()->create();
        $book = Book::factory(2)->create();

        $response = $this->actingAs($user)->get(route('book.index',[
            'search' => $book[0]['name'],
        ]));

        $response->assertJsonCount(1,'data');
    }
}
