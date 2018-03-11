<?php
namespace App\Services\Security;

use Phalcon\Di;

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
}