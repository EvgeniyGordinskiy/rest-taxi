<?php

namespace App\Services\Validator\Types;

class FloatValidate implements TypeInterface
{
    public static function handle(array $item)
    {
        return is_float($item[0]);
    }
}