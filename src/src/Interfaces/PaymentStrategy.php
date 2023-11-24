<?php 

namespace Aqayepardakht\PhpSdk\Interfaces;

interface PaymentStrategy {
    public function process();
    public function getAction(): string;
}