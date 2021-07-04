<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UpdateColumnRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'string',
            'order' => 'int|nullable'
        ];
    }
}
