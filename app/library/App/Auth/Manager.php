<?php

namespace App\Auth;

use PhalconApi\Auth\Session;
use PhalconApi\Exception;
use PhalconApi\Constants\ErrorCodes;
class Manager extends \PhalconApi\Auth\Manager
{
    const LOGIN_DATA_EMAIL = 'email';
    const LOGIN_DATA_PHONE = 'phone';

    protected $sessionDuration = 43200;
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

    public function login($accountTypeName, array $data)
    {
        if (!$account = $this->getAccountType($accountTypeName)) {

            throw new Exception(ErrorCodes::AUTH_INVALID_ACCOUNT_TYPE);
        }
        
        $identity = $account->login($data);

        if (!$identity) {

            throw new Exception(ErrorCodes::AUTH_LOGIN_FAILED);
        }

        $startTime = time();

        $session = new Session($accountTypeName, $identity['id'], $startTime, $startTime + $this->sessionDuration);
        
        $token = $this->tokenParser->getToken($session);
        $session->setToken($token);

        $this->session = $session;
        
        $this->security->start_session(
            $identity['id'],
            [$accountTypeName, $identity['id'], $startTime, $startTime + $this->sessionDuration],
            $identity['uuid'],
            $startTime + $this->sessionDuration
        );

        return $this->session;
    }
}