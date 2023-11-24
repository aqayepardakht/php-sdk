<?php

namespace Aqayepardakht\PhpSdk;

use Aqayepardakht\Http\Response;
use Aqayepardakht\Http\Client;
use Aqayepardakht\PhpSdk\Helper;
use Aqayepardakht\PhpSdk\Services\Gateway\Gateway;
use Aqayepardakht\PhpSdk\Services\Gateway\GatewayService;
use Aqayepardakht\PhpSdk\Services\Account\AccountService;

class Api { 
    public function gateway($pin) {        
        return new GatewayService($pin);
    }

    public function account($accountNumber = null, $code = null) {
        if (!$accountNumber) $accountNumber = $this->config['account'];
        if (!$code)          $code          = $this->config['code'];

        return new AccountService($accountNumber, $code);
    }
}