<?php
namespace Andrearc\LaravelMidtrans;
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


    function getSnap(){
        $params = array(
            'transaction_details' => $this->detail_transaction,
            'item_details' => $this->item_data,
            'customer_details' => $this->detail_customer
        );
        try {
             // Get Snap Payment Page URL
            $payment = \Midtrans\Snap::createTransaction($params);
            return array(
                'redirect_url' => $payment->redirect_url,
                'token' => $payment->token
            );
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
