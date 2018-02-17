<?php

namespace App\Services\Validator\Types;

class EmailValidate implements TypeInterface
{
    public static function handle(array $item) :bool
    {
        
        return (bool) filter_var($item[0], FILTER_VALIDATE_EMAIL);
    }
}