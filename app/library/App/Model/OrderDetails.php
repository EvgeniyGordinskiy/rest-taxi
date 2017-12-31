<?php

namespace App\Model;

    class OrderDetails extends \App\Mvc\DateTrackingModel
{
    public $id;
    public $orderId;
    public $babyChair;
    public $callMe;
    public $pets;
    public $differedPayment;
    public $large;
    public $passCount;
    public $passPhone;
    public $extension;
    public $startTime;
    public $comment;
    public $createdAt;
    public $updatedAt;
    
    public function getSource()
    {
        return 'orderDetails';
    }

    public function columnMap()
    {
        return parent::columnMap() + [
            'id' => 'id',
            'order_id' => 'orderId',
            'baby_chair' => 'babyChair',
            'callMe' => 'callMe',
            'pets' => 'pets',
            'differed_payment' => 'differedPayment',
            'large' => 'large',
            'pass_count' => 'passCount',
            'pass_phone' => 'passPhone',
            'extension' => 'extension',
            'start_time' => 'startTime',
            'comment' => 'comment',
        ];
    }
    public function initialize()
    {
        $this->belongsTo('order_id', Order::class, 'id', [
            'alias' => 'Order',
        ]);
    }

    public function create($orderId, $babyChair, $callMe, $comment, $deffered_payment, $duration,
                             $extension, $large, $passCount, $passPhone, $pets, $startTime)
    {

         return 'mo';
    }
}
