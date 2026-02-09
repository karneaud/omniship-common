<?php

namespace Omniship\Tests\Mock\Carrier;

use Omniship\Common\Contracts\CarrierInterface;

class TestRegisterMock implements CarrierInterface
{
    public function getShortName(): string
    {
        return 'TestRegisterMock';
    }

    public function getName(): string
    {
        return 'TestRegister';
    }
}