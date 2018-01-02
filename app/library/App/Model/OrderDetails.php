<?php

namespace App\Model;

    class OrderDetails extends \App\Mvc\DateTrackingModel
{
    public $id;
    public $orderId;
    public $babyChair;
    public $callMe;
    public $duration;
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
        return 'order_details';
    }

    public function columnMap()
    {
        return parent::columnMap() + [
            'id' => 'id',
            'order_id' => 'orderId',
            'baby_chair' => 'babyChair',
            'callMe' => 'callMe',
            'pets' => 'pets',
            'duration' => 'duration',
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

    public function add($orderId, $babyChair, $callMe, $comment, $deffered_payment, $duration,
                             $extension, $large, $passCount, $passPhone, $pets, $startTime)
    {
        $orderDetails = new OrderDetails();
        $orderDetails->pets            = $pets;
        $orderDetails->large           = $large;
        $orderDetails->callMe          = $callMe;
        $orderDetails->orderId         = $orderId;
        $orderDetails->comment         = $comment;
        $orderDetails->duration        = $duration;
        $orderDetails->babyChair       = $babyChair;
        $orderDetails->extension       = $extension;
        $orderDetails->passCount       = $passCount;
        $orderDetails->passPhone       = $passPhone;
        $orderDetails->startTime       = $startTime;
        $orderDetails->differedPayment = $deffered_payment;
        $orderDetails->save();
        return $orderDetails;
    }

}
