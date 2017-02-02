<?php
/**
 *
 * This file is part of the Aura project for PHP.
 *
 * @package Aura.Filter_Interface
 *
 * @license http://opensource.org/licenses/MIT-license.php MIT
 *
 */
namespace Aura\Filter_Interface;

/**
 *
 * A filter interface
 *
 * @package Aura.Filter_Interface
 *
 */
interface FilterInterface
{
    /**
     *
     * Filter (sanitize and validate) the data.
     *
     * @param array|object $values The values to be filtered.
     *
     * @return bool True if all rules passed; false if one or more failed.
     *
     */
    public function apply(&$values);

    /**
     *
     * Returns the failures.
     *
     * @return FailureCollectionInterface
     *
     */
    public function getFailures();
}
