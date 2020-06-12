<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Zoho\Desk\Exception;

use function sprintf;

/**
 * @api
 */
class InvalidRequestException extends Exception
{
    private const REQUEST_ERROR_MESSAGE_MASK = 'An error occurred while processing the request: %s';

    public static function createRequestErrorException(string $error, int $errno): InvalidRequestException
    {
        return new self(sprintf(static::REQUEST_ERROR_MESSAGE_MASK, $error), $errno);
    }
}
