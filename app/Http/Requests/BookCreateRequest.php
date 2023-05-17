<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "isbn"        => 'string|unique:books',
            "maximumTime" => 'integer',
            "name"        => 'string',
            "authors"     => 'array',
            "translators" => 'array|nullable',
            "year"        => 'integer',
            "volume"      => 'integer',
            "pages"       => 'integer',
            "price"       => 'integer',
            "number"      => 'integer',
        ];
    }
}
