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

    private $errorsValidate = [];

    /**
     * Validate array of parameters
     * @param array $items
     */
    public function validating(array $items = [])
    {
        foreach ($items as $key => $item) {
            $this->check($item, $key);
        }

        if(count($this->errorsValidate) > 0) {
            $errors = [];
            foreach ($this->errorsValidate as $error) {
                $errors =  array_merge($errors,ErrorsValidate::getError($error['rule'], $error['name']));
            }
            self::sendWithError('Error',$errors, 400);
        }
    }

    /**
     * Parse rules and validating each of them
     * @param $item
     * @param $name
     * @return bool
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
                    $valueMethod = [];
                    $nameMethod = $rule;
                    $valueMethod[] = $item['value'];
                    if (is_array($rule)) {
                        $nameMethod = key($rule);
                        $valueMethod[] = $rule[$nameMethod];
                    }
                    $class = 'App\\Validate\\' . ucfirst(strtolower($nameMethod)) . 'Validate';
                    $obj = new $class();
                    $this->detect_result($obj, $valueMethod, $rule, $name);
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

    protected function detect_result(ValidatorInterface $validator, $valueMethod, $rule, $name)
    {
        $result = call_user_func_array([$validator, 'handle'], [$valueMethod]);
        if (!$result) {
            $this->errorsValidate[] = ['rule' => $rule, 'name' => $name];
        }
    }

}