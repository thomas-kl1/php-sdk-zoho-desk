<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Zoho\Desk\Model;

use Zoho\Desk\Client\RequestBuilder;
use Zoho\Desk\Model\Operation\CreateOperation;
use Zoho\Desk\Model\Operation\CreateOperationInterface;
use Zoho\Desk\Model\Operation\DeleteOperation;
use Zoho\Desk\Model\Operation\DeleteOperationInterface;
use Zoho\Desk\Model\Operation\ListOperation;
use Zoho\Desk\Model\Operation\ListOperationInterface;
use Zoho\Desk\Model\Operation\ReadOperation;
use Zoho\Desk\Model\Operation\ReadOperationInterface;
use Zoho\Desk\Model\Operation\UpdateOperation;
use Zoho\Desk\Model\Operation\UpdateOperationInterface;
use function implode;
use function md5;

final class OperationPool
{
    private RequestBuilder $requestBuilder;

    private DataObjectFactory $dataObjectFactory;

    /**
     * @var CreateOperationInterface[]
     */
    private array $createOperationPool;

    /**
     * @var ReadOperationInterface[]
     */
    private array $readOperationPool;

    /**
     * @var ListOperationInterface[]
     */
    private array $listOperationPool;

    /**
     * @var UpdateOperationInterface[]
     */
    private array $updateOperationPool;

    /**
     * @var DeleteOperationInterface[]
     */
    private array $deleteOperationPool;

    public function __construct(
        RequestBuilder $requestBuilder,
        DataObjectFactory $dataObjectFactory
    ) {
        $this->requestBuilder = $requestBuilder;
        $this->dataObjectFactory = $dataObjectFactory;
        $this->createOperationPool = [];
        $this->readOperationPool = [];
        $this->listOperationPool = [];
        $this->updateOperationPool = [];
        $this->deleteOperationPool = [];
    }

    public function getCreateOperation(string $entityType, array $arguments = []): CreateOperationInterface
    {
        $hash = md5($entityType . implode('', $arguments));

        return $this->createOperationPool[$hash]
            ?? $this->createOperationPool[$hash] = new CreateOperation(
                $this->requestBuilder,
                $this->dataObjectFactory,
                $entityType,
                $arguments
            );
    }

    public function getReadOperation(string $entityType, array $arguments = []): ReadOperationInterface
    {
        $hash = md5($entityType . implode('', $arguments));

        return $this->readOperationPool[$hash]
            ?? $this->readOperationPool[$hash] = new ReadOperation(
                $this->requestBuilder,
                $this->dataObjectFactory,
                $entityType,
                $arguments
            );
    }

    public function getListOperation(string $entityType, array $arguments = []): ListOperationInterface
    {
        $hash = md5($entityType . implode('', $arguments));

        return $this->listOperationPool[$hash]
            ?? $this->listOperationPool[$hash] = new ListOperation(
                $this->requestBuilder,
                $this->dataObjectFactory,
                $entityType,
                $arguments
            );
    }

    public function getUpdateOperation(string $entityType, array $arguments = []): UpdateOperationInterface
    {
        $hash = md5($entityType . implode('', $arguments));

        return $this->updateOperationPool[$hash]
            ?? $this->updateOperationPool[$hash] = new UpdateOperation(
                $this->requestBuilder,
                $this->dataObjectFactory,
                $entityType,
                $arguments
            );
    }

    public function getDeleteOperation(string $entityType, array $arguments = []): DeleteOperationInterface
    {
        $hash = md5($entityType . implode('', $arguments));

        return $this->deleteOperationPool[$hash]
            ?? $this->deleteOperationPool[$hash] = new DeleteOperation(
                $this->requestBuilder,
                $entityType,
                $arguments
            );
    }
}
