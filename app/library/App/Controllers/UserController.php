<?php

namespace App\Controllers;

use PhalconRest\Mvc\Controllers\CrudResourceController;

class UserController extends BaseController
{
    public function me()
    {
        return $this->createResourceResponse($this->userService->getDetails());
    }
    

    public function whitelist()
    {
        return [
            'firstName',
            'lastName',
            'password'
        ];
    }
}
