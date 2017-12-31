<?php

namespace App\Model;

class Role extends \App\Mvc\DateTrackingModel
{
    public $id;
    public $name;
    public $createdAt;
    public $updatedAt;

    public function getSource()
    {
        return 'roles';
    }

    public function columnMap()
    {
        return parent::columnMap() + [
            'id' => 'id',
            'name' => 'name',
        ];
    }

    public function initialize() {

        $this->hasMany('id', UserRoles::class, 'roleId', [
            'alias' => 'roles',
        ]);
    }
}
