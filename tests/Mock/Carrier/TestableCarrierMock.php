<?php

namespace Omniship\Tests\Mock\Carrier;

use Omniship\Tests\Mock\Service\TestServiceMock;

class TestableCarrierMock extends ConcreteCarrierMock
{
    protected array $services = [
        'test_service_mock' => TestServiceMock::class
    ];
}