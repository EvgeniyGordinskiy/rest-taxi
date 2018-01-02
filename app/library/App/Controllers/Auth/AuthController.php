<?php

namespace App\Controllers\Auth;

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
        $data = $this->createUserData();
        $this->validateUserData($data);

        $user = Auth::register(
            $data['firstName']['value'],
            $data['lastName']['value'],
            $data['phone']['value'],
            $data['country']['value'],
            $data['password']['value']
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

    public function registerDriver()
    {
        $userData = $this->createUserData();
        $this->validateUserData($userData);

        $carData = $this->createCarData();
        $this->validateCarData($carData);

        $this->sendWithError($userData);
    }

    protected function createUserData()
    {
        $userData['firstName']['value']       = $this->requestTake('first_name');
        $userData['lastName']['value']        = $this->requestTake('last_name');
        $userData['phone']['value']           = $this->requestTake('phone');
        $userData['country']['value']         = $this->requestTake('country');
        $userData['password']['value']        = $this->requestTake('password');
        $userData['confirmPassword']['value'] = $this->requestTake('confirm_password');
        return $userData;
    }

    protected function createCarData()
    {
        $carData['brand']['value']       = $this->requestTake('brand');
        $carData['color']['value']       = $this->requestTake('color');
        $carData['costs_per_1']['value'] = $this->requestTake('costs_per_1');
        $carData['currency']['value']    = $this->requestTake('currency');
        $carData['model']['value']       = $this->requestTake('model');
        $carData['reg_number']['value']  = $this->requestTake('reg_number');
        $carData['year']['value']        = $this->requestTake('year');
        return $carData;
    }

    protected function validateUserData($data)
    {
        $data['firstName']['rule']       = ['require', 'string', ['min' => 3], ['max' => 250]];
        $data['lastName']['rule']        = ['require', 'string', ['min' => 3], ['max' => 250]];
        $data['phone']['rule']           = ['require', ['min' => 5], ['max' => 30]];
        $data['country']['rule']         = ['require', 'unsigned'];
        $data['password']['rule']        = ['require', ['confirm' => $data['confirmPassword']['value']],
                                           ['max' => 50], ['min' => 3]];
        $this->validating($data);
    }

    protected function validateCarData($data)
    {
        $data['brand']['rule']       = ['require', 'string', ['min' => 3], ['max' => 50]];
        $data['color']['rule']       = ['require', 'string', ['min' => 3], ['max' => 250]];
        $data['costs_per_1']['rule'] = ['require', ['min' => 5], ['max' => 30]];
        $data['model']['rule']       = ['require', 'string', ['min' => 4], ['max' => 50]];
        $data['year']['rule']        = ['require', 'string', ['equal' => 4]];
        $data['reg_number']['rule']  = ['require', ['min' => 3], ['max' => 250]];
        $this->validating($data);
    }
}