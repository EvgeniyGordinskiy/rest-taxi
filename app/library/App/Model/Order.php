<?php

namespace App\Model;

class Order extends \App\Mvc\DateTrackingModel
{
    public $id;
    public $carId;
    public $countryId;
    public $driverId;
    public $passangerId;
    public $regionId;
    public $statusId;
    public $createdAt;
    public $updatedAt;

    public static $NOT_CONFIRMED_BY_DRIVER = 1;

    public function getSource()
    {
        return 'orders';
    }

    public function columnMap()
    {
        return parent::columnMap() + [
            'id' => 'id',
            'car_id' => 'carId',
            'country_id' => 'countryId',
            'driver_id' => 'driverId',
            'passanger_id' => 'passangerId',
            'region_id' => 'regionId',
            'status_id' => 'statusId',
        ];
    }

    public function initialize() {

        $this->belongsTo('car_id', Car::class, 'id', [
            'alias' => 'Driver',
        ]);
        $this->belongsTo('country_id', Country::class, 'id', [
            'alias' => 'Country',
        ]);
        $this->belongsTo('driver_id', Driver::class, 'id', [
            'alias' => 'Driver',
        ]);
        $this->belongsTo('passanger_id', User::class, 'id', [
            'alias' => 'Passanger',
        ]);
        $this->belongsTo('region_id', Region::class, 'id', [
            'alias' => 'Region',
        ]);
        $this->belongsTo('status_id', OrderStatuses::class, 'id', [
            'alias' => 'Status',
        ]);

        $this->hasMany('id', OrderDetails::class, 'orderId', [
            'alias' => 'OrderDetails',
        ]);
        $this->hasMany('id', OrdersMapPoints::class, 'orderId', [
            'alias' => 'OrdersMapPoints',
        ]);
    }
    
    public function add(int $carId, int $countryId, int $driverId, int $passangerId, int $regionId) :Order
    {
        $order = new Order();
        $order->carId = $carId;
        $order->countryId = $countryId;
        $order->driverId = $driverId;
        $order->passangerId = $passangerId;
        $order->regionId = $regionId;
        $order->statusId = Order::$NOT_CONFIRMED_BY_DRIVER;
        $order->save();
        return $order;
    }
}
