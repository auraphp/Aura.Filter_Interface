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
     * Apply the filter, returning a result that carries the outcome, the
     * (sanitized) values and any failures.
     *
     * Callers must read filtered data from the result's getValues(), not from
     * the variable passed in: whether the subject is also modified in place is
     * left to the implementation. aura/filter works on a clone and leaves the
     * caller's subject untouched; aura/input filters its Fieldset in place.
     *
     * @param array|object $values The data to filter.
     */
    public function apply(array|object $values): FilterResultInterface;
}
