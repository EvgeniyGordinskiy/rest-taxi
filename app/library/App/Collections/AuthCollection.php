<?php

namespace App\Collections;

use App\Constants\AclRoles;
use App\Controllers\ExportController;
use App\Controllers\UserController;
use App\Requests\LoginRequest;
use App\Requests\RegisterRequest;
use App\Services\AppEndpoint\AppEndpoint;
use PhalconRest\Api\ApiCollection;
use PhalconRest\Api\ApiEndpoint;

class AuthCollection extends ApiCollection
{
    protected function initialize()
    {
        $this
            ->name('Auth')
            ->handler(UserController::class)
            ->expectsJsonData()
            ->endpoint(AppEndpoint::post('/login', 'login')
                ->name('login')
                ->allow(AclRoles::UNAUTHORIZED)
                ->deny(AclRoles::AUTHORIZED)
                ->request(LoginRequest::class)
                ->description('Authenticates user credentials provided in the authorization header and returns an access token')
            )
            ->endpoint(AppEndpoint::post('/register', 'register')
                ->name('register')
                ->allow(AclRoles::UNAUTHORIZED)
                ->deny(AclRoles::AUTHORIZED)
                ->request(RegisterRequest::class)
                ->description('Authenticates user credentials provided in the authorization header and returns an access token')
                ->exampleResponse([
                    'token' => 'co126bbm40wqp41i3bo7pj1gfsvt9lp6',
                    'expires' => 1451139067
                ])
            );
    }
}
