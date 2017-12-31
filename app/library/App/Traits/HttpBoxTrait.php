<?php

namespace App\Traits;

use PhalconApi\Http\Response;

/**
 * Sending prepared messages
 * 
 * Class HttpBoxTrait
 * @package App\Traits
 */
trait HttpBoxTrait
{
    /**
     * Send response with error message
     * @param $error
     * @param int $status
     */
    public static function sendWithError($error, int $status = 500)
    {
        $response = new Response();
        $response->setStatusCode($status);
        $response->setJsonContent(['error' => $error]);
        $response->setHeader('Access-Control-Allow-Origin', '*');
        $response->setHeader('Access-Control-Allow-Headers', 'X-Requested-With');
        $response->send();
        die();
    }

    /**
     * Send response with success message
     * @param $msg
     * @param array $payload
     * @param int $status
     */
    public static function sendWithSuccess($msg, array $payload = [], int $status = 200)
    {
        $response = new Response();
        $response->setStatusCode($status);
        $response->setJsonContent(['Success' => $msg, 'items' => $payload]);
        $response->setHeader('Access-Control-Allow-Origin', '*');
        $response->setHeader('Access-Control-Allow-Headers', 'X-Requested-With');
        $response->send();
        die();
    }
}