<?php

namespace App\Rules;

use App\Constants;
use Illuminate\Contracts\Validation\Rule;

class DateRequestRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $point;
    public function __construct($point)
    {
        $this->point = $point;
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
        return !($this->point < Constants::DATE_REQUEST_POINT);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Your point is not enough for date request';
    }
}
