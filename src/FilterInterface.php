<?php
declare(strict_types=1);

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
 * A filter interface.
 *
 * @package Aura.Filter_Interface
 *
 */
interface FilterInterface
{
    /**
     * Apply the filter. Never mutates $values.
     * Returns a result containing the (sanitized) values and any failures.
     *
     * @param array|object $values The data to filter.
     */
    public function apply(array|object $values): FilterResultInterface;
}
