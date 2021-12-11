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
use Zoho\Desk\Model\ListCriteriaInterface;
use function array_merge;
use function is_array;

final class ListOperation implements ListOperationInterface
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

    public function getList(ListCriteriaInterface $listCriteria, array $bind = []): array
    {
        $arguments = $listCriteria->getFilters() ? array_merge(['search'], $this->arguments) : $this->arguments;

        try {
            $response = $this->fetchResult($arguments, $listCriteria->getQueryParams(), $bind);
        } catch (InvalidArgumentException $e) {
            throw new CouldNotReadException($e->getMessage(), $e->getCode(), $e);
        } catch (InvalidRequestException $e) {
            throw new CouldNotReadException($e->getMessage(), $e->getCode(), $e);
        } catch (Exception $e) {
            throw new CouldNotReadException('Could not fetch the entities.', $e->getCode(), $e);
        }

        return $this->buildEntities($response);
    }

    /**
     * @return DataObjectInterface[]
     */
    private function buildEntities(ResponseInterface $response): array
    {
        $entities = [];
        $result = $response->getResult();
        if (isset($result['data']) && is_array($result['data'])) {
            foreach ($result['data'] as $entity) {
                $entities[] = $this->dataObjectFactory->create($this->entityType, $entity);
            }
        }

        return $entities;
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws InvalidRequestException
     */
    private function fetchResult(array $arguments, array $params = [], array $bind = []): ResponseInterface
    {
        return $this->requestBuilder
            ->setPath($this->path ?? $this->entityType, $bind)
            ->setMethod(RequestBuilder::HTTP_GET)
            ->setArguments($arguments)
            ->setQueryParameters($params)
            ->create()
            ->execute();
    }
}
