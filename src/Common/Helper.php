<?php
/**
 * Helper class
 */

namespace Omniship\Common;

use Stringy\Stringy as S;
use Omniship\Common\Traits\ServiceHelperTrait;
use InvalidArgumentException;

/**
 * Helper class
 *
 * This class defines various static utility functions that are in use
 * throughout the Omniship system.
 */
final class Helper
{
    use ServiceHelperTrait;
     /**
     * Normalize a class name by removing leading backslashes and cleaning up the format.
     *
     * @param string $class_name The class name to normalize
     * @return S The normalized Stringy object
     */
    public static function normalizeClassName($class_name)
    {
        return S::create($class_name)->removeLeft('\\');
    }
    /**
     * Initialize an object with a given array of parameters
     *
     * Parameters are automatically converted to camelCase. Any parameters which do
     * not match a setter on the target object are ignored.
     *
     * @param mixed $target     The object to set parameters on
     * @param array $parameters An array of parameters to set
     */
    public static function initialize($target, array $parameters = null)
    {
        if ($parameters) {
            foreach ($parameters as $key => $value) {
                $method = 'set'.ucfirst(static::camelCase($key));
                if (method_exists($target, $method)) {
                    $target->$method($value);
                }
            }
        }
    }

    /**
     * Convert a string to camelCase. Strings already in camelCase will not be harmed.
     *
     * @param  string  $str The input string
     * @return string camelCased output string
     */
    public static function camelCase($str)
    {
        return (string) S::create($str)->camelize();
    }
}
