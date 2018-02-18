<?php

namespace App\Resources;

use App\Requests\LoginRequest;
use App\Requests\RegisterRequest;
use App\Services\AppEndpoint\AppEndpoint;
use App\Services\Resource\ResourceApp;
use PhalconRest\Api\ApiResource;
use PhalconRest\Api\ApiEndpoint;
use App\Model\User;
use App\Transformers\UserTransformer;
use App\Controllers\UserController;
use App\Constants\AclRoles;

class UserResource extends ResourceApp
{

    public function initialize()
    {
        $this
            ->name('User')
            ->model(User::class)
            ->expectsJsonData()
            ->transformer(UserTransformer::class)
            ->handler(UserController::class)
            ->itemKey('user')
            ->collectionKey('users')
            ->deny(AclRoles::UNAUTHORIZED, AclRoles::USER)
            ->endpoint(AppEndpoint::all()
                ->allow(AclRoles::USER)
                ->description('Returns all registered users')
            )
            ->endpoint(AppEndpoint::get('/me', 'me')
                ->allow(AclRoles::USER)
                ->description('Returns the currently logged in user')
            );
    }
}