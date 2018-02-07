<?php

namespace App\Validate\Errors;

use App\Traits\HttpBoxTrait;

class ErrorsValidate
{
    use HttpBoxTrait;
    
    public static function getError($item, string $name)
    {
        $error = '';
        $name = lcfirst($name);
        if(is_array($item)){
         $error = self::handleArray($item, $name);
        }

        if(is_string($item)){
            $error = self::handleString($item, $name);
        }
        
        return  $error;
    }

    private static function handleArray(array $item, string $name)
    {
        $nameMethod = key($item);
        $valueMethod = $item[$nameMethod];
        switch ($nameMethod) {
            case 'min':
                return [$name => "$name must be bigger than $valueMethod"];
                break;
            case 'max':
                return [$name => "$name must be less than $valueMethod"];
                break;
            case 'confirm':
                return [$name => "$name must be confirm"];
                break;
            default:
                return [$name => "$name error validating"];
                break;
        }
    }

    private static function handleString(string $item, string $name)
    {
        switch ($item) {
            case 'integer':
                return [$name => "$name must be an integer"];
                break;
            case 'require':
                return [$name => "$name is required"];
                break;
            case 'string':
                return [$name => "$name must be an integer"];
                break;
            case 'email':
                return [$name => "Incorrect E-Mail"];
                break;
            default:
                return [$name => "$name error validating"];
                break;
        }
    }
}