<?php

namespace App\Model;

class OrdersMapPoints extends \App\Mvc\DateTrackingModel
{
    public $id;
    public $orderId;
    public $adress;
    public $lat;
    public $lon;
    public $sort;

    public function getSource()
    {
        return 'orders_map_points';
    }

    public function columnMap()
    {
        return parent::columnMap() + [
            'id' => 'id',
            'order_id' => 'orderId',
            'adress' => 'adress',
            'lat' => 'lat',
            'lon' => 'lon',
            'sort' => 'sort'
        ];
    }
    public function initialize()
    {
        $this->belongsTo('order_id', Order::class, 'id', [
            'alias' => 'Order',
        ]);
    }

    public function add(array $routePoints, int $orderId) :array 
    {
        $routePointsArray = [];
        foreach ($routePoints as $point) {
            $routePoint = new OrdersMapPoints();
            $routePoint->lat     = $point->lat;
            $routePoint->lon     = $point->lon;
            $routePoint->sort     = $point->sort;
            $routePoint->adress  = $point->adress;
            $routePoint->orderId = $orderId;
            $routePoint->save();
            $routePointsArray[] = $routePoint;
        }
        return $routePointsArray;
    }
}
