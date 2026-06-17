<?php

namespace Aqayepardakht\PhpSdk\Services\Payment\Pol\Strategies;

use Aqayepardakht\PhpSdk\Enums\EndPoints;
class PolAuthorizeStrategy extends AbstractPolStrategy
{
    protected function endpointAction(): string
    {
        return 'authorize';
    }

    protected function getPaymentUrl(): string
    {
        return EndPoints::POl_PRODUCTION;
    }

    protected function onSuccess(object $response): array
    {
        return [
            'redirecturi' => $response->redirecturi
        ];
    }
}