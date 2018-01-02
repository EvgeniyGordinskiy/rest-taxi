<?php

namespace App\Controllers\UserControllers;

use App\Controllers\BaseController;
use App\Model\Order;
use App\Model\OrderDetails;
use App\Model\OrdersMapPoints;
use App\Model\OrdersPayments;
use App\Model\UsersMapPointOrders;
use App\Model\OrderWishes;

class AddOrderController extends BaseController
{
    public function addOrder()
    {
        $data = [];
        // Order model
        $data['carId']['value'] = $this->requestTake('car_id');
        $data['carId']['rule'] = ['require', ['exist' => 'cars']];
        
        $data['regionId']['value'] = $this->requestTake('region_id');
        $data['regionId']['rule'] = ['require', ['exist' => 'regions']];
        
        $data['driverId']['value'] = $this->requestTake('driver_id');
        $data['driverId']['rule'] =   ['require', ['exist' => 'drivers']];
        
        $data['countryId']['value'] = $this->requestTake('country_id');
        $data['countryId']['rule'] = ['require', ['exist' => 'countries']];
        
        $data['passangerId']['value'] = $this->requestTake('passanger_id');
        $data['passangerId']['rule'] =  ['require', ['exist' => 'users']];

        // OrderDetails model
        $data['pets']['value'] = $this->requestTake('pets');
        $data['pets']['rule'] =   ['sometimes', ['max' => 1], ['min' => 0]];
        
        $data['large']['value'] = $this->requestTake('large');
        $data['large']['rule'] =   ['sometimes', ['max' => 2], ['min' => 0]];
        
        $data['callMe']['value'] = $this->requestTake('callme');
        $data['callMe']['rule'] =    ['sometimes', 'int', ['min' => 0], ['max' => 1]];
        
        $data['comment']['value'] = $this->requestTake('comment');
        $data['comment']['rule'] =   ['sometimes', ['max' => 255]];
        
        $data['duration']['value'] = $this->requestTake('duration');
        $data['duration']['rule'] =  ['sometimes', ['max' => 10]];
        
        $data['extension']['value'] = $this->requestTake('extension');
        $data['extension']['rule'] =  ['sometimes', 'time'];
        
        $data['babyChair']['value'] = $this->requestTake('baby_chair');
        $data['babyChair']['rule'] = ['sometimes', ['max' => 10]];
        
        $data['passCount']['value'] = $this->requestTake('pass_count');
        $data['passCount']['rule'] = ['sometimes', ['max' => 2], ['min' => 0]];
        
        $data['passPhone']['value'] = $this->requestTake('pass_phone');
        $data['passPhone']['rule'] = ['sometimes', ['max' => 250]];
        
        $data['startTime']['value'] = $this->requestTake('start_time');
        $data['startTime']['rule'] = ['sometimes', 'dateTime'];
        
        $data['deffered_payment']['value'] = $this->requestTake('deffered_payment');
        $data['deffered_payment']['rule'] =  ['sometimes', ['max' => 2], ['min' => 0]];

        // OrdersPayments model
        $data['paymentTypeId']['value'] = $this->requestTake('payment_type_id');
        $data['paymentTypeId']['rule'] = ['require', ['exist' => 'payment_types']];

        // UsersMapPointOrders model
        $data['userLocation']['lat']['value'] = 0.0;
        $data['userLocation']['lat']['rule'] =  ['require', 'float'];
        
        $data['userLocation']['lon']['value'] = 0.0;
        $data['userLocation']['lon']['rule'] =  ['require', 'float'];

        $userLocation = $this->requestTake('user_location');
        if(is_array($userLocation) && count($userLocation) === 2){
            $data['userLocation']['lat']['value'] = $userLocation[0];
            $data['userLocation']['lon']['value'] = $userLocation[1];
        }

        // OrdersMapPoints model
        $routePoints = $this->requestTake('route_points');
        if(is_array($routePoints)) {
            foreach($routePoints as $key => $point){
                $data['routePointsValidate']["adress$key"]['value'] = $point->adress;
                $data['routePointsValidate']["adress$key"]['rule'] = ['require', ['max' => 250]];

                $data['routePointsValidate']["lat$key"]['value'] = $point->lat;
                $data['routePointsValidate']["lat$key"]['rule'] = ['require', 'float'];

                $data['routePointsValidate']["lon$key"]['value'] =  $point->lon;
                $data['routePointsValidate']["lon$key"]['rule'] = ['require', 'float'];

                $data['routePointsValidate']["sort$key"]['value'] = (int) $point->sort;
                $data['routePointsValidate']["sort$key"]['rule'] = ['require' , 'int'];
            }
        }

        // Wish model
        $wishes = $this->requestTake('wishlist_option_id');
        if(is_array($wishes)) {
            foreach ($wishes as $key => $wish) {
                $data["wish$key"]['value'] = $wish;
                $data["wish$key"]['rule'] = ['int', ['exist' => 'wishes']];
            }   
        }
      
        $this->validating($data);
        
        $order = new Order();
        $order = $order->add($data['carId']['value'], $data['countryId']['value'], $data['driverId']['value'], $data['passangerId']['value'], $data['regionId']['value'])->toArray();
        $orderId = (int) $order['order_id'];

        $orderDetails = new OrderDetails();
        $orderDetails = $orderDetails->add($orderId, $data['babyChair']['value'], $data['callMe']['value'], $data['comment']['value'], $data['deffered_payment']['value'], $data['duration']['value'],
            $data['extension']['value'], $data['large']['value'], $data['passCount']['value'], $data['passPhone']['value'], $data['pets']['value'], $data['startTime']['value'])->toArray();
       
        $orderPayments = new OrdersPayments();
        $orderPayments = $orderPayments->add($data['paymentTypeId']['value'], $orderId)->toArray();
        
        $usersMapPointOrders = new UsersMapPointOrders();
        $usersMapPointOrders = $usersMapPointOrders->add($data['userLocation'], $orderId, $data['passangerId']['value'])->toArray();

        $ordersMapPoints = new OrdersMapPoints();
        $ordersMapPoints = $ordersMapPoints->add($routePoints, $orderId);
        $ordersMapPointsArray = [];
        foreach ($ordersMapPoints as $ordersMapPoint) {
            $ordersMapPointsArray[] = $ordersMapPoint->toArray();
        }

        $orderWishes = new OrderWishes();
        $orderWishes = $orderWishes->add($wishes, $orderId);

        $resultArray =  array_merge($order, $orderDetails, $orderPayments, $usersMapPointOrders);
        $resultArray['ordersMapPoints'] = $ordersMapPointsArray;
        $resultArray['orderWishes'] = $orderWishes;

        return $this->sendWithSuccess('Order Create succesfully', $resultArray);
    }
    
}