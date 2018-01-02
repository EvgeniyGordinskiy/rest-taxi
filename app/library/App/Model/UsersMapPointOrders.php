<?php

namespace App\Model;

class UsersMapPointOrders extends \App\Mvc\DateTrackingModel
{
    public $id;
    public $userId;
    public $orderId;
    public $lat;
    public $lon;

    public function getSource()
    {
        return 'users_map_point_orders';
    }

    public function columnMap()
    {
        return parent::columnMap() + [
            'id' => 'id',
            'user_id' => 'userId',
            'order_id' => 'orderId',
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
    
    public function add(array $userLocation, $orderId, $userId)
    {
        $userMapPoint = new UsersMapPointOrders();
        $userMapPoint->lat     = $userLocation['lat']['value'];
        $userMapPoint->lon     = $userLocation['lon']['value'];
        $userMapPoint->userId  = $userId;
        $userMapPoint->orderId = $orderId;
     
        return $userMapPoint;
    }
}
