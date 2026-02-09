<?php

namespace Omniship\Tests\Mock\Carrier;

use Omniship\Common\Contracts\CarrierInterface;

class MultiCarrierTwoMock implements CarrierInterface
{
    public function getShortName(): string
    {
        return 'MultiCarrierTwoMock';
    }

    public function getName(): string
    {
        return 'CarrierTwo';
    }
}