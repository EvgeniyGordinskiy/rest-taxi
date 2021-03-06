<?php

namespace App\Bootstrap;

use App\Auth\EmailAccountType;
use App\Auth\PhoneAccountType;
use App\Services\Request\Request;
use App\Services\Security\Security;
use App\Services\Validator\Validator;
use App\Services\JWT\JWTService as JWT;
use Phalcon\Config;
use PhalconRest\Api;
use Phalcon\Http\Response;
use Phalcon\DiInterface;
use App\BootstrapInterface;
use App\Constants\Services;
use App\Auth\UsernameAccountType;
use App\Fractal\CustomSerializer;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View\Simple as View;
use App\User\Service as UserService;
use App\Auth\Manager as AuthManager;
use Phalcon\Events\Manager as EventsManager;
use League\Fractal\Manager as FractalManager;
use Phalcon\Mvc\Model\Manager as ModelsManager;
use PhalconApi\Auth\TokenParsers\JWTTokenParser;

class ServiceBootstrap implements BootstrapInterface
{
    public function run(Api $api, DiInterface $di, Config $config)
    {
        /**
         * @description Config - \Phalcon\Config
         */
        $di->setShared(Services::CONFIG, $config);

        /**
         * @description Phalcon - \Phalcon\Db\Adapter\Pdo\Mysql
         */
        $di->set(Services::DB, function () use ($config, $di) {

            $config = $config->get('database')->toArray();
            $adapter = $config['adapter'];
            unset($config['adapter']);
            $class = 'Phalcon\Db\Adapter\Pdo\\' . $adapter;

            $connection = new $class($config);

            // Assign the eventsManager to the db adapter instance
            $connection->setEventsManager($di->get(Services::EVENTS_MANAGER));

            return $connection;
        });

        /**
         * @description Phalcon - \Phalcon\Mvc\Url
         */
        $di->set(Services::URL, function () use ($config) {
            $url = new UrlResolver;
            $url->setBaseUri($config->get('application')->baseUri);
            return $url;
        });
        
        /**
         * @description Phalcon - \Phalcon\Mvc\Url
         */
        $di->set(Services::REQUEST, new Request());

        /**
         * @description Phalcon - \Phalcon\Mvc\View\Simple
         */
        $di->set(Services::VIEW, function () use ($config) {

            $view = new View;
            $view->setViewsDir($config->get('application')->viewsDir);

            return $view;
        });

        /**
         * @description Phalcon - EventsManager
         */
        $di->setShared(Services::EVENTS_MANAGER, function () use ($di, $config) {

            return new EventsManager;
        });

        /**
         * @description Phalcon - TokenParsers
         */
        $di->setShared(Services::TOKEN_PARSER, function () use ($di, $config) {

            return new JWT();
        });

        /**
         * @description Phalcon - AuthManager
         */
        $di->setShared(Services::AUTH_MANAGER, function () use ($di, $config) {

            $authManager = new AuthManager($config->get('authentication')->expirationTime);
            $authManager->registerAccountType(PhoneAccountType::NAME, new PhoneAccountType());
            return $authManager;
        });

        /**
         * @description Phalcon - \Phalcon\Mvc\Model\Manager
         */
        $di->setShared(Services::MODELS_MANAGER, function () use ($di) {

            $modelsManager = new ModelsManager;
            return $modelsManager->setEventsManager($di->get(Services::EVENTS_MANAGER));
        });

        /**
         * @description PhalconRest - \League\Fractal\Manager
         */
        $di->setShared(Services::FRACTAL_MANAGER, function () {

            $fractal = new FractalManager;
            $fractal->setSerializer(new CustomSerializer);

            return $fractal;
        });

        /**
         * @description PhalconRest - \PhalconRest\User\Service
         */
        $di->setShared(Services::USER_SERVICE, new UserService);
        
        /**
         * @description PhalconRest - \PhalconRest\User\Service
         */
        $di->setShared(Services::VALIDATOR, new Validator());

        /**
         * @description PhalconRest - \Phalcon\Cache\Backend\Redis
         */
        $di->setShared(Services::CACHE, function () use($config) {
            $oFrontCache = new \Phalcon\Cache\Frontend\Igbinary(array(
                'lifetime' => 36000,
                'prefix'   => 'fe.'
            ));
            $oRedis = new \Phalcon\Cache\Backend\Redis($oFrontCache, array('redis' => $config->get('redis')));
            return $oRedis;
        });

        /**
         * Security instance
         */
        $di->setShared(Services::SECURITY, new Security());
    }
}
