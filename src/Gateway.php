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
    /**
     * @var DataObjectFactory
     */
    public $dataObjectFactory;

    /**
     * @var OperationPool
     */
    public $operationPool;

    public function __construct(ConfigProviderInterface $configProvider, array $registeredEntityTypes = [])
    {
        $this->dataObjectFactory = new DataObjectFactory($registeredEntityTypes);
        $this->operationPool = new OperationPool(
            new RequestBuilder(new Client($configProvider)),
            $this->dataObjectFactory
        );
    }
}
