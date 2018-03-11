<?php

namespace App\Model;

class OrderStatuses extends \App\Mvc\DateTrackingModel
{
    public $id;
    public $name;
    public $code;
    public $createdAt;
    public $updatedAt;
    
    public function getSource()
    {
        return 'orderStatuses';
    }

    public function columnMap()
    {
        return parent::columnMap() + [
            'id' => 'id',
            'name' => 'name',
        ];
    }
}
