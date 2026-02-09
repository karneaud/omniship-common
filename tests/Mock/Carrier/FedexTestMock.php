<?php

namespace Omniship\Tests\Mock\Carrier;

use Omniship\Common\Contracts\CarrierInterface;

class FedexTestMock implements CarrierInterface
{
    public function getShortName(): string
    {
        return 'FedexTestMock';
    }

    public function getName(): string
    {
        return 'FedEx';
    }
}