<?php
/**
 * Cart Item interface
 */

namespace Omniship\Common;

/**
 * Cart Item interface
 *
 * This interface defines the functionality that all cart items in
 * the Omniship system are to have.
 */
interface ItemInterface
{
    public function getWeight() : float;
    public function getHeight() : float;
    public function getWidth() : float;
}
