<?php

namespace App\Model;

use App\User\AuthService;

class Auth extends \App\Mvc\DateTrackingModel
{
    public static function register(string $firstName, string $lastName, string $phone, string $country_id, string $password)
    {
        $res = User::count([
                'conditions' => 'phone = :phone:',
                'bind' => ['phone' => $phone]
            ]) > 0;

        if (!$res) {

            
            try{
                $access_token = AuthService::generateKey();
                $key = AuthService::generateKey(40);
                $role = Role::findFirst([
                    'name' => 'user'
                ]);
                if($role) {
                    $roleId = $role->id;
                    $newUser = new User();
                    $newUser ->firstName  =  $firstName;
                    $newUser ->lastName   =  $lastName;
                    $newUser ->phone      =  $phone;
                    $newUser ->country_id =  $country_id;
                    $newUser ->password   =  md5($password);
                    $newUser ->key        =  $key;
                    $newUser -> token     =  $access_token;
                    $newUser -> roleId     =  $roleId;
                    $newUser->createdAt   = date('Y-m-d H:i:s');
                    $newUser->updatedAt   = $newUser->createdAt;
                    $newUser ->save();
                }else{
                    return 'Role "user" is not found';
                }
            } catch (\Exception $e) {
                return $e->getMessage()." in file ".$e->getFile()." on line ".$e->getLine();
            }
            
        } else {
            return 'This phone is already taken';
        }
        return $newUser;
    }

    public static function auth(string $phone, string $password)
    {
       $user = User::findFirst(
           [
               'phone = :phone: AND password = :password:',
               'bind' => [
                   'phone' => $phone,
                   'password' => md5($password),
               ],
           ]
       );
        if($user) {
           return $user;
        }
        return 'Phone or password is incorrect';
    }
}