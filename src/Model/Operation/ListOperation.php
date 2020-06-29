<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 * See LICENSE bundled with this library for license details.
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
use Zoho\Desk\Model\ListCriteriaInterface;
use function array_merge;
use function implode;
use function is_array;

final class ListOperation implements ListOperationInterface
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

    public function getByIds(array $entityIds): array
    {
        try {
            $response = $this->fetchResult(
                array_merge([$this->entityType . 'ByIds'], $this->arguments),
                ['ids' => implode(',', $entityIds)]
            );
        } catch (InvalidArgumentException $e) {
            throw new CouldNotReadException($e->getMessage(), $e->getCode(), $e);
        } catch (InvalidRequestException $e) {
            throw new CouldNotReadException($e->getMessage(), $e->getCode(), $e);
        } catch (Exception $e) {
            throw new CouldNotReadException('Could not fetch the entity.', $e->getCode(), $e);
        }

        return $this->buildEntities($response);
    }

    public function getList(ListCriteriaInterface $listCriteria): array
    {
        try {
            $response = $this->fetchResult($this->arguments, $listCriteria->getQueryParams());
        } catch (InvalidArgumentException $e) {
            throw new CouldNotReadException($e->getMessage(), $e->getCode(), $e);
        } catch (InvalidRequestException $e) {
            throw new CouldNotReadException($e->getMessage(), $e->getCode(), $e);
        } catch (Exception $e) {
            throw new CouldNotReadException('Could not fetch the entity.', $e->getCode(), $e);
        }

        return $this->buildEntities($response);
    }

    /**
     * @param ResponseInterface $response
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
     * @param string[] $arguments
     * @param string[] $params
     * @return ResponseInterface
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws InvalidRequestException
     */
    private function fetchResult(array $arguments, array $params = []): ResponseInterface
    {
        return $this->requestBuilder
            ->setEntityType($this->entityType)
            ->setMethod(RequestBuilder::HTTP_GET)
            ->setArguments($arguments)
            ->setQueryParameters($params)
            ->create()
            ->execute();
    }
}
