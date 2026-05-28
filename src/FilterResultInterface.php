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
     * The original passed to apply() is never mutated.
     */
    public function getValues(): array|object;

    /**
     * Failures — only meaningful when isSuccess() === false.
     */
    public function getFailures(): FailuresInterface;
}
