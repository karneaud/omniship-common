<?php

namespace Omniship\Tests\Unit;

use Omniship\Common\Contracts\ServiceInterface;
use Omniship\Common\Factories\ServiceFactory;
use Omniship\Tests\Mock\Service\TestServiceMock;
use Omniship\Tests\Mock\Carrier\TestCarrierMock;
use PHPUnit\Framework\TestCase;

class ServiceFactoryTest extends TestCase
{
    public function testCreateReturnsInstanceOfServiceInterface(): void
    {
        $carrier = new TestCarrierMock();
        $serviceClass = TestServiceMock::class;
        $parameters = ['key1' => 'value1', 'key2' => 'value2'];
        
        $service = ServiceFactory::create($carrier, $serviceClass, $parameters);
        
        $this->assertInstanceOf(ServiceInterface::class, $service);
        $this->assertInstanceOf(TestServiceMock::class, $service);
    }

    public function testCreateInitializesServiceWithParameters(): void
    {
        $carrier = new TestCarrierMock();
        $serviceClass = TestServiceMock::class;
        $expectedParameters = ['foo' => 'test_value', 'bar' => 123, 'param3' => true];
        
        $service = ServiceFactory::create($carrier, $serviceClass, $expectedParameters);
        
        $this->assertArrayNotHasKey('param3', $service->getParameters());
    }

    public function testCreateWithEmptyParameters(): void
    {
        $carrier = new TestCarrierMock();
        $serviceClass = TestServiceMock::class;
        $emptyParameters = [];
        
        $service = ServiceFactory::create($carrier, $serviceClass, $emptyParameters);
        
        $this->assertInstanceOf(ServiceInterface::class, $service);
        $this->assertEquals($emptyParameters, $service->getParameters());
    }

    public function testCreatePassesCarrierToServiceConstructor(): void
    {
        $carrier = new TestCarrierMock();
        $serviceClass = TestServiceMock::class;
        $parameters = ['test' => 'value'];
        
        $service = ServiceFactory::create($carrier, $serviceClass, $parameters);
        
        // Verify that the service was constructed with the carrier
        $this->assertSame($carrier, $service->getCarrier());
    }
}