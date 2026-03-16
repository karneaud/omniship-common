<?php

namespace Omniship\Common\Factories;

use Omniship\Common\Contracts\CarrierInterface;
use Omniship\Common\Contracts\ServiceInterface;
use Omniship\Common\Exception\RuntimeException;

/**
 * Service Factory (refactored)
 *
 * Single responsibility:
 *  - Create & initialize services for a carrier
 */
final class ServiceFactory
{
    /**
     * Create a service instance for a carrier
     */
    public static function create(
        CarrierInterface $carrier,
        string $service,
        array $parameters = []
    ): ?ServiceInterface {
       
        /** @var ServiceInterface $instance */
        $instance = new $service($carrier, ...$parameters );
        if (method_exists($instance, 'initialize')) {
            $instance->initialize($parameters);
        }

        return $instance;
    }
}
