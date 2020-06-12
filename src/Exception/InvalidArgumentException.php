<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 */
declare(strict_types=1);

namespace Zoho\Desk\Exception;

use function sprintf;

/**
 * @api
 */
class InvalidArgumentException extends Exception
{
    private const MANDATORY_FIELD_MESSAGE_MASK = 'Mandatory field "%s" is not set.';

    public static function createMandatoryFieldException(string $fieldName): InvalidArgumentException
    {
        return new self(sprintf(static::MANDATORY_FIELD_MESSAGE_MASK, $fieldName));
    }
}
