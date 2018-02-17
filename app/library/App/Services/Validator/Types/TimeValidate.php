<?php

namespace App\Services\Validator\Types;

class TimeValidate implements TypeInterface
{
    public static function handle(array $item)
    {
        $format = '%H:%M:%S';
        $result = strptime($item[0], $format);
        
        return $result['tm_min'] || $result['tm_hour'];
    }
}