<?php

namespace App\Model;

class UserRoles extends \App\Mvc\DateTrackingModel
{
    public $id;
    public $userId;
    public $roleId;
    public $createdAt;
    public $updatedAt;

    public function getSource()
    {
        return 'user_roles';
    }

    public function columnMap()
    {
        return parent::columnMap() + [
            'id' => 'id',
            'user_id' => 'userId',
            'role_id' => 'roleId',
        ];
    }

    public function initialize() {

        $this->belongsTo('user_id', User::class, 'id', [
            'alias' => 'role',
        ]);
        $this->belongsTo('role_id', Role::class, 'id', [
            'alias' => 'role',
        ]);
    }
}
