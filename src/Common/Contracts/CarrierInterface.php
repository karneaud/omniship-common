<?php
/**
 * Shipping carrier interface
 */

namespace Omniship\Common\Contracts;

/**
 * Shipping carrier interface
 *
 * This interface class defines the standard functions that any
 * Omniship carrier needs to define.
 *
 * @see AbstractCarrier
 *
 */
interface CarrierInterface
{
    /**
     * Get carrier display name
     *
     * This can be used by carts to get the display name for each carrier.
     * @return string
     */
    public function getShortName() : string;

    /**
     * Get carrier short name
     *
     * This name can be used with CarrierFactory as an alias of the carrier class,
     * to create new instances of this carrier.
     * @return string
     */
    public function getName() : string;
}
