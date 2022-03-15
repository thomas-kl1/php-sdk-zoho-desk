<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Zoho\Desk;

use Zoho\Desk\Client\ConfigProviderInterface;
use Zoho\Desk\Client\RequestBuilder;
use Zoho\Desk\Model\DataObjectFactory;
use Zoho\Desk\Model\OperationPool;
use Zoho\Desk\OAuth\Client;
use Zoho\Desk\Service\ServiceFactory;

/**
 * @api
 */
final class Gateway
{
    private Client $client;

    private RequestBuilder $requestBuilder;

    private DataObjectFactory $dataObjectFactory;

    private OperationPool $operationPool;

    private ServiceFactory $serviceFactory;

    public function __construct(ConfigProviderInterface $configProvider, array $registeredEntityTypes = [])
    {
        $this->client = new Client($configProvider);
        $this->requestBuilder = new RequestBuilder($this->client);
        $this->dataObjectFactory = new DataObjectFactory($registeredEntityTypes);
        $this->operationPool = new OperationPool($this->requestBuilder, $this->dataObjectFactory);
        $this->serviceFactory = new ServiceFactory($this->requestBuilder, $this->dataObjectFactory);
    }

    public function getDataObjectFactory(): DataObjectFactory
    {
        return $this->dataObjectFactory;
    }

    /**
     * @deprecated
     * @see Gateway::getServiceFactory
     */
    public function getOperationPool(): OperationPool
    {
        return $this->operationPool;
    }

    public function getServiceFactory(): ServiceFactory
    {
        return $this->serviceFactory;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getRequestBuilder(): RequestBuilder
    {
        return $this->requestBuilder;
    }
}
