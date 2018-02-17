<?php

namespace App\Services\Validator\Types;

class IntValidate implements TypeInterface
{
    public static function handle(array $item)
    {
        return is_int($item[0]);
    }
}