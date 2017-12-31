<?php

namespace App\Controllers\UserControllers;

use App\Controllers\BaseController;
use App\Model\Order;
use App\Model\OrderDetails;
use App\Model\OrdersMapPoints;
use App\Model\OrdersPayments;
use App\Model\UsersMapPointOrders;

class AddOrderController extends BaseController
{
    public function addOrder()
    {
        $babyChair = $this->requestData->baby_chair;
        $callMe = $this->requestData->callme;
        $carId = $this->requestData->car_id;
        $comment = $this->requestData->comment;
        $countryId = $this->requestData->country_id;
        $deffered_payment = $this->requestData->deffered_payment;
        $driverId = $this->requestData->driver_id;
        $duration = $this->requestData->duration;
        $extension = $this->requestData->extension;
        $large = $this->requestData->large;
        $passCount = $this->requestData->pass_count;
        $passPhone = $this->requestData->pass_phone;
        $passangerId = $this->requestData->passanger_id;
        $paymentTypeId = $this->requestData->payment_type_id;
        $pets = $this->requestData->pets;
        $regionId = $this->requestData->region_id;
        $startTime = $this->requestData->start_time;
        $userLocation['lat'] = 0.0;
        $userLocation['lon'] = 0.0;


        if(count($this->requestData->user_location) === 2){
            $userLocation['lat'] = $this->requestData->user_location[0];
            $userLocation['lon'] = $this->requestData->user_location[1];
        }

        $routePoints =  $this->requestData->route_points;
        $routePointsValidate = [];
        foreach($routePoints as $key => $point){
            $routePointsValidate["adress$key"] = [
                $point['adress'],
                ['require', ['max' => 250]]
            ];
            $routePointsValidate["lat$key"] = [
                $point['lat'],
                ['require', 'float']
            ];
            $routePointsValidate["lon$key"] = [
                $point['lon'],
                ['require', 'float']
            ];
            $routePointsValidate["sort$key"] = [
                $point['sort'],
                ['require']
            ];
        }

        $this->validateRequestAddOrder($callMe, $carId, $comment, $countryId,
            $deffered_payment, $driverId, $duration,
            $extension, $large, $passCount, $passPhone,
            $passangerId, $paymentTypeId, $pets, $regionId,
            $startTime, $userLocation, $routePointsValidate);
        
        $order = new Order();
        $order->create($carId, $countryId, $driverId, $passangerId, $regionId);
        
        $orderDetails = new OrderDetails();
        $orderDetails->create($order->id, $babyChair, $callMe, $comment, $deffered_payment, $duration,
                                $extension, $large, $passCount, $passPhone, $pets, $startTime);
        
        $orderPayments = new OrdersPayments();
        $orderPayments->create($paymentTypeId, $order->id);

        $usersMapPointOrders = new UsersMapPointOrders();
        $usersMapPointOrders->create($userLocation, $order->id, $passangerId);

        $ordersMapPoints = new OrdersMapPoints();
        $ordersMapPoints->create($routePoints, $order->id);

        return Order::addOrder();
    }

    protected function validateRequestAddOrder($callMe, $carId, $comment, $countryId,
        $deffered_payment, $driverId, $duration,
        $extension, $large, $passCount, $passPhone,
        $passangerId, $paymentTypeId, $pets, $regionId,
        $startTime, $userLocation, $routePointsValidate)
    {


        $this->validating([
            'callMe' => [
                $callMe, ['require', ['min' => 0], ['max' => 1]]
            ],
            'car_id' => [
                $carId, ['require', ['exist' => 'cars']]
            ],
            'comment' => [
                $comment, ['string', ['max' => 250]]
            ],
            'country_id' => [
                $countryId, ['require', ['exist' => 'countries']]
            ],
            'deffered_payment' => [
                $deffered_payment,
                [   'require',
                    ['max' => 2],
                    ['min' => 0]
                ]
            ],
            'driver_id' => [
                $driverId,
                [   'require',
                    ['exist' => 'drivers']
                ]
            ],
            'duration' => [
                $duration,
                [   'require',
                    ['max' => 10],
                ]
            ],
            'extension' => [
                $extension,
                [   'require',
                    'time',
                ]
            ],
            'large' => [
                $large,
                [   'require',
                    ['max' => 2],
                    ['min' => 0]
                ]
            ],
            'pass_count' => [
                $passCount,
                [   'require',
                    ['max' => 2],
                    ['min' => 0]
                ]
            ],
            'pass_phone' => [
                $passPhone,
                [   'require',
                    ['max' => 250]
                ]
            ],
            'passanger_id' => [
                $passangerId,
                [   'require',
                    ['exist' => 'users']
                ]
            ],
            'payment_type_id' => [
                $paymentTypeId,
                [   'require',
                    ['exist' => 'payment_types']
                ]
            ],
            'pets' => [
                $pets,
                [   'require',
                    ['max' => 1],
                    ['min' => 0]
                ]
            ],
            'region_id' => [
                $regionId,
                [   'require',
                    ['exist' => 'regions']
                ]
            ],
            'start_time' => [
                $startTime,
                [   'require',
                    'dateTime'
                ]
            ],
            'user_location["lat"]' => [
                $userLocation['lat'],
                [   'require',
                    'float'
                ]
            ],
            'user_location["lon"]' => [
                $userLocation['lon'],
                [   'require',
                    'float'
                ]
            ]
        ]);

        $this->validating($routePointsValidate);
    }
}