<?php
namespace App\Services\Resource;

use App\Controllers\BaseController;
use App\Services\Validator\Lib\ValidatorRequest;
use PhalconRest\Api\ApiEndpoint;
use PhalconRest\Api\ApiResource;

class ResourceApp extends ApiResource
{
    private $controller;
    private $request;
    public function controller(BaseController $controller)
    {
        $this->controller = $controller;
        $this->handler(get_class($controller), $lazy = true);
        return $this;
    }
    
    public function request($request)
    {
        $this->request =  $request;
        return $this;
    }
}