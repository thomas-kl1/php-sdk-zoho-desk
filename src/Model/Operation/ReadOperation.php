<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 */
declare(strict_types=1);

namespace Zoho\Desk\Model\Operation;

use Zoho\Desk\Client\RequestBuilder;
use Zoho\Desk\Client\ResponseInterface;
use Zoho\Desk\Exception\CouldNotReadException;
use Zoho\Desk\Exception\Exception;
use Zoho\Desk\Exception\InvalidArgumentException;
use Zoho\Desk\Exception\InvalidRequestException;
use Zoho\Desk\Model\DataObjectFactory;
use Zoho\Desk\Model\DataObjectInterface;
use function array_merge;

final class ReadOperation implements ReadOperationInterface
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
     * @var string
     */
    private $entityType;

    /**
     * @var string[]
     */
    private $arguments;

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

    public function get(int $entityId): DataObjectInterface
    {
        try {
            return $this->dataObjectFactory->create($this->entityType, $this->fetchEntity($entityId)->getResult());
        } catch (InvalidArgumentException $e) {
            throw new CouldNotReadException($e->getMessage(), $e->getCode(), $e);
        } catch (InvalidRequestException $e) {
            throw new CouldNotReadException($e->getMessage(), $e->getCode(), $e);
        } catch (Exception $e) {
            throw new CouldNotReadException('Could not fetch the entity.', $e->getCode(), $e);
        }
    }

    /**
     * @param int $entityId
     * @return ResponseInterface
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws InvalidRequestException
     */
    private function fetchEntity(int $entityId): ResponseInterface
    {
        return $this->requestBuilder
            ->setEntityType($this->entityType)
            ->setMethod(RequestBuilder::HTTP_GET)
            ->setArguments(array_merge([$entityId], $this->arguments))
            ->create()
            ->execute();
    }
}
