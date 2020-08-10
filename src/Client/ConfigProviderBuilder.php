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

/**
 * @api
 */
final class ConfigProviderBuilder
{
    /**
     * @var string[]
     */
    private array $settings;

    private static ?ConfigProviderBuilder $instance = null;

    private function __construct()
    {
        $this->settings = [];
    }

    public static function getInstance(): self
    {
        return self::$instance ?? self::$instance = new self();
    }

    public function setClientId(string $clientId): self
    {
        $this->settings[ZohoOAuthConstants::CLIENT_ID] = $clientId;

        return $this;
    }

    public function setClientSecret(string $clientSecret): self
    {
        $this->settings[ZohoOAuthConstants::CLIENT_SECRET] = $clientSecret;

        return $this;
    }

    public function setRedirectUrl(string $redirectUrl): self
    {
        $this->settings[ZohoOAuthConstants::REDIRECT_URL] = $redirectUrl;

        return $this;
    }

    public function setCurrentUserEmail(string $userEmail): self
    {
        $this->settings[APIConstants::CURRENT_USER_EMAIL] = $userEmail;

        return $this;
    }

    public function setApiBaseUrl(string $apiBaseUrl): self
    {
        $this->settings[APIConstants::API_BASE_URL] = $apiBaseUrl;

        return $this;
    }

    public function setApiVersion(string $apiVersion): self
    {
        $this->settings[APIConstants::API_VERSION] = $apiVersion;

        return $this;
    }

    public function setOrgId(int $orgId): self
    {
        $this->settings[Metadata::ORG_ID] = $orgId;

        return $this;
    }

    public function setIsSandbox(bool $isSandbox): self
    {
        $this->settings[ZohoOAuthConstants::SANDBOX] = $isSandbox;

        return $this;
    }

    public function setAccountsUrl(string $accountsUrl): self
    {
        $this->settings[ZohoOAuthConstants::IAM_URL] = $accountsUrl;

        return $this;
    }

    public function setTokenPersistencePath(string $directoryPath): self
    {
        $this->settings[ZohoOAuthConstants::TOKEN_PERSISTENCE_PATH] = $directoryPath;

        return $this;
    }

    public function create(): ConfigProviderInterface
    {
        $configProvider = new ConfigProvider($this->settings);

        $this->settings = [];

        return $configProvider;
    }
}
