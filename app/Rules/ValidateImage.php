<?php

namespace App\Rules;

use App\Constants\Elements;
use App\Models\Images;
use Illuminate\Contracts\Validation\Rule;

class ValidateImage implements Rule
{
    /**
     * @var string $data
     */
    private $data;

    /**
     * Create a new rule instance.
     *
     * @param string $data
     *
     * @return void
     */
    public function __construct(string $data)
    {
        $this->data = $data;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($value == Elements::IMAGE) {
            $image = Images::where('path', '=', $this->data)->first();

            if (empty($image)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Image does not exist in the image library. You have to upload your image first.';
    }
}
