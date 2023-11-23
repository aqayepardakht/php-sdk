<?php 

namespace Aqayepardakht\PhpSdk\Strategy;

use Aqayepardakht\Http\Client;
use Aqayepardakht\PhpSdk\Helper;
use Aqayepardakht\PhpSdk\Invoice;
use Aqayepardakht\PhpSdk\Interfaces\PaymentStrategy;

class CreatePaymentStrategy implements PaymentStrategy {
    /**
     * gateway pin
     *
     * @var string
    */
    protected $pin;

    /**
     * Invoice object
     *
     * @var Invoice
    */
    protected $invoice;

    public function __construct(string $pin, Invoice $invoice) {
        $this->pin     = $pin;
        $this->invoice = $invoice;
    }

    public function process() {
        Helper::validateUrl($this->invoice->getCallback());

        $params        = $this->invoice->getItems();
        $params["pin"] = $this->pin;

        $response = (new Client())->post(Helper::getBaseUrl('pay'), $params);

        $response = $response->json();

        if ($response->status == 'error')  
            throw new \Exception("Error: ".$response->message, $response->code);
        
        return $response->tracking_code;   
    }

    public function getAction(): string {
        return 'create';
    }
}