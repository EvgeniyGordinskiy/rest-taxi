<?php

namespace App\Services\Validator\Types;

class UnsignedValidate implements TypeInterface
{
    public static function handle(array $item) : bool
    {
        return (bool) is_numeric($item[0]) && $item [0] > 0;
    }
}