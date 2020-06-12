<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
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
