<?php
namespace Omniship\Common\Factories;

use InvalidArgumentException;
use Omniship\Common\Contracts\CarrierInterface;
use Omniship\Common\Exception\RuntimeException;

final class CarrierFactory
{
    /**
     * @var array<string, class-string<CarrierInterface>>
     */
    private array $carriers = [];

    /**
     * @param array<string, class-string<CarrierInterface>> $carriers
     */
    public function __construct(array $carriers = [])
    {
        foreach ($carriers as $name => $class) {
            $this->register($name, $class);
        }
    }

    /**
     * Add a carrier to the factory
     */
    public function register(string $name, string $class_name ): void
    {
        if(class_exists($class_name)) {
            $this->carriers[strtolower($name)] = $class_name;
        }
    }

    /**
     * @return string[]
     */
    public function all(): array
    {
        return array_keys($this->carriers);
    }

    public function has(string $name): bool
    {
        $name = strtolower($name);
        return isset($this->carriers[$name]) && class_exists($this->carriers[$name]);
    }

    public function create(string $name, array $parameters = []): CarrierInterface
    {
        $name = strtolower($name);
        if (!$this->has($name)) {
            throw new RuntimeException("Carrier '{$name}' is not registered");
        }

        $class = $this->carriers[$name];
        /** @var CarrierInterface $carrier */
        $carrier = new $class(...$parameters);
        if (method_exists($carrier, 'initialize')) {
            $carrier->initialize($parameters);
        }

        return $carrier;
    }
}
