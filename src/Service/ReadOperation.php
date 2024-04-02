<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Zoho\Desk\Service;

use Zoho\Desk\Client\RequestBuilder;
use Zoho\Desk\Client\ResponseInterface;
use Zoho\Desk\Exception\CouldNotReadException;
use Zoho\Desk\Exception\Exception;
use Zoho\Desk\Exception\InvalidArgumentException;
use Zoho\Desk\Exception\InvalidRequestException;
use Zoho\Desk\Model\DataObjectFactory;
use Zoho\Desk\Model\DataObjectInterface;
use function array_merge;
use function reset;

final class ReadOperation implements ReadOperationInterface
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

    public function get(array $bind, array $query = []): DataObjectInterface
    {
        try {
            return $this->dataObjectFactory->create($this->entityType, $this->fetchEntity($bind, $query)->getResult());
        } catch (InvalidArgumentException $e) {
            throw new CouldNotReadException($e->getMessage(), $e->getCode(), $e);
        } catch (InvalidRequestException $e) {
            throw new CouldNotReadException($e->getMessage(), $e->getCode(), $e);
        } catch (Exception $e) {
            throw new CouldNotReadException('Could not fetch the entity.', $e->getCode(), $e);
        }
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws InvalidRequestException
     */
    private function fetchEntity(array $bind = [], array $query = []): ResponseInterface
    {
        return $this->requestBuilder
            ->setPath($this->path ?? $this->entityType, $bind)
            ->setMethod(RequestBuilder::HTTP_GET)
            ->setArguments($this->path ? $this->arguments : array_merge([reset($bind)], $this->arguments))
            ->setQueryParameters($query)
            ->create()
            ->execute();
    }
}
