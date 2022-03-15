<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Zoho\Desk\Service;

use Zoho\Desk\Client\RequestBuilder;
use Zoho\Desk\Client\ResponseInterface;
use Zoho\Desk\Exception\CouldNotSaveException;
use Zoho\Desk\Exception\Exception;
use Zoho\Desk\Exception\InvalidArgumentException;
use Zoho\Desk\Exception\InvalidRequestException;
use Zoho\Desk\Model\DataObjectFactory;
use Zoho\Desk\Model\DataObjectInterface;

final class CreateOperation implements CreateOperationInterface
{
    private RequestBuilder $requestBuilder;

    private DataObjectFactory $dataObjectFactory;

    private string $entityType;

    private ?string $path;

    /**
     * @var string[]
     */
    private array $arguments;

    public function __construct(
        RequestBuilder $requestBuilder,
        DataObjectFactory $dataObjectFactory,
        string $entityType,
        ?string $path = null,
        array $arguments = []
    ) {
        $this->requestBuilder = $requestBuilder;
        $this->dataObjectFactory = $dataObjectFactory;
        $this->entityType = $entityType;
        $this->path = $path;
        $this->arguments = $arguments;
    }

    public function create(DataObjectInterface $dataObject, array $bind = []): DataObjectInterface
    {
        try {
            return $this->dataObjectFactory->create($this->entityType, $this->saveEntity($dataObject)->getResult());
        } catch (InvalidArgumentException $e) {
            throw new CouldNotSaveException($e->getMessage(), $e->getCode(), $e);
        } catch (InvalidRequestException $e) {
            throw new CouldNotSaveException($e->getMessage(), $e->getCode(), $e);
        } catch (Exception $e) {
            throw new CouldNotSaveException('Could not create the entity.', $e->getCode(), $e);
        }
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws InvalidRequestException
     */
    private function saveEntity(DataObjectInterface $dataObject, array $bind = []): ResponseInterface
    {
        return $this->requestBuilder
            ->setPath($this->path ?? $this->entityType, $bind)
            ->setMethod(RequestBuilder::HTTP_POST)
            ->setArguments($this->arguments)
            ->setFields($dataObject->toArray())
            ->create()
            ->execute();
    }
}
