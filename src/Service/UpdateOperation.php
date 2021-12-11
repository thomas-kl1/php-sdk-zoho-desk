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
use function array_merge;
use function reset;
use function sprintf;

final class UpdateOperation implements UpdateOperationInterface
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

    public function update(DataObjectInterface $dataObject, array $bind = []): DataObjectInterface
    {
        if (!$dataObject->getEntityId()) {
            throw new CouldNotSaveException('Could not update an entity without ID.');
        }

        try {
            return $this->dataObjectFactory->create($this->entityType, $this->saveEntity($dataObject, $bind)->getResult());
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
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws InvalidRequestException
     */
    private function saveEntity(DataObjectInterface $dataObject, array $bind = []): ResponseInterface
    {
        return $this->requestBuilder
            ->setPath($this->path ?? $this->entityType, $bind)
            ->setMethod(RequestBuilder::HTTP_PATCH)
            ->setArguments($this->path ? $this->arguments : array_merge([reset($bind)], $this->arguments))
            ->setFields($dataObject->toArray())
            ->create()
            ->execute();
    }
}
