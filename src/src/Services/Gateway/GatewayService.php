<?php 

namespace Aqayepardakht\PhpSdk\Services\Gateway;

use Aqayepardakht\PhpSdk\Services\Pay\PaymentService;
use Aqayepardakht\PhpSdk\Services\Transaction\TransactionService;
use Aqayepardakht\PhpSdk\Invoice;

class GatewayService {
    private string $pin;

    public function __construct(string $pin) {
        $this->pin = $pin;
    } 

    public function invoice(Invoice | array $invoice): PaymentService {
        if (!($invoice instanceof Invoice))
            $invoice = new Invoice($invoice);

        return (new PaymentService($this->pin, $invoice));
    }

    public function transactions(): TransactionService {
        return new TransactionService();
    }

    public function setPin(string $pin): void {
        $this->pin = $pin;
    }

    public function getPin(): string {
        return $this->pin;
    }
}