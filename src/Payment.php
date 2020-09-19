<?php
namespace Andrearc\LaravelMidtrans;

use Exception;
use \Midtrans;
use Item;

/**
 * Payment.
 *
 */
class Payment {
    private $detail_transaction = [];
    private $detail_customer = [];
    private $item_data = [];

    function __construct()
    {
        // Set your Merchant Server Key
        Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY', '');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Midtrans\Config::$isProduction = env('MIDTRANS_PRODUCTION', 'false') === 'true';
        // Set sanitization on (default)
        Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        Midtrans\Config::$is3ds = true;
    }

    function setTransactionDetail(array $data){
        $this->detail_transaction = $data;
    }

    function setCustomerDetail(array $data){
        $this->detail_customer = $data;
    }

    /**
     * @param Item[] $items
     */
    function setItemData(array $items){
        foreach($items as $item){
            if(is_object($item)){
                array_push($this->item_data, (array) $item );
            }
        }
    }

    /**
     * @return object $data(token and redirect_url).
     *
     */
    function getSnap(){
        if(empty($this->detail_transaction)){
            throw new Exception('Transaction Details Must be set');
        }

        if(empty($this->item_data)){
            throw new Exception('Item Data Must be set');
        }

        if(empty($this->detail_customer)){
            throw new Exception('Customer Details Must be set');
        }

        $params = array(
            'transaction_details' => $this->detail_transaction,
            'item_details' => $this->item_data,
            'customer_details' => $this->detail_customer
        );

        echo json_encode($params);
        try {
             // Get Snap Payment Page URL
            $payment = \Midtrans\Snap::createTransaction($params);
            return $payment;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
