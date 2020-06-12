<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 */
declare(strict_types=1);

namespace Zoho\Desk\Client;

use Zoho\Desk\Exception\InvalidRequestException;

/**
 * @api
 */
interface RequestInterface
{
    /**
     * @throws InvalidRequestException
     */
    public function execute(): ResponseInterface;
}
