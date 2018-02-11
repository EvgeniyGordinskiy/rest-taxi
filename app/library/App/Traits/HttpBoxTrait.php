<?php

namespace App\Traits;

use PhalconApi\Http\Response;
use phpDocumentor\Reflection\Types\Null_;

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
    public function sendWithError($error, array $payload = [], int $status = 500)
    {
        $response = new Response();
        $response->setStatusCode($status);
        $response->setJsonContent(['error' => $error, 'items' => $payload]);
        $this->addHeaders($response);
        $response->send();
        die();
    }

    /**
     * Send response with success message
     * @param $msg
     * @param array $payload
     * @param int $status
     */
    public function sendWithSuccess($msg, array $payload = [], int $status = 200)
    {
        $response = new Response();
        $response->setStatusCode($status);
        $response->setJsonContent(['Success' => $msg, 'items' => $payload]);
        $this->addHeaders($response);
        $response->send();
        die();
    }

    /**
     * Take variable from request
     * @param $prop
     * @return bool
     */
    public function requestTake($prop)
    {
        if(!$this->requestData) {
            $this->requestData = json_decode($this->request->getRawBody());
        }
        return $this->requestData->{$prop} ?? null;
    }

    private function addHeaders(Response $response)
    {
        $response->setHeader('Access-Control-Allow-Origin', '*');
        $response->setHeader('Access-Control-Allow-Headers', 'X-Requested-With');
    }
}