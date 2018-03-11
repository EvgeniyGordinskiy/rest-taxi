<?php

namespace App\Model;

class OrdersPayments extends \App\Mvc\DateTrackingModel
{
    public $id;
    public $orderId;
    public $paymentTypeId;
    public $createdAt;
    public $updatedAt;

    public function getSource()
    {
        return 'orders_payments';
    }

    public function columnMap()
    {
        return parent::columnMap() + [
            'id' => 'id',
            'order_id' => 'orderId',
            'payment_type_id' => 'paymentTypeId',
        ];
    }

    public function initialize() 
    {

        $this->belongsTo('order_id', Order::class, 'id', [
            'alias' => 'order',
        ]);
        $this->belongsTo('payment_type_id', PaymentTypes::class, 'id', [
            'alias' => 'paymentType',
        ]);
    }
    
    public function add(int $paymentTypeId, int $orderId) :OrdersPayments
    {
        $payment = new OrdersPayments();
        $payment->orderId       = $orderId;
        $payment->paymentTypeId = $paymentTypeId;
        $payment->save();
        return $payment;
    }
}
