<?php

namespace App\Controllers;

use App\Services\Validator\Lib\ValidatorRequest;
use PhalconRest\Mvc\Controllers\CrudResourceController;

class BaseController extends CrudResourceController
{
    protected $inputPost;
    public function onConstruct()
    {
        parent::onConstruct();
        $this->inputPost = $this->request->getJsonRawBody();
    }
}