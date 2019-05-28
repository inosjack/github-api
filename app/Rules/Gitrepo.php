<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Gitrepo implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        //
        $data = shell_exec( 'git ls-remote '.$value);
        return $data != null;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The url must be a valid git repository.';
    }
}
