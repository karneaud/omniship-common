<?php
/**
 * Abstract Service class
 */

namespace Omniship\Common\Abstracts;

use Omniship\Common\Contracts\CarrierInterface;
use Omniship\Common\Contracts\ServiceInterface;
use Omniship\Common\Traits\ParametersTrait;

/**
 * Abstract Service class
 *
 * This abstract class should be extended by all services
 * throughout the Omniship system. It enforces implementation of
 * the ServiceInterface interface and defines various common attributes
 * and methods that all services should have.
 */
abstract class AbstractService implements ServiceInterface
{
    use ParametersTrait {
        initialize as protected init;
        setParameter as protected setProperty;
    }

    /**
     * @var CarrierInterface
     */
    protected CarrierInterface $carrier;

    /**
     * Create a new service instance
     *
     * @param CarrierInterface $carrier A carrier implementation
     */
    public function __construct(CarrierInterface $carrier, array $parameters = [])
    {
        $this->carrier = $carrier;
        $this->initialize($parameters);
    }

    public function setParameter (string $key, $value) {
        $this->setProperty($key, $value);

        return $this;
    }

    public function getCarrier() : CarrierInterface {
        return $this->carrier;
    }

    /**
     * Initialize this carrier with default parameters
     *
     * @param  array $parameters
     * @return $this
     */
    public function initialize(array $parameters = array())
    {
        
        $this->init($parameters + $this->getDefaultParameters());

        return $this;
    }
}