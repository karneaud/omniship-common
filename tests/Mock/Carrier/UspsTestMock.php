<?php

namespace Omniship\Tests\Mock\Carrier;

use Omniship\Common\Contracts\CarrierInterface;

class UspsTestMock implements CarrierInterface
{
    public function getShortName(): string
    {
        return 'UspsTestMock';
    }

    public function getName(): string
    {
        return 'USPS';
    }
}