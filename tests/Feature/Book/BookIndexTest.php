<?php

namespace Feature\Book;

use App\Models\Book;
use Tests\TestCase;
use App\Models\User;

class BookIndexTest extends TestCase
{
    public function test_book_index_structure()
    {
        $user = User::factory()->create();
        $books= Book::factory(15)->create();

        $response = $this->get(route('book.index'));

        $response->assertOk();
    }
}
