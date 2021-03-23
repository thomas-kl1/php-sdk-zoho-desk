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

/**
 * @api
 */
final class Gateway
{
    private DataObjectFactory $dataObjectFactory;

    private OperationPool $operationPool;

    private Client $client;

    private RequestBuilder $requestBuilder;

    public function __construct(ConfigProviderInterface $configProvider, array $registeredEntityTypes = [])
    {
        $this->dataObjectFactory = new DataObjectFactory($registeredEntityTypes);
        $this->client = new Client($configProvider);
        $this->requestBuilder = new RequestBuilder($this->client);
        $this->operationPool = new OperationPool($this->requestBuilder, $this->dataObjectFactory);
    }

    public function getDataObjectFactory(): DataObjectFactory
    {
        return $this->dataObjectFactory;
    }

    public function getOperationPool(): OperationPool
    {
        return $this->operationPool;
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
