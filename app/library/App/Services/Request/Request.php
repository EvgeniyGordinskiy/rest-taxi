<?php
namespace App\Services\Request;

class Request extends \PhalconApi\Http\Request
{
    public $inputPost;

    public function __construct()
    {
        $this->inputPost = $this->getJsonRawBody();
    }
}