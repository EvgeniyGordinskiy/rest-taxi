<?php
namespace App\Exceptions;

use App\Traits\HttpBoxTrait;

class Handler
{
    use HttpBoxTrait;

    public function handler()
    {
        $this->sendWithError(['err']);
    }
}