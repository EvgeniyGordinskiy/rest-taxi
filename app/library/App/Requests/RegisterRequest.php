<?php
namespace App\Requests;

use App\Services\Validator\Lib\ValidatorRequest;

class RegisterRequest extends ValidatorRequest
{

    public function handle() : array
    {
        $data['firstName']['value']       =  $this->inputPost->first_name;
        $data['firstName']['rule']       = ['require', 'string', ['min' => 3], ['max' => 250]];
        $data['lastName']['value']        =  $this->inputPost->last_name;
        $data['lastName']['rule']        = ['require', 'string', ['min' => 3], ['max' => 250]];
        $data['phone']['value']           =  $this->inputPost->phone;
        $data['phone']['rule']           = ['require', ['min' => 5], ['max' => 30]];
        $data['country']['value']         =  $this->inputPost->country;
        $data['country']['rule']         = ['require', 'unsigned'];
        $data['password']['value']        =  $this->inputPost->password;
        $data['confirmPassword']['value'] =  $this->inputPost->confirm_password;
        $data['password']['rule']        = ['require', ['confirm' => $data['confirmPassword']['value']],
            ['max' => 50], ['min' => 3]];
        return $data;
    }
}