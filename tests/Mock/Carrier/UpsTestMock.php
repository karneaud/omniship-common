<?php

namespace Omniship\Tests\Mock\Carrier;

use Omniship\Common\Contracts\CarrierInterface;

class UpsTestMock implements CarrierInterface
{
    public function getShortName(): string
    {
        return 'UpsTestMock';
    }

    public function getName(): string
    {
        return 'UPS';
    }
}