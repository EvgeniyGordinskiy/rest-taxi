<?php

namespace App\Model;

class Region extends \App\Mvc\DateTrackingModel
{
    public $id;
    public $name;
    public $createdAt;
    public $updatedAt;
    
    public function getSource()
    {
        return 'region';
    }

    public function columnMap()
    {
        return parent::columnMap() + [
            'id' => 'id',
            'name' => 'name',
        ];
    }
}
