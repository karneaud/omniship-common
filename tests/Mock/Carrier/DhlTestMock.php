<?php

namespace Omniship\Tests\Mock\Carrier;

use Omniship\Common\Contracts\CarrierInterface;

class DhlTestMock implements CarrierInterface
{
    public function getShortName(): string
    {
        return 'DhlTestMock';
    }

    public function getName(): string
    {
        return 'DHL';
    }
}