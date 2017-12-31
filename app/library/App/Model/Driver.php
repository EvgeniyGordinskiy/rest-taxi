<?php

namespace App\Model;

class Driver extends \App\Mvc\DateTrackingModel
{
    public $id;
    public $name;
    public $code;
    public $createdAt;
    public $updatedAt;
    
    public function getSource()
    {
        return 'driver';
    }

    public function columnMap()
    {
        return parent::columnMap() + [
            'id' => 'id',
            'user_id' => 'userId',
        ];
    }

    public function initialize() {

        $this->belongsTo('userId', User::class, 'id', [
            'alias' => 'User',
        ]);
    }
}
