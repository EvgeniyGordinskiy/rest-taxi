<?php

namespace App\Controllers\UserControllers\Auth;

use App\Constants\AclRoles;
use App\Controllers\BaseController;
use App\Model\Auth;
use App\Model\User;
use App\User\AuthService;

class AuthController extends BaseController
{
    public function authenticate ()
    {

        $phone = $this->requestData->phone;
        $password = $this->requestData->password;
        $this->validating([
            'phone' => [$phone,
                ['require', ['min' => 5], ['max' => 30]]],
            'password' => [
                $password,
                ['require',['max' => 50], ['min' => 3]]
            ]
        ]);

        $user = Auth::auth($phone, $password);
        if($user instanceof User){
            $this->sendWithSuccess('Authenticated successfully',
                [
                    'first_name' => $user->firstName,
                    'last_name'  => $user->lastName,
                    'token'      => $user->token,
                    'phone'      => $user->phone,
                    'country_id' => $user->country_id
                ]);
        }elseIf(is_string($user)){
            $this->sendWithError($user, 401);
        }
        return $this->requestData;

    }

    public function registerUser()
    {
        $firstName = $this->requestData->first_name;
        $lastName = $this->requestData->last_name;
        $phone = $this->requestData->phone;
        $country = $this->requestData->country;
        $password = $this->requestData->password;
        $confirmPassword = $this->requestData->confirm_password;
        
        $this->validating([
            'first_name' => [
                $firstName, ['require', 'string', ['min' => 3], ['max' => 250]]
            ],
            'last_name' => [
                $lastName, ['require', 'string', ['min' => 3], ['max' => 250]]
            ],
            'phone' => [
                $phone, ['require', ['min' => 5], ['max' => 30]]
            ],
            'country' => [
                $country, ['require', 'unsigned']],

            'password' => [
                $password,
                [   'require',
                    ['confirm' => $confirmPassword],
                    ['max' => 50],
                    ['min' => 3]
                ]
            ]
        ]);

        $user = Auth::register(
            $firstName,
            $lastName,
            $phone,
            $country,
            $password
        );

        if ($user instanceof User) {
            $HashId = (new AuthService)->encode($user->id.','.AclRoles::USER);
            $this->cache->save($user->token, $HashId, null);
            $this->sendWithSuccess('User create successfully');
        }elseif(is_string($user)){
            $this->sendWithError($user);
        }
        return $this->requestData;
    }
}