<?php
namespace App\Requests;

use App\Services\Validator\Lib\ValidatorRequest;

class RegisterRequest extends ValidatorRequest
{

    public function __construct(){
        parent::__construct();
    }

    public function handle() : array
    {
        $data['first_name']['value']       =  $this->request->postBody('first_name');
        $data['first_name']['rule']       = ['require', 'string', ['min' => 3], ['max' => 250]];
        $data['last_name']['value']        =  $this->request->postBody('last_name');
        $data['last_name']['rule']        = ['require', 'string', ['min' => 3], ['max' => 250]];
        $data['phone']['value']           =  $this->request->postBody('phone');
        $data['phone']['rule']           = ['require', ['min' => 5], ['max' => 30]];
        $data['country_id']['value']         =  $this->request->postBody('country_id');
        $data['country_id']['rule']         = ['require', 'unsigned', ['exist' => 'countries']];
        $data['role_id']['value']         =  $this->request->postBody('role_id');
        $data['role_id']['rule']         = ['require', 'unsigned', ['exist' =>'roles']];
        $data['password']['value']        =  $this->request->postBody('password');
        $data['confirm_password']['value'] =  $this->request->postBody('confirm_password');
        $data['password']['rule']        = ['require', ['confirm' => $data['confirm_password']['value']],
            ['max' => 50], ['min' => 3]];
        return $data;
    }
}