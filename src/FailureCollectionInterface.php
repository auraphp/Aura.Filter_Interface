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
 * Failure collection
 *
 * @package Aura.Filter_Interface
 *
 */
interface FailureCollectionInterface
{
    /**
     * Is the failure collection empty?
     */
    public function isEmpty(): bool;

    /**
     *
     * Adds an additional failure on a field.
     *
     * @param string $field The field that failed.
     *
     * @param string $message The failure message.
     *
     * @param array $args The arguments passed to the rule specification.
     *
     */
    public function add(string $field, string $message, array $args = array()): FailureInterface;

    /**
     *
     * Set a failure on a field, removing all previous failures.
     *
     * @param string $field The field that failed.
     *
     * @param string $message The failure message.
     *
     * @param array $args The arguments passed to the rule specification.
     *
     */
    public function set(string $field, string $message, array $args = array()): FailureInterface;

    /**
     * Returns all failure messages for one field.
     */
    public function getMessagesForField(string $field): array;

    /**
     * Returns all failure messages for all fields.
     */
    public function getMessages(): array;
}
