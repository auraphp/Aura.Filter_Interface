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
 * Write side of a failure collection — used internally by filter implementations
 * while building the collection during a filter run.
 *
 * Consumers are always typed against FailuresInterface (read-only).
 *
 * @package Aura.Filter_Interface
 *
 */
interface FailureCollectionInterface extends FailuresInterface
{
    /**
     * Adds an additional failure on a field.
     *
     * @param string $field   The field that failed.
     * @param string $message The failure message.
     * @param array  $args    Arguments passed to the rule specification.
     */
    public function add(string $field, string $message, array $args = []): FailureInterface;

    /**
     * Sets a failure on a field, replacing all previous failures for that field.
     *
     * @param string $field   The field that failed.
     * @param string $message The failure message.
     * @param array  $args    Arguments passed to the rule specification.
     */
    public function set(string $field, string $message, array $args = []): FailureInterface;
}
