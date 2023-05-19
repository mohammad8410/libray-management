<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserScoreUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'newScore' => 'integer|required',
        ];
    }
}
