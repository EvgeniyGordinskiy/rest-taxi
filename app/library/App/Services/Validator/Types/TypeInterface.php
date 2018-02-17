<?php

namespace App\Services\Validator\Types;

interface TypeInterface
{
    /**
     * Run validation
     * @return mixed
     */
    public static function handle(array $item);

}