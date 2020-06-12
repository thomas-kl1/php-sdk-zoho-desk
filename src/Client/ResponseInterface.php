<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 */
declare(strict_types=1);

namespace Zoho\Desk\Client;

/**
 * @api
 */
interface ResponseInterface
{
    public function getResult(): array;

    public function getInfo(): array;
}
