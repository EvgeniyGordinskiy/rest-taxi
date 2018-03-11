<?php

namespace App\Model;

class Country extends \App\Mvc\DateTrackingModel
{
    public $id;
    public $name;
    public $code;
    public $createdAt;
    public $updatedAt;
    
    public function getSource()
    {
        return 'country';
    }

    public function columnMap()
    {
        return parent::columnMap() + [
            'id' => 'id',
            'name' => 'name',
            'code' => 'code'
        ];
    }
}
