<?php

namespace App\Controllers;

use PhalconRest\Mvc\Controllers\CrudResourceController;

class BaseController extends CrudResourceController
{
    protected $inputPost;
    public function onConstruct()
    {
        $this->inputPost = $this->request->getJsonRawBody();
    }
}