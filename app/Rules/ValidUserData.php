<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidUserData implements Rule
{
    public function passes($attribute, $value)
    {
        // Validate the user data
        // ...

        return true; // or false if validation fails
    }

    public function message()
    {
        return 'The user data is invalid.';
    }
}
