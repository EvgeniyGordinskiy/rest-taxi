<?php

namespace App\Model;

class User extends \App\Mvc\DateTrackingModel
{
    public $id;
    public $phone;
    public $firstName;
    public $lastName;
    public $username;
    public $password;
    public $country_id;
    public $key;
    public $token;
    public $createdAt;
    public $updatedAt;

    public function getSource()
    {
        return 'users';
    }

    public function columnMap()
    {
        return parent::columnMap() + [
            'id' => 'id',
            'phone' => 'phone',
            'username' => 'username',
            'first_name' => 'firstName',
            'last_name' => 'lastName',
            'country_id' => 'country_id',
            'password' => 'password',
            'key' => 'key',
            'token' => 'token',
            'role_id' => 'roleId'
        ];
    }

    public function initialize() {

        $this->hasMany('id', Driver::class, 'userId', [
            'alias' => 'Driver',
        ]);

        $this->hasMany('id', UsersMapPointOrders::class, 'userId', [
            'alias' => 'Order',
        ]);

        $this->hasMany('id', UserRoles::class, 'userId');
    }
}
