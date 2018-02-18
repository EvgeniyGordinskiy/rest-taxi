<?php
namespace App\Services\Validator\Lib;

interface ValidatorInterface
{

    /**
     * Validate array of parameters
     * @param array $items
     */
    public function validating(array $items = []);
    
}
