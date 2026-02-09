<?php

namespace Omniship\Tests\Mock\Service;

use Omniship\Common\Traits\ParametersTrait;
use Omniship\Common\Abstracts\AbstractService;
use Omniship\Common\Contracts\ServiceInterface;
use Omniship\Common\Contracts\CarrierInterface;

class TestServiceMock extends AbstractService implements ServiceInterface
{
    use ParametersTrait {
        initialize as protected init;
        setParameter as setProperty;
    }
    
    protected CarrierInterface $carrier;

    public function __construct(CarrierInterface $carrier)
    {
        $this->carrier = $carrier;
    }

    public function getCarrier(): CarrierInterface
    {
        return $this->carrier;
    }

    public function initialize(array $parameters = [] ) {
        $this->init($parameters);
        
        return $this;
    }

    public function setParameter(string $key, $value) {
        $this->setProperty($key, $value);

        return $this;
    }

    public function setFoo($value) {
        $this->setParameter('foo', $value);

        return $this;
    }

    public function setBar($value) {
        $this->setParameter('bar', $value);

        return $this;
    }
}