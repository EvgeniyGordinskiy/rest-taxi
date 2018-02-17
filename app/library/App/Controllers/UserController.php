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
        $data['phone']['value'] = $this->inputPost->phone;
        $data['phone']['rule'] = ['require', ['min' => 5], ['max' => 30]];
        $data['password']['value'] = $this->inputPost->password;
        $data['password']['rule'] = ['require', ['min' => 5], ['max' => 30]];
        $this->validator->validating($data);
        $session = $this->authManager->loginWithPhonePassword(\App\Auth\PhoneAccountType::NAME,  $data['phone']['value'],
            $data['password']['value'] );

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
