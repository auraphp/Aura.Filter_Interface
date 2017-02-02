<?php
/**
 *
 * This file is part of Aura for PHP.
 *
 * @license http://opensource.org/licenses/MIT-license.php MIT
 *
 */
namespace Aura\Filter_Interface;

interface FailureCollectionInterface
{
    /**
     *
     * Is the failure collection empty?
     *
     * @return bool
     *
     */
    public function isEmpty();

    /**
     *
     * Adds an additional failure message / messages on a field.
     *
     * @param string $field The field that failed.
     *
     * @param string|array $messages The failure messages.
     *
     * @return void
     *
     */
    public function addMessagesForField($field, $messages);

    /**
     *
     * Returns all failure messages for one field.
     *
     * @param string $field The field name.
     *
     * @return array
     *
     */
    public function getMessagesForField($field);

    /**
     *
     * Returns all failure messages for all fields.
     *
     * @return array
     *
     */
    public function getMessages();
}
