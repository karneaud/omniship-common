<?php

namespace Omniship\Common\Abstracts;

use Omniship\Common\Helper;
use Omniship\Common\Traits\ParametersTrait;
use Omniship\Common\Factories\ServiceFactory;
use Omniship\Common\Contracts\CarrierInterface;
use Omniship\Common\Contracts\ServiceInterface;
use Omniship\Common\Contracts\DataSourceInterface;

/**
 * Base shipping carrier class (refactored)
 *
 * Responsibilities:
 *  - Hold configuration & parameters
 *  - Declare identity
 *  - Declare supported services
 *  - Provide DataSource access
 *
 * It does NOT:
 *  - Instantiate services
 *  - Call facades
 *  - Perform reflection-based capability checks
 */
abstract class AbstractCarrier implements CarrierInterface
{
    use ParametersTrait {
        initialize as protected init;
        setParameter as protected setPproperty;
    }

    /**
     * @var DataSourceInterface|null
     */
    protected ?DataSourceInterface $dataSource = null;

    /**
     * Default parameters for the carrier
     */
    protected array $default_parameters = [];

    /**
     * Explicit service registry
     *
     * @var array<string, class-string<ServiceInterface>>
     */
    protected array $services = [];

    /**
     * @param DataSourceInterface|null $dataSource
     */
    public function __construct(?DataSourceInterface $dataSource = null)
    {
        $this->dataSource = $dataSource;
    }

    public function setParameter(string $key, $value) {

        $this->setProperty($key, $value);

        return $this;
    }

    /**
     * Human-readable carrier name
     */
    abstract public function getName(): string;

    /**
     * Stable carrier identifier (e.g. "fedex", "dhl")
     *
     * MUST NOT depend on class name.
     */
    abstract public function getShortName(): string;

    /**
     * Initialize carrier parameters
     */
    public function initialize(array $parameters = []): static
    {
        $this->init($parameters + $this->getDefaultParameters());

        return $this;
    }
    /**
     * @return array
     */
    public function getDefaultParameters(): array
    {
        return $this->default_parameters;
    }

    /**
     * @return DataSourceInterface|null
     */
    public function getDataSource(): ?DataSourceInterface
    {
        return $this->dataSource;
    }

    /**
     * @return string[]
     */
    public function getSupportedServices(): array
    {
        return array_keys($this->services);
    }

    /**
     * Explicit capability check
     */
    private function supportsService(string $service): bool
    {
        return isset($this->services[$service]) || method_exists($this, $service );
    }

    private function getServiceClass(string $service): string
    {
        return $this->services[$service];
    }

    /**
     * Protected service creator
     *
     * Domain-friendly delegation to ServiceFactory.
     */
    private function createService(
        string $service,
        array $parameters = []
    ): ?ServiceInterface {
        // First, check if the carrier has a method with the service name
        if (method_exists($this, $service_method = Helper::camelCase($service))) {
            // Call the method with the parameters
            return call_user_func_array([$this,$service_method], $parameters);
        }

        // If not, check if the carrier supports the service
        if ($this->supports($service)) {
            // Delegate to ServiceFactory with the service name (not class name)
            $service = $this->getServiceClass($service);
            return ServiceFactory::create($this, $service, $parameters);
        }

        // If neither condition is met, return null
        return null;
    }

    public function service(string $name, array $parameters = []) : ?ServiceInterface {
        return $this->createService($name, $parameters);
    }

    /**
     * Public capability check
     */
    public function supports(string $service): bool
    {
        return $this->supportsService($service);
    }
}
