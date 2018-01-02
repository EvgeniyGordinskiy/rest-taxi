<?php

namespace App\Mvc;

class DateTrackingModel extends \Phalcon\Mvc\Model
{
    public $createdAt;
    public $updatedAt;

    public function columnMap()
    {
        return [
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function beforeCreate()
    {
        $this->createdAt = date('Y-m-d H:i:s');
        $this->updatedAt = $this->createdAt;
    }

    public function beforeUpdate()
    {
        $this->updatedAt = date('Y-m-d H:i:s');
    }


    public function toArray($columns = NULL)
    {
        $array = parent::toArray();
        $result = [];
        foreach ($array as $key => $item) {
            $result[ lcfirst(basename(str_replace('\\','/', static::class))).'_'.$key] = $item;
        }

        return $result;
    }
 
}
