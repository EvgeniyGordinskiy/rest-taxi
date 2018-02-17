<?php

namespace App\Services\Validator\Types;

class RequireValidate implements TypeInterface
{
    public static function handle(array $item) :bool
    {

        return mb_strlen( (string) $item[0], "UTF-8") > 0;
    }
}