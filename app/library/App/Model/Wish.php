<?php

namespace App\Model;

class Wish extends \App\Mvc\DateTrackingModel
{
    public $id;
    public $name;
    public $createdAt;
    public $updatedAt;

    public function getSource()
    {
        return 'wishes';
    }

    public function columnMap()
    {
        return parent::columnMap() + [
            'id' => 'id',
            'name' => 'name',
        ];
    }

    public function initialize() {

        $this->hasMany('id', UsersWishes::class, 'wishId', [
            'alias' => 'wishes',
        ]);
    }
}
