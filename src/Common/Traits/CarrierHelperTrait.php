<?php
/**
 * Carrier-related helper methods
 */

namespace Omniship\Common\Traits;

use Stringy\Stringy as S;
use Omniship\Common\Helper;
/**
 * Trait for carrier-related helper methods
 */
trait CarrierHelperTrait
{
   

    /**
     * Get the carrier class name from a short name.
     *
     * Examples:
     * "Common" => "Omniship\Common\Carrier"
     * "common" => "Omniship\common\Carrier"
     * "Common_Carrier" => "Omniship\Common\Carrier"
     *
     * @param string $short_name The short carrier name
     * @return string The fully namespaced carrier class name
     */
    public static function getCarrierClassName($short_name)
    {
        $stringy = S::create($short_name);

        if ($stringy->startsWith('\\')) {
            return (string) $stringy;
        }

        $stringy = $stringy->replace('_', '\\');

        if (!$stringy->endsWith('Carrier')) {
            $stringy = $stringy->append('\\Carrier');
        }

        return (string) $stringy->prepend('\\Omniship\\');
    }

    /**
     * Get the short name from a carrier class name.
     *
     * Examples:
     * "Omniship\Common\Carrier" => "Common"
     * "Omniship\Common_Carrier" => "Common"
     * "\Omniship\Common\Carrier" => "Common"
     * "Omniship\Domain\Services\Service" => "Domain"
     *
     * @param string $class_name The carrier class name
     * @return string The short name
     */
    public static function getCarrierShortName($class_name)
    {
        $stringy = Helper::normalizeClassName($class_name);

        if ($stringy->startsWith('Omniship\\')) {
            $remaining = $stringy->substr(9); // remove "Omniship\"
            $parts = explode('\\', (string)$remaining); // split on backslash
            return $parts[0];
        }

        return (string) $stringy;
    }

    /**
     * Get the carrier name from a class name.
     *
     * @param string $class_name The carrier class name
     * @return string The carrier name
     */
    public static function getCarrierName($class_name)
    {
        $stringy = static::normalizeClassName($class_name);

        if ($stringy->startsWith('Omniship\\')) {
            $parts = explode('\\', (string)$stringy);
            $carrierName = $parts[1];
            return rtrim($carrierName, 'Carrier');
        }

        return (string) $stringy->removeRight('Carrier');
    }
}