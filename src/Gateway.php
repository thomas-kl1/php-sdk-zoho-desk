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
use Zoho\Desk\Model\DataObjectInterface;
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
    private $dataObjectFactory;

    /**
     * @var OperationPool
     */
    private $operationPool;

    public function __construct(ConfigProviderInterface $configProvider, array $registeredEntityTypes = [])
    {
        $this->dataObjectFactory = new DataObjectFactory($registeredEntityTypes);
        $this->operationPool = new OperationPool(
            new RequestBuilder(new Client($configProvider)),
            $this->dataObjectFactory
        );
    }

    public function createDataObject(string $entityType, array $data = []): DataObjectInterface
    {
        return $this->dataObjectFactory->create($entityType, $data);
    }

    /**
     * @param string $entityType
     * @param DataObjectInterface $dataObject
     * @param string[] $arguments [optional]
     * @return DataObjectInterface
     * @throws Exception\CouldNotSaveException
     */
    public function create(
        string $entityType,
        DataObjectInterface $dataObject,
        array $arguments = []
    ): DataObjectInterface {
        return $this->operationPool->getCreateOperation($entityType, $arguments)->create($dataObject);
    }

    /**
     * @param string $entityType
     * @param int $entityId
     * @param string[] $arguments [optional]
     * @return DataObjectInterface
     * @throws Exception\CouldNotReadException
     */
    public function get(string $entityType, int $entityId, array $arguments = []): DataObjectInterface
    {
        return $this->operationPool->getReadOperation($entityType, $arguments)->get($entityId);
    }

    /**
     * @param string $entityType
     * @param DataObjectInterface $dataObject
     * @param string[] $arguments [optional]
     * @return DataObjectInterface
     * @throws Exception\CouldNotSaveException
     */
    public function update(
        string $entityType,
        DataObjectInterface $dataObject,
        array $arguments = []
    ): DataObjectInterface {
        return $this->operationPool->getUpdateOperation($entityType, $arguments)->update($dataObject);
    }

    /**
     * @param string $entityType
     * @param int $entityId
     * @param string[] $arguments [optional]
     * @throws Exception\CouldNotDeleteException
     */
    public function delete(string $entityType, int $entityId, array $arguments = []): void
    {
        $this->operationPool->getDeleteOperation($entityType, $arguments)->delete($entityId);
    }
}
