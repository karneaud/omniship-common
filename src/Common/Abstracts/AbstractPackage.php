<?php
/**
 * Cart Item
 */

namespace Omniship\Common;

use Omniship\Common\Helper;
use Omniship\Common\Traits\ParametersTrait;
use Omniship\Common\Interfaces\ItemInterface;
/**
 * Package Item
 *
 * This abstract class defines base structure for a shipping parcel/ package/ box in the Omniship system.
 *
 * @see ItemInterface
 */
abstract class AbstractPackage implements ItemInterface
{
    use ParametersTrait {
       initialize as protected setup;
    }

    /**
     * Initialize this carrier with default parameters
     *
     * @param  array $parameters
     * @return $this
     */
    public function initialize(array $parameters = array())
    {
        
        $this->setup($parameters);

        return $this;
    }
    /**
     * Create a new item with the specified parameters
     *
     * @param array|null $parameters An array of parameters to set on the new object
     */
    public function __construct(array $properties = null)
    {
        $this->initialize($properties);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->getParameter('name');
    }

    /**
     * Set the item name
     */
    public function setName($value)
    {
        return $this->setParameter('name', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getWeight(): float
    {
        return (float) $this->getParameter('weight');
    }

    /**
     * Set the item weight
     */
    public function setWeight(float $value)
    {
        return $this->setParameter('weight', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getWidth(): float
    {
        return (float) $this->getParameter('width');
    }

    /**
     * Set the item width
     */
    public function setWidth(float $value)
    {
        return $this->setParameter('width', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getHeight(): float
    {
        return (float) $this->getParameter('height');
    }

    /**
     * Set the item height
     */
    public function setHeight(float $value)
    {
        return $this->setParameter('height', $value);
    }
}
