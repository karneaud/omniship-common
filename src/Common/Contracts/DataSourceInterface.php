<?php
/**
 * Data source interface
 */

namespace Omniship\Common\Contracts;

/**
 * Data source interface
 *
 * This interface defines the standard functions that any
 * data source implementation needs to define. It acts as a wrapper
 * for different data retrieval methods (API, file, database, etc.)
 * providing a unified way to access data.
 */
interface DataSourceInterface extends ResultInterface
{
   public function fetchData() : ResultInterface;
}