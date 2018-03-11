<?php
namespace App\Requests;

use App\Services\Validator\Lib\ValidatorRequest;

class LoginRequest extends ValidatorRequest
{

    public function handle() : array 
    {
        $data['phone']['value'] = $this->request->postBody('phone');
        $data['phone']['rule'] = ['require', ['min' => 5], ['max' => 30]];
        $data['password']['value'] = $this->request->postBody('password');
        $data['password']['rule'] = ['require', ['min' => 5], ['max' => 30]];
        return $data;
    }
}