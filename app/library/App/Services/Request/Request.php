<?php
namespace App\Services\Request;

class Request extends \PhalconApi\Http\Request
{
    protected $inputPost;

    public function __construct()
    {
        $this->inputPost = $this->getPostedData();
    }
    
    public function postBody($name = false)
    {
        if(!$name){
            return $this->inputPost;
        }
        return $this->inputPost[$name] ?? '';
    }
    
    public function setData(array $data)
    {
        $this->inputPost = $data;
    }
}