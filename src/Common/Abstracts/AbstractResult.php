<?php
/**
 * Abstract Result class
 */

namespace Omniship\Common\Abstracts;

use Omniship\Common\Traits\ParameterBag;
use Omniship\Common\Contracts\ResultInterface;

/**
 * Abstract Result class
 *
 * This abstract class should be extended by all service results
 * throughout the Omniship system. It enforces implementation of
 * the ResultInterface interface and defines various common attributes
 * and methods that all results should have.
 */
abstract class AbstractResult implements ResultInterface
{
   
    use ParametersTrait;

    /**
     * @var string|null
     */
    protected $error_message = null;

    /**
     * @var bool
     */
    protected $successful;

    /**
     * Create a new result instance
     *
     * @param mixed $data
     * @param bool $successful
     * @param string|null $error_message
     */
    public function __construct(?array $data = null, $successful = true, $error_message = null)
    {
        $this->successful = $successful;
        $this->error_message = $error_message;
        $this->initialize($data);
    }

    /**
     * Check if the result is successful
     *
     * @return bool
     */
    public function isSuccessful() : bool
    {
        return $this->successful;
    }

    /**
     * Get the data from the result
     *
     * @return mixed
     */
    public function getData() : array
    {
        return $this->getParameters();
    }

    /**
     * Get any error message from the result
     *
     * @return string|null
     */
    public function getErrorMessage()
    {
        return $this->error_message;
    }
}