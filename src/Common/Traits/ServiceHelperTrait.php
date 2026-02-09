<?php
/**
 * Service-related helper methods
 */

namespace Omniship\Common\Traits;

use Stringy\Stringy as S;
use Omniship\Common\Helper;
/**
 * Trait for service-related helper methods
 */
trait ServiceHelperTrait 
{
    use CarrierHelperTrait;

    /**
     * Get the service class name for a carrier.
     *
     * @param string $carrier_class The carrier class name
     * @param string $service_name The service name (e.g. 'tracking', 'shipment', 'rates')
     * @return string The fully namespaced service class name
     */
    public static function getServiceClassName($carrier_class, $service_name)
    {
        $carrier_short_name = static::getCarrierShortName($carrier_class);
        $formatted_service_name = (string) S::create($service_name)->camelize()->upperCaseFirst()->append('Service');

        return "\\Omniship\\{$carrier_short_name}\\Services\\{$formatted_service_name}";
    }

    /**
     * Get the service name from a service class name.
     *
     * Examples:
     * "Omniship\Domain\Services\TestService" => "Test"
     *
     * @param string $class_name The service class name
     * @return string The service name
     */
    public static function getServiceName($class_name)
    {
        $stringy = Helper::normalizeClassName($class_name);

        // Split on backslashes
        $parts = explode('\\', (string)$stringy);
        $serviceName = end($parts);

        return rtrim($serviceName, 'Service');
    }
}