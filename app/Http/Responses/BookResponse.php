<?php

namespace App\Http\Responses;

use App\Models\Book;

class BookResponse extends \Spatie\LaravelData\Data
{
    public int $id;
    public string $isbn;
    public string $name;
    public array $authors;
    public ?array $translators;
    public int $year;
    public int $volume;
    public int $pages;
    public int $price;
    public int $number;
    public int $maximumTime;
    public int $created_at;
    public int $updated_at;
    public ?int $deleted_at;


    public function __construct(Book $book)
    {
        $this->id          = $book->id;
        $this->name        = $book->name;
        $this->authors     = $book->authors;
        $this->translators = $book->translators;
        $this->year        = $book->year;
        $this->number      = $book->number;
        $this->volume      = $book->volume;
        $this->isbn        = $book->isbn;
        $this->pages       = $book->pages;
        $this->price       = $book->price;
        $this->created_at  = $book->created_at->timestamp;
        $this->deleted_at  = $book->deleted_at?->timestamp;
        $this->updated_at  = $book->updated_at->timestamp;
        $this->maximumTime = $book->maximumTime;
    }
}
