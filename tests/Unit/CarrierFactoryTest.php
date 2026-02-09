<?php

namespace Omniship\Tests\Unit;

use Omniship\Common\Contracts\CarrierInterface;
use Omniship\Common\Exception\RuntimeException;
use Omniship\Common\Factories\CarrierFactory;
use PHPUnit\Framework\TestCase;
use Omniship\Tests\Mock\Carrier\TestCarrierMock;
use Omniship\Tests\Mock\Carrier\FedexTestMock;
use Omniship\Tests\Mock\Carrier\UpsTestMock;
use Omniship\Tests\Mock\Carrier\UspsTestMock;
use Omniship\Tests\Mock\Carrier\DhlTestMock;
use Omniship\Tests\Mock\Carrier\TestRegisterMock;
use Omniship\Tests\Mock\Carrier\CaseInsensitiveMock;
use Omniship\Tests\Mock\Carrier\MultiCarrierOneMock;
use Omniship\Tests\Mock\Carrier\MultiCarrierTwoMock;

class CarrierFactoryTest extends TestCase
{
    public static function carrierDataProvider(): array
    {
        return [
            ['fedex', 'FedEx', FedexTestMock::class],
            ['ups', 'UPS', UpsTestMock::class],
            ['usps', 'USPS', UspsTestMock::class],
            ['dhl', 'DHL', DhlTestMock::class],
        ];
    }

    public function testConstructorWithEmptyDefinitions(): void
    {
        $factory = new CarrierFactory();

        $this->assertEmpty($factory->all());
    }

    public function testConstructorWithDefinitions(): void
    {
        $factory = new CarrierFactory(['test_carrier' => TestCarrierMock::class]);

        $this->assertNotEmpty($factory->all());
        $this->assertTrue($factory->has('test_carrier'));
    }

    /**
     * @dataProvider carrierDataProvider
     */
    public function testHasReturnsTrueForRegisteredCarrier(string $carrierName, string $displayName, string $mockClass): void
    {
        $factory = new CarrierFactory([$carrierName => $mockClass]);

        $this->assertTrue($factory->has($carrierName));
    }

    /**
     * @dataProvider carrierDataProvider
     */
    public function testHasReturnsFalseForUnregisteredCarrier(string $carrierName, string $displayName, string $mockClass): void
    {
        $factory = new CarrierFactory();

        $this->assertFalse($factory->has($carrierName));
    }

    /**
     * @dataProvider carrierDataProvider
     */
    public function testAllReturnsRegisteredCarrierNames(string $carrierName, string $displayName, string $mockClass): void
    {
        $factory = new CarrierFactory([$carrierName => $mockClass]);

        $allCarriers = $factory->all();

        $this->assertContains($carrierName, $allCarriers);
        $this->assertIsArray($allCarriers);
    }

    public function testRegisterMethod(): void
    {
        $factory = new CarrierFactory();

        // Since register doesn't return anything, we'll test by checking if the carrier is available afterwards
        $factory->register('test_register', TestRegisterMock::class);

        $this->assertTrue($factory->has('test_register'));
        $this->assertContains('test_register', $factory->all());
    }

    public function testRegisterWithNonExistentClass(): void
    {
        $factory = new CarrierFactory();

        // Register a non-existent class - this should not register the carrier
        $factory->register('non_existent', 'NonExistentClass');

        // The carrier should not exist since the class doesn't exist
        $this->assertFalse($factory->has('non_existent'));
    }

    public function testRegisterWithCaseInsensitiveName(): void
    {
        $factory = new CarrierFactory();
        $factory->register('TEST', CaseInsensitiveMock::class);

        // Test that it's accessible with different cases
        $this->assertTrue($factory->has('TEST'));
        $this->assertTrue($factory->has('test'));
        $this->assertTrue($factory->has('Test'));
    }

    public function testHasWithCaseInsensitiveLookup(): void
    {
        $factory = new CarrierFactory(['mycarrier' => CaseInsensitiveMock::class]);

        // Test case insensitive lookup
        $this->assertTrue($factory->has('MYCARRIER'));
        $this->assertTrue($factory->has('MyCarrier'));
        $this->assertTrue($factory->has('mycarrier'));
    }

    public function testAllReturnsEmptyArrayWhenNoCarriers(): void
    {
        $factory = new CarrierFactory();

        $this->assertEmpty($factory->all());
        $this->assertIsArray($factory->all());
    }

    public function testMultipleCarriersRegistration(): void
    {
        $factory = new CarrierFactory([
            'carrier_one' => MultiCarrierOneMock::class,
            'carrier_two' => MultiCarrierTwoMock::class
        ]);

        $allCarriers = $factory->all();

        $this->assertCount(2, $allCarriers);
        $this->assertContains('carrier_one', $allCarriers);
        $this->assertContains('carrier_two', $allCarriers);
        $this->assertTrue($factory->has('carrier_one'));
        $this->assertTrue($factory->has('carrier_two'));
    }

    public function testCreateReturnsInstanceOfCarrierInterface(): void
    {
        $factory = new CarrierFactory(['test_carrier' => TestCarrierMock::class]);

        $carrier = $factory->create('test_carrier');

        $this->assertInstanceOf(CarrierInterface::class, $carrier);
        $this->assertInstanceOf(TestCarrierMock::class, $carrier);
    }

    /**
     * @dataProvider carrierDataProvider
     */
    public function testCreateReturnsInstanceOfCarrierInterfaceFromDataProvider(string $carrierName, string $displayName, string $mockClass): void
    {
        $factory = new CarrierFactory([$carrierName => $mockClass]);

        $carrier = $factory->create($carrierName);

        $this->assertInstanceOf(CarrierInterface::class, $carrier);
        $this->assertInstanceOf($mockClass, $carrier);
    }

    public function testCreateThrowsExceptionForUnregisteredCarrier(): void
    {
        $factory = new CarrierFactory();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Carrier 'nonexistent' is not registered");

        $factory->create('nonexistent');
    }
}