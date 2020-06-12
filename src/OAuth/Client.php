<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 */
declare(strict_types=1);

namespace Zoho\Desk\OAuth;

use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\utility\APIConstants;
use zcrmsdk\crm\utility\ZCRMConfigUtil;
use zcrmsdk\oauth\exception\ZohoOAuthException;
use Zoho\Desk\Api\Metadata;
use Zoho\Desk\Client\ConfigProviderInterface;
use Zoho\Desk\Exception\Exception;

final class Client implements ClientInterface
{
    /**
     * @var ConfigProviderInterface
     */
    private $configProvider;

    /**
     * @var bool
     */
    private $isConfigured;

    public function __construct(
        ConfigProviderInterface $configProvider
    ) {
        $this->configProvider = $configProvider;
        $this->isConfigured = false;
    }

    public function getApiBaseUrl(): string
    {
        return $this->configProvider->get()[APIConstants::API_BASE_URL] ?? Metadata::API_ENDPOINT_US;
    }

    public function getApiVersion(): string
    {
        return $this->configProvider->get()[APIConstants::API_VERSION] ?? Metadata::API_VERSION;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getAccessToken(): string
    {
        try {
            $this->configure();
            $accessToken = ZCRMConfigUtil::getAccessToken();
        } catch (ZCRMException | ZohoOAuthException $e) {
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }

        return $accessToken;
    }

    public function getOrgId(): int
    {
        return (int) $this->configProvider->get()[Metadata::ORG_ID];
    }

    private function configure(): void
    {
        if (!$this->isConfigured) {
            ZCRMRestClient::initialize($this->configProvider->get());
            $this->isConfigured = true;
        }
    }
}
