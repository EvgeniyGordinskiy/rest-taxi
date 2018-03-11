<?php

namespace App\Model;

class PaymentTypes extends \App\Mvc\DateTrackingModel
{
    public $id;
    public $name;
    public $createdAt;
    public $updatedAt;

    public function getSource()
    {
        return 'payment_types';
    }

    public function columnMap()
    {
        return parent::columnMap() + [
            'id' => 'id',
            'name' => 'name',
        ];
    }

    public function initialize() {

        $this->hasMany('id', OrdersPayments::class, 'paymentTypeId', [
            'alias' => 'paymentType',
        ]);
    }
}
