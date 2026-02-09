<?php

namespace Omniship\Common\Exception;

use Omniship\Common\Contracts\OmnishipExceptionInterface;

/**
 * Bad Method Call Exception
 */
class BadMethodCallException extends \BadMethodCallException implements OmnishipExceptionInterface
{
}
