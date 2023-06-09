<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserScoreIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'sort'    => 'boolean|nullable',
            'perPage' => 'int',
            'page'    => 'int',
        ];
    }
}
