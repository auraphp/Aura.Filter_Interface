<?php
declare(strict_types=1);

/**
 *
 * This file is part of Aura for PHP.
 *
 * @package Aura.Filter_Interface
 *
 * @license http://opensource.org/licenses/MIT-license.php MIT
 *
 */
namespace Aura\Filter_Interface;

/**
 *
 * Value object returned by FilterInterface::apply().
 * Carries the (possibly sanitized) values and any failures.
 *
 * @package Aura.Filter_Interface
 *
 */
interface FilterResultInterface
{
    /**
     * Did every rule pass?
     */
    public function isSuccess(): bool;

    /**
     * The subject after sanitization rules have been applied.
     * If no sanitize rules ran, this is identical to the input.
     *
     * Read filtered data from here rather than from the variable passed to
     * apply(): whether that subject is also modified in place is left to the
     * implementation.
     */
    public function getValues(): array|object;

    /**
     * Failures — only meaningful when isSuccess() === false.
     */
    public function getFailures(): FailuresInterface;
}
