<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'search'   => 'string',
            'per_page' => 'integer',
            'page'     => 'integer',
        ];
    }
}
