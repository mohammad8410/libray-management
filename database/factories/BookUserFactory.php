<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\BookUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BookUserFactory extends Factory
{
    protected $model = BookUser::class;

    public function definition(): array
    {
        return [
            'user_id'    => fn() => $this->faker->uuid(),
            'book_id'    => fn() => $this->faker->uuid(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function withUser(User $user): self
    {
        return $this->state([
            'user_id' => $user->id,
        ]);
    }

    public function withBook(Book $book): self
    {
        return $this->state([
            'book_id' => $book->id,
        ]);
    }
}
