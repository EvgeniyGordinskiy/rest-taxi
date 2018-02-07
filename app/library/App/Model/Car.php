<?php

namespace App\Model;

class Car extends \App\Mvc\DateTrackingModel
{
    public $id;
    public $status;
    public $color;
    public $regNumber;
    public $year;
    public $brand;
    public $model;
    public $currency;
    public $plantingCosts;
    public $costsPer1;
    public $carPhoto;
    public $createdAt;
    public $updatedAt;
    
    public function getSource()
    {
        return 'car';
    }

    public function columnMap()
    {
        return parent::columnMap() + [
            'id' => 'id',
            'status' => 'status',
            'color' => 'color',
            'reg_number' => 'regNumber',
            'year' => 'year',
            'brand' => 'brand',
            'model' => 'model',
            'currency' => 'currency',
            'planting_costs' => 'plantingCosts',
            'costs_per_1' => 'costsPer1',
            'car_photo' => 'carPhoto',
        ];
    }

    public function add(string $status, string $color, string $regNumber, int $year, string $brand, string $model,
                               string $currency, string $plantingCosts, string $costsPer1, string $carPhoto) : Car
    {
        $car = new self();
        $car->color = $color;
        $car->status = $status;
        $car->regNumber = $regNumber;
        $car->year = $year;
        $car->brand = $brand;
        $car->model = $model;
        $car->currency = $currency;
        $car->plantingCosts = $plantingCosts;
        $car->costsPer1 = $costsPer1;
        $car->carPhoto = $carPhoto;
        $car->save();
        return $car;
    }
}
