<?php

namespace App\Auth;

use PhalconApi\Auth\Session;
use PhalconRest\Exception;

class Manager extends \PhalconApi\Auth\Manager
{
    const LOGIN_DATA_EMAIL = 'email';
    const LOGIN_DATA_PHONE = 'phone';

    /**
     * @param string $accountTypeName
     * @param string $email
     * @param string $password
     *
     * @return Session Created session
     * @throws Exception
     *
     * Helper to login with email & password
     */
    public function loginWithEmailPassword($accountTypeName, $email, $password)
    {
        return $this->login($accountTypeName, [
            self::LOGIN_DATA_EMAIL => $email,
            self::LOGIN_DATA_PASSWORD => $password
        ]);
    }
    /**
     * @param string $accountTypeName
     * @param string $email
     * @param string $password
     *
     * @return Session Created session
     * @throws Exception
     *
     * Helper to login with email & password
     */
    public function loginWithPhonePassword($accountTypeName, $phone, $password)
    {
        return $this->login($accountTypeName, [
            self::LOGIN_DATA_PHONE => $phone,
            self::LOGIN_DATA_PASSWORD => $password
        ]);
    }
}