<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'isbn'        => $this->faker->word(),
            'name'        => $this->faker->name(),
            'authors'     => $this->faker->words(),
            'translators' => $this->faker->words(),
            'year'        => $this->faker->randomNumber(),
            'volume'      => $this->faker->randomNumber(),
            'pages'       => $this->faker->randomNumber(),
            'price'       => $this->faker->randomNumber(),
            'number'      => $this->faker->randomNumber(1),
            'maximumTime' => 3600*24*7,
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now(),
        ];
    }
}
