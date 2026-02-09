<?php

namespace Omniship\Tests\Mock\Carrier;

use Omniship\Common\Abstracts\AbstractCarrier;
use Omniship\Tests\Mock\Service\TestServiceMock;
use Omniship\Common\Contracts\ServiceInterface;

class ConcreteCarrierMock extends AbstractCarrier
{
    public function getName(): string
    {
        return 'Concrete Test Carrier';
    }

    public function getShortName(): string
    {
        return 'concrete_test';
    }
}