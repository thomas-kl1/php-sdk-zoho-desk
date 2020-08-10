<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Zoho\Desk\Client;

use zcrmsdk\crm\utility\APIConstants;
use zcrmsdk\oauth\utility\ZohoOAuthConstants;
use Zoho\Desk\Api\Metadata;
use function array_merge;

final class ConfigProvider implements ConfigProviderInterface
{
    /**
     * @var string[]
     */
    private array $settings;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    public function get(): array
    {
        return array_merge($this->defaultSettings(), $this->settings);
    }

    private function defaultSettings(): array
    {
        return [
            ZohoOAuthConstants::CLIENT_ID => null,
            ZohoOAuthConstants::CLIENT_SECRET => null,
            ZohoOAuthConstants::REDIRECT_URL => null,
            APIConstants::CURRENT_USER_EMAIL => null,
            Metadata::ORG_ID => null,
            ZohoOAuthConstants::SANDBOX => null,
            APIConstants::API_BASE_URL => Metadata::API_ENDPOINT_US,
            APIConstants::API_VERSION => Metadata::API_VERSION,
            ZohoOAuthConstants::ACCESS_TYPE => Metadata::ACCESS_TYPE,
            ZohoOAuthConstants::IAM_URL => null,
            ZohoOAuthConstants::TOKEN_PERSISTENCE_PATH => null,
        ];
    }
}
