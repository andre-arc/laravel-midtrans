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

    /**
     * Class constructor.
     *
     * @param array $data Array containing the necessary params.
     *    $data = [
     *      'id'            => (string) Item Id. Optional.
     *      'price'         => (int) Item Price. Required.
     *      'quantity'      => (int) Item Quantity. Required.
     *      'name'          => (string) Item Name. Required.
     *      'brand'         => (string) Item Brand. Optional.
     *      'category'      => (string) Item Category. Optional.
     *      'merchant_name' => (string) Merchant Name. Optional.
     *    ]
     */
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
