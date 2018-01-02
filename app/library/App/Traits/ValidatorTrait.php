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
     * Parse rulles and validating each of them
     * @param $item
     * @param $name
     */
    protected function check($item, $name) 
    {
        if(!isset($item['rule']) || !isset($item['value'])){
            $this->parseNestedItem($item, $name);
        }else{
            if (count($item['rule']) > 0) {
                $sometimes = $this->checkForValueSometimes($item['rule']);
                if ($sometimes && !$item['value']) {
                    return true;
                }
                foreach ($item['rule'] as $rule) {
                    $nameMethod = [];
                    $valueMethod = [];
                    $nameMethod = $rule;
                    $valueMethod[] = $item['value'];
                    if (is_array($rule)) {
                        $nameMethod = key($rule);
                        $valueMethod[] = $rule[$nameMethod];
                    }
                    $class = 'App\\Validate\\' . ucfirst(strtolower($nameMethod)) . 'Validate';
                    $obj = new $class();
                    if ($obj instanceof ValidatorInterface) {
                        $result = call_user_func_array([$obj, 'handle'], [$valueMethod]);
                        if (!$result) {
                            ErrorsValidate::message($rule, $name);
                        }
                    } else {
                        $this->sendWithError("Class $class must be instance of ValidatorInterface");
                    }
                }
            }
        }
    }


    /**
     * Parse input item
     *
     * @param array $items
     * @param $name
     * @return bool
     */
    protected function parseNestedItem(array $items, $name) :bool
    {
        foreach ($items as $item) {
            if(isset($item['rule']) && isset($item['value'])) {
                $this->check($item, $name);
            }
            if(is_array($item)){
                $this->parseNestedItem($item, $name);
            }
        }
        return false;
    }

    /**
     * Searching for 'sometimes' rule
     * @param array $items
     * @return bool
     */
    protected function checkForValueSometimes(array &$items) :bool 
    {
        if(in_array('sometimes', $items)){
            $key = array_search('sometimes', $items);
            unset($items[$key]);
            return true;
        }
        return false;
    }

}