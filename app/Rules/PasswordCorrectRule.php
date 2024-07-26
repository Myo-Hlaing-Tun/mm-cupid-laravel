<?php

namespace App\Rules;

use App\Models\Members;
use Illuminate\Contracts\Validation\Rule;

class PasswordCorrectRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $email;
    protected $password;
    public function __construct($email,$password)
    {
        $this->email    = $email;
        $this->password = $password;
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
        $member = Members::select('password')
                        ->where('email', $this->email)
                        ->whereNull('deleted_at')
                        ->first();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
