<?php

namespace Omniship\Tests\Unit;

use Omniship\Omniship;
use Omniship\Common\Factories\CarrierFactory;
use Omniship\Tests\Mock\Carrier\DhlTestMock;
use Omniship\Tests\Mock\Carrier\FedexTestMock;
use Omniship\Tests\Mock\Carrier\TestableCarrierMock;
use PHPUnit\Framework\TestCase;

class OmnishipTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Reset the factory to ensure clean state
        Omniship::setFactory(null);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        
        // Reset the factory after test
        Omniship::setFactory(null);
    }

    public function testCanRegisterCarriers(): void
    {
        // Register the required mock carriers
        Omniship::register('dhl', DhlTestMock::class);
        Omniship::register('fedex', FedexTestMock::class);
        Omniship::register('testable', TestableCarrierMock::class);

        // Verify that the carriers are registered in the factory
        $factory = Omniship::getFactory();
        
        $this->assertTrue($factory->has('dhl'));
        $this->assertTrue($factory->has('fedex'));
        $this->assertTrue($factory->has('testable'));
    }

    public function testCanCheckIfCarrierExists(): void
    {
        // Initially, carriers shouldn't exist
        $this->assertFalse(Omniship::has('dhl'));
        $this->assertFalse(Omniship::has('fedex'));
        $this->assertFalse(Omniship::has('testable'));

        // Register the carriers
        Omniship::register('dhl', DhlTestMock::class);
        Omniship::register('fedex', FedexTestMock::class);
        Omniship::register('testable', TestableCarrierMock::class);

        // Now they should exist
        $this->assertTrue(Omniship::has('dhl'));
        $this->assertTrue(Omniship::has('fedex'));
        $this->assertTrue(Omniship::has('testable'));
    }

    public function testCanCreateCarrierInstances(): void
    {
        // Register the carriers
        Omniship::register('dhl', DhlTestMock::class);
        Omniship::register('fedex', FedexTestMock::class);
        Omniship::register('testable', TestableCarrierMock::class);

        // Create instances
        $dhl = Omniship::create('dhl');
        $fedex = Omniship::create('fedex');
        $testable = Omniship::create('testable');

        // Assert that the instances are of the correct type
        $this->assertInstanceOf(DhlTestMock::class, $dhl);
        $this->assertInstanceOf(FedexTestMock::class, $fedex);
        $this->assertInstanceOf(TestableCarrierMock::class, $testable);
    }

    public function testGetAllRegisteredCarriers(): void
    {
        // Register the carriers
        Omniship::register('dhl', DhlTestMock::class);
        Omniship::register('fedex', FedexTestMock::class);
        Omniship::register('testable', TestableCarrierMock::class);

        // Get all registered carriers
        $allCarriers = Omniship::all();

        // Assert that the carriers are in the list
        $this->assertContains('dhl', $allCarriers);
        $this->assertContains('fedex', $allCarriers);
        $this->assertContains('testable', $allCarriers);
    }

    public function testFactoryIsProperlyInitialized(): void
    {
        // Get the factory instance
        $factory = Omniship::getFactory();

        // Assert that it's an instance of CarrierFactory
        $this->assertInstanceOf(CarrierFactory::class, $factory);

        // Verify it's the same instance when called again
        $factory2 = Omniship::getFactory();
        $this->assertSame($factory, $factory2);
    }

    public function testSetFactoryWorks(): void
    {
        // Create a new factory instance
        $newFactory = new CarrierFactory([
            'dhl' => DhlTestMock::class,
            'fedex' => FedexTestMock::class,
        ]);

        // Set it as the factory
        Omniship::setFactory($newFactory);

        // Get the factory and verify it's the same instance
        $currentFactory = Omniship::getFactory();
        $this->assertSame($newFactory, $currentFactory);

        // Verify the carriers are registered
        $this->assertTrue(Omniship::has('dhl'));
        $this->assertTrue(Omniship::has('fedex'));
    }
}