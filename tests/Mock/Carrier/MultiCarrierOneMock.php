<?php

namespace Omniship\Tests\Mock\Carrier;

use Omniship\Common\Contracts\CarrierInterface;

class MultiCarrierOneMock implements CarrierInterface
{
    public function getShortName(): string
    {
        return 'MultiCarrierOneMock';
    }

    public function getName(): string
    {
        return 'CarrierOne';
    }
}