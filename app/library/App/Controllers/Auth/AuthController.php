<?php
namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Model\User;

class AuthController extends BaseController
{
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
        $this->response->setStatusCode(500);
        return $this->response->setJsonContent(['register'], 'data');
    }
}