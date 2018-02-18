<?php

namespace App\Controllers;

use PhalconRest\Mvc\Controllers\CrudResourceController;

class UserController extends BaseController
{
    public function me()
    {
        return $this->createResourceResponse($this->userService->getDetails());
    }

    public function login()
    {
        $session = $this->authManager->loginWithPhonePassword(\App\Auth\PhoneAccountType::NAME,  $this->inputPost->phone,
            $this->inputPost->password );

        $transformer = new \App\Transformers\UserTransformer;
        $transformer->setModelClass('App\Model\User');

        $user = $this->createItemResponse(\App\Model\User::findFirst($session->getIdentity()), $transformer);

        $response = [
            'token' => $session->getToken(),
            'expires' => $session->getExpirationTime(),
            'user' => $user
        ];

        return $this->response->setJsonContent($response, 'data');
    }
    
    public function register()
    {

        return $this->response->setJsonContent(['register'], 'data');
    }

    public function whitelist()
    {
        return [
            'firstName',
            'lastName',
            'password'
        ];
    }
}
