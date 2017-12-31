<?php

namespace App\Collections;

use App\Controllers\UserControllers\Auth\AuthController;
use PhalconRest\Api\ApiCollection;
use PhalconRest\Api\ApiEndpoint;

class AuthCollection extends ApiCollection
{
    protected function initialize()
    {
        $this
            ->name('Auth')
            ->handler(AuthController::class)
            ->endpoint(ApiEndpoint::post('/apiv1/authenticate', 'authenticate'))
            ->endpoint(ApiEndpoint::post('/apiv1/register', 'registerUser'));
    }
}
