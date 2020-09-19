<?php
namespace Andrearc\LaravelMidtrans;
use Error;

class Item {
    public $id;
    public $price;
    public $quantity;
    public $name;
    public $brand;
    public $category;
    public $merchant_name;

    function __construct(array $data)
    {
        if(!array_key_exists('price', $data)){
            throw new Error('field price must not empty');
        }
        if(!array_key_exists('quantity', $data)){
            throw new Error('field quantity must not empty');
        }
        if(!array_key_exists('name', $data)){
            throw new Error('field name must not empty');
        }

        foreach($data as $key => $value){
            $validate_property = array('id', 'price', 'quantity', 'name', 'brand', 'category', 'merchant_name');

            if(in_array($key, $validate_property)){
                $this->$key = $value;
            }
        }

    }
}
