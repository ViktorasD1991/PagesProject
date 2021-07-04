<?php

namespace App\Http\Requests\Api;

use App\Rules\ValidateImage;
use Illuminate\Foundation\Http\FormRequest;

class AddElementRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request
     *
     * @return array
     */
    public function rules()
    {
        return [
            'data' => 'required|string',
            'type' => ['required', 'string', 'in:paragraph,title,quote,image', new ValidateImage($this->data)]
        ];
    }
}
