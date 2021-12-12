<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Zoho\Desk\Model\Operation;

use Zoho\Desk\Client\RequestBuilder;
use Zoho\Desk\Exception\CouldNotDeleteException;
use Zoho\Desk\Exception\Exception;
use Zoho\Desk\Exception\InvalidArgumentException;
use Zoho\Desk\Exception\InvalidRequestException;
use function array_merge;
use function sprintf;

/**
 * @deprecated
 * @see \Zoho\Desk\Service\DeleteOperation
 */
final class DeleteOperation implements DeleteOperationInterface
{
    private RequestBuilder $requestBuilder;

    private string $entityType;

    /**
     * @var string[]
     */
    private array $arguments;

    public function __construct(
        RequestBuilder $requestBuilder,
        string $entityType,
        array $arguments = []
    ) {
        $this->requestBuilder = $requestBuilder;
        $this->entityType = $entityType;
        $this->arguments = $arguments;
    }

    public function delete(int $entityId): void
    {
        try {
            $this->requestBuilder
                ->setEntityType($this->entityType)
                ->setMethod(RequestBuilder::HTTP_DELETE)
                ->setArguments(array_merge([$entityId], $this->arguments))
                ->create()
                ->execute();
        } catch (InvalidArgumentException $e) {
            throw new CouldNotDeleteException($e->getMessage(), $e->getCode(), $e);
        } catch (InvalidRequestException $e) {
            throw new CouldNotDeleteException($e->getMessage(), $e->getCode(), $e);
        } catch (Exception $e) {
            throw new CouldNotDeleteException(
                sprintf('Could not delete the entity with ID "%u".', $entityId),
                $e->getCode(),
                $e
            );
        }
    }
}
