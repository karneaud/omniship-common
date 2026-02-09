<?php

namespace Omniship\Tests\Unit;

use Omniship\Common\Contracts\ServiceInterface;
use Omniship\Tests\Mock\Carrier\TestableCarrierMock;
use Omniship\Tests\Mock\Carrier\ConcreteCarrierMock;
use Omniship\Tests\Mock\Service\TestServiceMock;
use PHPUnit\Framework\TestCase;

class AbstractCarrierTest extends TestCase
{
    public function testSupportsReturnsTrueForSupportedService(): void
    {
        $carrier = new TestableCarrierMock();

        $result = $carrier->supports('test_service_mock');

        $this->assertTrue($result);
    }
    public function testSupportsReturnsFalseForUnsupportedService(): void
    {
        $carrier = new TestableCarrierMock();

        $result = $carrier->supports('unsupported_service');

        $this->assertFalse($result);
    }

    public function testServiceMethodReturnsServiceInstanceForRegisteredService(): void
    {
        $carrier = new TestableCarrierMock();
        $parameters = ['foo' => 'value1', 'bar' => 'value2'];

        $service = $carrier->service('test_service_mock', $parameters);

        $this->assertInstanceOf(ServiceInterface::class, $service);
        $this->assertInstanceOf(TestServiceMock::class, $service);
        $this->assertEquals($parameters, $service->getParameters());
    }

    public function testServiceMethodCallsMockMethodAndReturnsServiceInstance(): void
    {
        $parameters = ['value1', ['foo' => 'bar', 'bar' => 'foo']];
        // Create a mock of the carrier to verify method calls
        $mock = $this->getMockBuilder(TestableCarrierMock::class)
            ->addMethods(['testServiceMock'])
            ->getMock();
        // Set up expectations for the method call
        $mock->expects($this->once())
            ->method('testServiceMock')
            ->with(...$parameters)
            ->willReturn((new TestServiceMock($mock))->initialize($parameters[1]));
        // Since the service method calls the testServiceMock method internally,
        // this will trigger the expectation
        $service = $mock->service('test_service_mock', $parameters);
        $this->assertInstanceOf(ServiceInterface::class, $service);
        $this->assertInstanceOf(TestServiceMock::class, $service);
        $this->assertEquals($parameters[1], $service->getParameters());
    }
}