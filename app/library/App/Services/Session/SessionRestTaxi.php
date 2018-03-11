<?php
namespace App\Services\Session;

use Phalcon\Di;
use PhalconApi\Auth\Session;

class SessionRestTaxi extends Session
{
    protected $ip;
    protected $browser;
    protected $port;
    protected $client;
    private $prefix = 'access_session_';

    public function __construct($accountTypeName, $identity, $startTime, $expirationTime, $token = null){
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->browser = $_SERVER['HTTP_USER_AGENT'];
        $this->port = $_SERVER['REMOTE_PORT'];
        $this->client = $_SERVER['HTTP_ORIGIN'];
        parent::__construct($accountTypeName, $identity, $startTime, $expirationTime, $token = null);
    }

    /**
     * @param $session
     * @param $token
     */
    public function start_session(Session $session, $token)
    {
        $cash = Di::getDefault()->getCache();
        $cash->save(
            $this->prefix.$session->identity,
            [
                'startTime' => $session->startTime,
                'exp' => $session->expirationTime,
                'token' => $token,
                'ip' => $session->ip,
                'port' => $session->port,
                'client' => $session->client,
                'browser' => $session->browser,
                'active' => true
            ],
            $session->expirationTime);
    }

    public function check_session($identity)
    {
        $cash = Di::getDefault()->getCash();
        $cash->isFresh($this->prefix.$identity);
    }
}