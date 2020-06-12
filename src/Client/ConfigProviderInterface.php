<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Zoho\Desk\Client;

/**
 * @api
 */
interface ConfigProviderInterface
{
    public function get(): array;
}
