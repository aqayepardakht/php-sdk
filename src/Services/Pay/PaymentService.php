<?php

namespace Aqayepardakht\PhpSdk\Services\Pay;

use Aqayepardakht\Http\Client;
use Aqayepardakht\PhpSdk\Helper;
use Aqayepardakht\PhpSdk\Invoice;
use Aqayepardakht\PhpSdk\Interfaces\PaymentStrategy;

use Aqayepardakht\PhpSdk\Strategy\{
    CreatePaymentStrategy,
    VerifyPaymentStrategy,
    StartPaymentStrategy
};

class PaymentService {
    private string $pin;
    private PaymentStrategy $paymentStrategy;
    public Invoice $invoice;

    public function __construct(string $pin, Invoice $invoice) {
        $this->pin     = $pin;
        $this->invoice = $invoice;
    }

    public function create(): self {
        $this->setStrategy(new CreatePaymentStrategy($this->pin, $this->invoice));

        $trackingCode = $this->process();

        $this->invoice->setTraceCode($trackingCode);

        return $this;
    }

    public function verify(string $traceCode): self {
        $this->setStrategy(new VerifyPaymentStrategy($this->pin, $traceCode, $this->invoice->getAmount()));
        $this->process();
        return $this;
    }

    public function start($trackingCode = null): self {
        if (!$trackingCode) $trackingCode = $this->invoice->getTraceCode();

        $this->setStrategy(new StartPaymentStrategy($trackingCode));
        $this->process();
    }

    public function setStrategy(PaymentStrategy $strategy): self {
        $this->paymentStrategy = $strategy;
        return $this;
    }

    public function process() {
        return $this->paymentStrategy->process();
    }

    public function getAction(): string {
        return $this->paymentStrategy->getAction();
    }
}