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
 * Immutability comes from the readonly promoted properties, not from the class
 * being final: they are private and readonly, so a subclass can neither write
 * nor redeclare the recorded values. A subclass may still override the
 * accessors and report something else — as may any other implementation of
 * FilterResultInterface, which is what consumers are typed against. Callers
 * therefore rely on the interface, not on this class being faithful.
 *
 * Implementations that need a different result entirely should implement
 * FilterResultInterface rather than extend this class.
 *
 * @package Aura.Filter_Interface
 *
 */
class FilterResult implements FilterResultInterface
{
    /**
     * Constructor.
     *
     * @param bool             $success  True when every rule passed; false otherwise.
     * @param array|object     $values   The subject after all sanitize rules ran.
     *                                   Matches the type of the value passed to apply().
     * @param FailuresInterface $failures The failure collection (empty on success).
     */
    public function __construct(
        private readonly bool $success,
        private readonly array|object $values,
        private readonly FailuresInterface $failures,
    ) {
    }

    /**
     * Returns true when every filter rule passed, false otherwise.
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * Returns the subject after sanitization rules have been applied.
     *
     * If no sanitize rules ran, this is identical to the value passed to apply().
     * The type mirrors the input: array in → array out, object in → object out.
     *
     * Read filtered data from here rather than from the variable passed to
     * apply(): whether that subject is also modified in place is left to the
     * implementation.
     *
     * @return array|object
     */
    public function getValues(): array|object
    {
        return $this->values;
    }

    /**
     * Returns the failure collection.
     *
     * Will be empty (isEmpty() === true) when isSuccess() === true.
     */
    public function getFailures(): FailuresInterface
    {
        return $this->failures;
    }
}
