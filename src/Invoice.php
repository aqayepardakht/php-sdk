<?php

namespace Aqayepardakht\PhpSdk;

class Invoice {
    private array $data = [];

    public function __construct(array $data) {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }

        $this->validate();
    }

    public function getItems(): array {
        return [
            "amount"        => $this->amount,
            "invoice_id"    => $this->invoice_id,
            "mobile"        => $this->phone,
            "email"         => $this->email,
            'description'   => $this->description,
            'callback'      => $this->callback,
            'cards'         => $this->cards,
            'name'          => $this->name,
            'national_code' => $this->national_code,
            'method'        => $this->method,
            'sms'           => $this->sms
        ];
    }

    public function validate(): void {
        $this->validateAmount();
        if (isset($this->cards))
            $this->validateCards();
        if (isset($this->phone))
            $this->validateMobile();
        if (isset($this->email))
            $this->validateEmail();
    }

    private function validateAmount(): void {
        $amount = floatval(Helper::faToEnNumbers($this->amount));

        if ($amount == 0 || $amount < 1000 || $amount >= 100000000) {
            throw new \Exception('مبلغ باید به صورت عددی و بیشتر از 1000 تومان و کمتر از  100,000,000 باشد');
        }
    }

    private function validateCards(): void {
        $cards = $this->card ?? [];

        if (!is_array($cards)) {
            $cards = [$cards];
        }

        foreach ($cards as $card) {
            Helper::validateCardsNumber($card);
        }
    }

    private function validateMobile(): void {
        Helper::validateMobileNumber($this->phone);
    }

    private function validateEmail(): void {
        Helper::validateEmail($this->email);
    }

    public function setTrackingCode($traceCode) {
        $this->traceCode = $traceCode;
    }

    public function getTrackingCode() {
        return $this->traceCode;
    }
}
