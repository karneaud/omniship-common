<?php
/**
 * Result Interface
 */

namespace Omniship\Common\Contracts;

/**
 * Result Interface
 *
 * This interface defines the contract that all service results must implement.
 */
interface ResultInterface
{
    /**
     * Get the data from the result
     *
     * @return array
     */
    public function getData() : array;

}