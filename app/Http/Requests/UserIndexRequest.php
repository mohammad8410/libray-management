<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'per_page' => 'integer|nullable',
            'page'     => 'integer|nullable',
        ];
    }
}
