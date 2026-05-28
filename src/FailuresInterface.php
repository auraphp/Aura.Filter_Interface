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
 * Read-only view of a failure collection — the interface consumers are typed against.
 *
 * @package Aura.Filter_Interface
 *
 */
interface FailuresInterface
{
    /**
     * Is the failure collection empty?
     */
    public function isEmpty(): bool;

    /**
     * All failures for a flat field name.
     *
     * @return FailureInterface[]
     */
    public function forField(string $field): array;

    /**
     * All failures at a dot-notation path: "address.city", "items.0.name".
     *
     * @return FailureInterface[]
     */
    public function forPath(string $path): array;

    /**
     * Flat map: field/path string → string[] of messages.
     * Keys use dot-notation for nested failures.
     *
     * @return array<string, string[]>
     */
    public function getMessages(): array;

    /**
     * Nested map that mirrors the input data structure.
     * e.g. ['address' => ['city' => ['City is required']]]
     *
     * @return array
     */
    public function getNestedMessages(): array;
}
