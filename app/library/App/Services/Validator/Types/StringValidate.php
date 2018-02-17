<?php

namespace App\Services\Validator\Types;

class StringValidate implements TypeInterface
{
    public static function handle(array $item) :bool 
    {
            return is_string($item[0]);
    }
}