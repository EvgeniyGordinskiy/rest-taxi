<?php

namespace App\Auth;

use App\Constants\Services;
use Phalcon\Di;

class PhoneAccountType implements \PhalconApi\Auth\AccountType
{
    const NAME = "userphone";

    public function login($data)
    {
        /** @var \Phalcon\Security $security */
        $security = Di::getDefault()->get(Services::SECURITY);

        $phone = $data[Manager::LOGIN_DATA_PHONE];
        $password = $data[Manager::LOGIN_DATA_PASSWORD];

        /** @var \App\Model\User $user */
        $user = \App\Model\User::findFirst([
            'conditions' => 'phone = :phone:',
            'bind' => ['phone' => $phone]
        ]);

        if (!$user) {
            return null;
        }

        if (!$security->checkHash($password, $user->password)) {
            return null;
        }

        return (string)$user->id;
    }

    public function authenticate($identity)
    {
        return \App\Model\User::count([
            'conditions' => 'id = :id:',
            'bind' => ['id' => (int)$identity]
        ]) > 0;
    }
}