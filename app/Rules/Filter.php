<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Filter implements Rule
{
    protected $word;

    protected  $invalid_word;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($words)
    {
        $this->words = $words;
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
        foreach ($this->words as $word) {
            if (stripos($value, $word) !== false) {
                $this->invalid_word = $word;
                return false;
            }
        }
        return empty($this->invalid_word);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You Can Not Use '. implode(['', '', $this->invalid_word]) .' Word In Your Input';
    }
}
