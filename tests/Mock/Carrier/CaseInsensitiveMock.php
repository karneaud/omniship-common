<?php

namespace Omniship\Tests\Mock\Carrier;

use Omniship\Common\Contracts\CarrierInterface;

class CaseInsensitiveMock implements CarrierInterface
{
    public function getShortName(): string
    {
        return 'CaseInsensitiveMock';
    }

    public function getName(): string
    {
        return 'CaseInsensitive';
    }
}