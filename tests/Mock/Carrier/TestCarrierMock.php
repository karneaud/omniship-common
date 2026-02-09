<?php

namespace Omniship\Tests\Mock\Carrier;

use Omniship\Common\Abstracts\AbstractCarrier;

class TestCarrierMock extends AbstractCarrier
{
    public function getName(): string
    {
        return 'Test Carrier';
    }

    public function getShortName(): string
    {
        return 'test';
    }
}