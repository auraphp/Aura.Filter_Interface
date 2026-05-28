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
 * Interface for filters that understand nested subjects.
 *
 * @package Aura.Filter_Interface
 *
 */
interface SubjectFilterInterface extends FilterInterface
{
    /**
     *
     * Register a sub-filter for a nested field.
     *
     * Returns the sub-filter so the caller can configure it fluently.
     *
     * @param string $field    The field name on the subject whose value
     *                         will be passed to the sub-filter.
     *
     * @param string $subClass Optional class name of the sub-filter to
     *                         instantiate; defaults to the same concrete
     *                         class as the parent filter.
     *
     */
    public function subfilter(string $field, string $subClass = ''): SubjectFilterInterface;
}
