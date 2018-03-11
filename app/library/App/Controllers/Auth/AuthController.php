<?php
namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Model\User;
use App\Services\JWT\JWTService;

class AuthController extends BaseController
{
    public function login()
    {
        $session = $this->authManager->loginWithPhonePassword(
            \App\Auth\PhoneAccountType::NAME,
            $this->request->postBody('phone'),
            $this->request->postBody('password')
        );

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
        $data = $this->request->postBody();
        $data['password'] = $this->security->hash($data['password']);
        $data['token'] = JWTService::create_private_token();
        $user = new User();
        $user->save($data);
        $this->cache->save($this->db->lastInsertId().'_public_token', JWTService::create_public_token($data['token']));
        return $this->response->setJsonContent('ok', 'data');
    }
}