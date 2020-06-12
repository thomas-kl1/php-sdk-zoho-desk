<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Zoho\Desk\OAuth;

use Zoho\Desk\Exception\Exception;

/**
 * @api
 */
interface ClientInterface
{
    public function getApiBaseUrl(): string;

    public function getApiVersion(): string;

    /**
     * @return string
     * @throws Exception
     */
    public function getAccessToken(): string;

    public function getOrgId(): int;
}
