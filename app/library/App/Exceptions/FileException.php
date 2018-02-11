<?php
namespace App\Exceptions;

class FileException extends BaseException
{
    public function __construct($message='')
    {
        parent::__construct($message);
    }
}