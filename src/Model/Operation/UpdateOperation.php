<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Zoho\Desk\Model\Operation;

use Zoho\Desk\Client\RequestBuilder;
use Zoho\Desk\Client\ResponseInterface;
use Zoho\Desk\Exception\CouldNotSaveException;
use Zoho\Desk\Exception\Exception;
use Zoho\Desk\Exception\InvalidArgumentException;
use Zoho\Desk\Exception\InvalidRequestException;
use Zoho\Desk\Model\DataObjectFactory;
use Zoho\Desk\Model\DataObjectInterface;
use function array_merge;
use function sprintf;

final class UpdateOperation implements UpdateOperationInterface
{
    private RequestBuilder $requestBuilder;

    private DataObjectFactory $dataObjectFactory;

    private string $entityType;

    /**
     * @var string[]
     */
    private array $arguments;

    public function __construct(
        RequestBuilder $requestBuilder,
        DataObjectFactory $dataObjectFactory,
        string $entityType,
        array $arguments = []
    ) {
        $this->requestBuilder = $requestBuilder;
        $this->dataObjectFactory = $dataObjectFactory;
        $this->entityType = $entityType;
        $this->arguments = $arguments;
    }

    public function update(DataObjectInterface $dataObject): DataObjectInterface
    {
        if (!$dataObject->getEntityId()) {
            throw new CouldNotSaveException('Could not update an entity without ID.');
        }

        try {
            return $this->dataObjectFactory->create($this->entityType, $this->saveEntity($dataObject)->getResult());
        } catch (InvalidArgumentException $e) {
            throw new CouldNotSaveException($e->getMessage(), $e->getCode(), $e);
        } catch (InvalidRequestException $e) {
            throw new CouldNotSaveException($e->getMessage(), $e->getCode(), $e);
        } catch (Exception $e) {
            throw new CouldNotSaveException(
                sprintf('Could not update the entity with ID "%u".', $dataObject->getEntityId()),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * @param DataObjectInterface $dataObject
     * @return ResponseInterface
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws InvalidRequestException
     */
    private function saveEntity(DataObjectInterface $dataObject): ResponseInterface
    {
        return $this->requestBuilder
            ->setEntityType($this->entityType)
            ->setMethod(RequestBuilder::HTTP_PATCH)
            ->setArguments(array_merge([$dataObject->getEntityId()], $this->arguments))
            ->setFields($dataObject->toArray())
            ->create()
            ->execute();
    }
}
