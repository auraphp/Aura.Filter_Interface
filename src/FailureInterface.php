<?php
declare(strict_types=1);

/**
 *
 * This file is part of Aura for PHP.
 *
 * @license http://opensource.org/licenses/mit-license.php MIT
 *
 */
namespace Aura\Filter_Interface;

use JsonSerializable;

/**
 *
 * Represents the failure of a rule specification.
 *
 * @package Aura.Filter_Interface
 *
 */
interface FailureInterface extends JsonSerializable
{
    /**
     *
     * Returns the field that failed.
     *
     *
     */
    public function getField(): string;

    /**
     *
     * Returns the failure message.
     *
     *
     */
    public function getMessage(): string;

    /**
     *
     * Returns the arguments passed to the rule specification.
     *
     *
     * @return mixed[]
     */
    public function getArgs(): array;

}
