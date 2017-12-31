<?php

namespace App\Model;

class UsersWishes extends \App\Mvc\DateTrackingModel
{
    public $id;
    public $userId;
    public $wishId;
    public $createdAt;
    public $updatedAt;

    public function getSource()
    {
        return 'users_wishes';
    }

    public function columnMap()
    {
        return parent::columnMap() + [
            'id' => 'id',
            'user_id' => 'userId',
            'wish_id' => 'wishId',
        ];
    }

    public function initialize() {

        $this->belongsTo('user_id', User::class, 'id', [
            'alias' => 'user',
        ]);
        $this->belongsTo('wish_id', Wish::class, 'id', [
            'alias' => 'wish',
        ]);
    }
}
