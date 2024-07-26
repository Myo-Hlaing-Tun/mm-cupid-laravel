<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Base64Rule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $base64;
    public function __construct($base64)
    {
        $this->base64 = $base64;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return base64_encode(base64_decode($this->base64, true)) !== $this->base64;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid base64 encoded string.';
    }
}
