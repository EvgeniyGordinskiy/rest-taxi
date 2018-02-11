<?php
namespace App\Exceptions;

class JWTAuthException extends BaseException
{
    public function __construct($message='Jwt error')
    {
        parent::__construct($message);
    }
}