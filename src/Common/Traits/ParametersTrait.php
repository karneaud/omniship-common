<?php

namespace Omniship\Common\Traits;

use Omniship\Common\Helper;
use Omniship\Common\Objects\ParameterBag;
use Omniship\Common\Exception\InvalidRequestException;

trait ParametersTrait
{
    /**
     * Internal storage of all of the parameters.
     *
     * @var ParameterBag
     */
    protected $parameters;

    /**
     * Set one parameter.
     *
     * @param string $key Parameter key
     * @param mixed $value Parameter value
     */
    protected function setParameter($key, $value)
    {
        $this->parameters->set($key, $value);
    }

    public function hasParameter($key, $value = null) : bool {
        return (bool) $this->parameters->has($key, $value);
    }

    /**
     * Get one parameter.
     *
     * @return mixed A single parameter value.
     */
    protected function getParameter($key)
    {
        return $this->parameters->get($key);
    }

    /**
     * Get all parameters.
     *
     * @return array An associative array of parameters.
     */
    public function getParameters() : array
    {
        return $this->parameters->all();
    }

    /**
     * Initialize the object with parameters.
     *
     * If any unknown parameters passed, they will be ignored.
     *
     * @param array $parameters An associative array of parameters
     * @return $this.
     */
    public function initialize(array $parameters = [])
    {
        $this->parameters = new ParameterBag;
        Helper::initialize($this, $parameters);
    }

    /**
     * Validate the request.
     *
     * This method is called internally by gateways to avoid wasting time with an API call
     * when the request is clearly invalid.
     *
     * @param string ... a variable length list of required parameters
     * @throws InvalidRequestException
     */
    public function validate(...$args)
    {
        foreach ($args as $key) {
            $value = $this->parameters->get($key);
            if (! isset($value)) {
                throw new InvalidRequestException("The $key parameter is required");
            }
        }
    }
}
