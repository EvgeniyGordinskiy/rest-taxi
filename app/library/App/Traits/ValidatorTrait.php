<?php

namespace App\Traits;

use App\Validate\Errors\ErrorsValidate;
use App\Validate\ValidatorInterface;

/**
 * Validating current values
 * 
 * Class ValidatorTrait
 * @package App\Traits
 */
trait ValidatorTrait
{
    use HttpBoxTrait;

    /**
     * Validate array of parameters
     * @param array $items
     */
    public function validating(array $items = [])
    {
        foreach ($items as $key => $item) {
            $this->check($item, $key);
        }
    }

    /**
     * Parse rulls and validating each of them
     * @param $item
     * @param $name
     */
    protected function check($item, $name) 
    {
        if (count($item[1]) > 0) {
            foreach ($item[1] as $rule) {
                $nameMethod=[];
                $valueMethod=[];
                $nameMethod = $rule;
                $valueMethod[] = $item[0];

                if(is_array($rule)) {
                        $nameMethod = key($rule);
                        $valueMethod[] = $rule[$nameMethod];
                }

                $class = 'App\\Validate\\'.ucfirst(strtolower($nameMethod)).'Validate';
                $obj = new $class();
                if ($obj instanceof ValidatorInterface){
                    $result =  call_user_func_array([$obj, 'handle'], [$valueMethod]);
                    if (!$result) {
                        ErrorsValidate::message($rule, $name);
                    }
                }else{
                    $this->sendWithError("Class $class must be instance of ValidatorInterface");
                }
            }
        }
    }
}