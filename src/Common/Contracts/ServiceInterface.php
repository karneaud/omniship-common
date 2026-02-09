<?php
/**
 * Service Interface
 */

namespace Omniship\Common\Contracts;

/**
 * Service Interface
 *
 * This interface defines the contract that all services must implement.
 */
interface ServiceInterface
{
    /**
     * Initialize the service with parameters
     *
     * @param array $parameters
     * @return mixed
     */
    public function initialize(array $parameters = []);

    /**
     * Get the parameters of the service
     *
     * @return array
     */
    public function getParameters() : array;

    /**
     * Set a parameter
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function setParameter(string $key, $value);
}