<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
              "isbn" => 'string',
              "maximumTime" => 'integer',
              "name" => 'string',
              "authors" => 'array',
              "translators" => 'array',
              "year" => 'integer',
              "volume" => 'integer',
              "pages" => 'integer',
              "price" => 'integer',
        ];
    }
}
