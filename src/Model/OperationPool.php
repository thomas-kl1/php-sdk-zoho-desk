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
use Zoho\Desk\Model\Operation\ReadOperation;
use Zoho\Desk\Model\Operation\ReadOperationInterface;
use Zoho\Desk\Model\Operation\UpdateOperation;
use Zoho\Desk\Model\Operation\UpdateOperationInterface;
use function implode;
use function md5;

final class OperationPool
{
    /**
     * @var RequestBuilder
     */
    private $requestBuilder;

    /**
     * @var DataObjectFactory
     */
    private $dataObjectFactory;

    /**
     * @var CreateOperationInterface[]
     */
    private $createOperationPool;

    /**
     * @var ReadOperationInterface[]
     */
    private $readOperationPool;

    /**
     * @var UpdateOperationInterface[]
     */
    private $updateOperationPool;

    /**
     * @var DeleteOperationInterface[]
     */
    private $deleteOperationPool;

    public function __construct(
        RequestBuilder $requestBuilder,
        DataObjectFactory $dataObjectFactory
    ) {
        $this->requestBuilder = $requestBuilder;
        $this->dataObjectFactory = $dataObjectFactory;
        $this->createOperationPool = [];
        $this->readOperationPool = [];
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
