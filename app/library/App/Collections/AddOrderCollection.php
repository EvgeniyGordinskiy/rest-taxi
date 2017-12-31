<?php

namespace App\Collections;

use App\Constants\AclRoles;
use App\Controllers\UserControllers\AddOrderController;
use PhalconRest\Api\ApiCollection;
use PhalconRest\Api\ApiEndpoint;

class AddOrderCollection extends ApiCollection
{
    protected function initialize()
    {
        $this
            ->name('Order')
            ->handler(AddOrderController::class)
            ->deny(AclRoles::DRIVER, AclRoles::UNAUTHORIZED)
            ->allow(AclRoles::USER)
            ->endpoint(ApiEndpoint::post('/add', 'addOrder'));
    }
}
