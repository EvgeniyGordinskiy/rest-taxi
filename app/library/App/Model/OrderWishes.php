<?php

namespace App\Model;

class OrderWishes extends \App\Mvc\DateTrackingModel
{
    public $id;
    public $orderId;
    public $wishId;
    public $createdAt;
    public $updatedAt;

    public function getSource()
    {
        return 'order_wishes';
    }

    public function columnMap()
    {
        return parent::columnMap() + [
            'id' => 'id',
            'order_id' => 'orderId',
            'wish_id' => 'wishId',
        ];
    }

    public function initialize() {

        $this->belongsTo('order_id', Order::class, 'id', [
            'alias' => 'order',
        ]);
        $this->belongsTo('wish_id', Wish::class, 'id', [
            'alias' => 'wish',
        ]);
    }


    public function add($wishes, int $orderId)
    {
        $wishesArray = [];
        foreach($wishes as $wishId) {
            $uWish = new OrderWishes();
            $uWish->orderId = $orderId;
            $uWish->wishId = $wishId;
            $uWish->save();
            var_dump($uWish->wish);
            die();
            $wishesArray[] = $uWish;
        }
        
        return $wishesArray;
    }
}
