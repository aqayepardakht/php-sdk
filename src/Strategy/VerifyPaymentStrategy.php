<?php

namespace Aqayepardakht\PhpSdk\Strategy;

use Aqayepardakht\Http\Client;
use Aqayepardakht\PhpSdk\Helper;
use Aqayepardakht\PhpSdk\Interfaces\PaymentStrategy;

class VerifyPaymentStrategy implements PaymentStrategy {
    /**
     * gateway pin
     *
     * @var string
    */
    protected $pin;

    /**
     * Payment Trace Code
     *
     * @var String
    */
    protected $traceCode;
    protected $amount;

    public function __construct($pin, $traceCode, $amount) {
        $this->pin        = $pin;
        $this->traceCode  = $traceCode;
        $this->amount     = $amount;
    }

    public function process() {
        $params            = [];
        $params["pin"]     = $this->pin;
        $params['transid'] = $this->traceCode;
        $params['amount']  = $this->amount;
        
        $response = (new Client())->post(Helper::getBaseUrl('verify'), $params);
        $response = $response->json();

        if (!$response)
            throw new \Exception("Error: مشکلی در اتصال به آقای پرداخت وجود دارد لطفا دوباره تلاش کنید", 0);

        if ($response->status == 'error') 
            throw new \Exception("Error: ".$response->message, $response->code);
        
        
        return $response;
    }

    public function getAction(): string {
        return 'verify';
    }
}