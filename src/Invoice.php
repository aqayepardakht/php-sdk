<?php

namespace Aqayepardakht\PhpSdk;

use Aqayepardakht\PhpSdk\Helper;

class Invoice {
    private $amount;
    private $card;
    private $orderId;
    private $phone;
    private $email;
    private $description;
    private $callbackUrl;
    private $traceCode;

    public function __construct(array $data) {
        $this->setAmount($data['amount'] ?? 0)
             ->setCard($data['card'] ?? null)
             ->setOrderId($data['order_id'] ?? null)
             ->setPhone($data['phone'] ?? null)
             ->setEmail($data['email'] ?? null)
             ->setDescription($data['description'] ?? null)
             ->setCallback($data['callback_url'] ?? null);
    }

    public function getItems() {
        return [
            "amount"      => $this->getAmount(),
            "card_number" => $this->getCard(),
            "order_id"    => $this->getOrderId(),
            "mobile"      => $this->getPhone(),
            "email"       => $this->getEmail(),
            'description' => $this->getDescription(),
            'callback'    => $this->getCallback(),
            'trace_code'  => $this->getTraceCode(),
        ];
    }

    public function getAmount() {
        return $this->amount;
    }

    public function setAmount($amount) {
        $amount = floatval(Helper::faToEnNumbers($amount));

        if ($amount == 0 || $amount < 1000 || $amount >= 100000000) {
            throw new \Exception('مبلغ باید به صورت عددی و بیشتر از 1000 تومان و کمتر از  100,000,000 باشد');
        }

        $this->amount = $amount;

        return $this;
    }

    public function getCard() {
        return $this->card;
    }

    public function setCard($card) {
        Helper::validateCardsNumber($card);

        $this->card = $card;

        return $this;
    }

    public function getOrderId() {
        return $this->orderId;
    }

    public function setOrderId($orderId) {
        $this->orderId = $orderId;

        return $this;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        Helper::validateMobileNumber($phone);

        $this->phone = $phone;

        return $this;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        Helper::validateEmail($email);

        $this->email = $email;

        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    public function getCallback(): ?string {
        return $this->callbackUrl; 
    }

    public function setCallback($callbackUrl): self {
        $this->callbackUrl = $callbackUrl;
        return $this;
    }

    public function getTraceCode(): string {
        return $this->traceCode ?? '';
    }

    public function setTraceCode(string $code): self {
        $this->traceCode = $code;
        return $this;
    }
}
