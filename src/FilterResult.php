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
 * Immutable value object returned by FilterInterface::apply().
 * Shared concrete implementation used by aura/filter and aura/input.
 *
 * @package Aura.Filter_Interface
 *
 */
final class FilterResult implements FilterResultInterface
{
    public function __construct(
        private readonly bool $success,
        private readonly array|object $values,
        private readonly FailuresInterface $failures,
    ) {
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getValues(): array|object
    {
        return $this->values;
    }

    public function getFailures(): FailuresInterface
    {
        return $this->failures;
    }
}
