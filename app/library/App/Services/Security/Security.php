<?php
namespace App\Services\Security;

use App\Constants\Services;
use Phalcon\Di;
use PhalconApi\Auth\Session;

class Security 
{
    /**
     * @param string $input
     * @return string
     */
    public function hash(string $input) : string 
    {
        $output = password_hash($input,PASSWORD_DEFAULT);
        return $output;
    }

    /**
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public function checkHash(string $password, string $hash) : bool
    {
        return password_verify($password,$hash);
    }

    /**
     * @param $id
     * @param $playload
     * @param $uuid
     * @param $expirationTime
     * @param $publicKey
     */
    public function start_session($id, $playload, $uuid, $expirationTime, $publicKey)
    {
        $cash = Di::getDefault()->getCash();
        $cash->save($id, $playload, $expirationTime);
        $cash->save($uuid, $publicKey, $expirationTime);
    }
}