<?php

namespace App\Model;

class UsersMapPointOrders extends \App\Mvc\DateTrackingModel
{
    public $id;
    public $userId;
    public $orderId;
    public $adress;
    public $lat;
    public $lon;

    public function getSource()
    {
        return 'UsersMapPointOrders';
    }

    public function columnMap()
    {
        return parent::columnMap() + [
            'id' => 'id',
            'user_id' => 'userId',
            'order_id' => 'orderId',
            'adress' => 'adress',
            'lat' => 'lat',
            'lon' => 'lon',
        ];
    }
    public function initialize()
    {
        $this->belongsTo('order_id', Order::class, 'id', [
            'alias' => 'Order',
        ]);
        
        $this->belongsTo('user_id', User::class, 'id', [
            'alias' => 'User',
        ]);
    }
    
    public function create($userLocation, $orderId, $userId)
    {
        
    }
}
