<?php

namespace App\Model;

class OrdersMapPoints extends \App\Mvc\DateTrackingModel
{
    public $id;
    public $userId;
    public $orderId;
    public $adress;
    public $lat;
    public $lon;

    public function getSource()
    {
        return 'OrdersMapPoints';
    }

    public function columnMap()
    {
        return parent::columnMap() + [
            'id' => 'id',
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
    }

    public function create($routePoints, $orderId)
    {

    }
}
