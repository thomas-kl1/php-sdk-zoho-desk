<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Zoho\Desk\Service;

use Zoho\Desk\Client\RequestBuilder;
use Zoho\Desk\Model\DataObjectFactory;

final class ServiceFactory
{
    private RequestBuilder $requestBuilder;

    private DataObjectFactory $dataObjectFactory;

    public function __construct(RequestBuilder $requestBuilder, DataObjectFactory $dataObjectFactory)
    {
        $this->requestBuilder = $requestBuilder;
        $this->dataObjectFactory = $dataObjectFactory;
    }

    public function createOperation(string $entityType, ?string $path, array $arguments = []): CreateOperationInterface
    {
        return new CreateOperation($this->requestBuilder, $this->dataObjectFactory, $entityType, $path, $arguments);
    }

    public function readOperation(string $entityType, ?string $path, array $arguments = []): ReadOperationInterface
    {
        return new ReadOperation($this->requestBuilder, $this->dataObjectFactory, $entityType, $path, $arguments);
    }

    public function updateOperation(string $entityType, ?string $path, array $arguments = []): UpdateOperationInterface
    {
        return new UpdateOperation($this->requestBuilder, $this->dataObjectFactory, $entityType, $path, $arguments);
    }

    public function deleteOperation(string $entityType, ?string $path, array $arguments = []): DeleteOperationInterface
    {
        return new DeleteOperation($this->requestBuilder, $entityType, $path, $arguments);
    }

    public function listOperation(string $entityType, ?string $path, array $arguments = []): ListOperationInterface
    {
        return new ListOperation($this->requestBuilder, $this->dataObjectFactory, $entityType, $path, $arguments);
    }
}
