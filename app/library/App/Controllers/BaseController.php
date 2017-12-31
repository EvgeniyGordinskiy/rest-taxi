<?php

namespace App\Controllers;

use App\Traits\ValidatorTrait;
use PhalconRest\Mvc\Controllers\CrudResourceController;

class BaseController extends CrudResourceController
{
    use ValidatorTrait;
    
    public $requestData;
    
    public function onConstruct()
    {
        parent::onConstruct();
        
        $this->requestData = json_decode($this->request->getRawBody());
    }
}