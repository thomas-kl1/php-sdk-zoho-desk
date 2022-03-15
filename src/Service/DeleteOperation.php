<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Zoho\Desk\Service;

use Zoho\Desk\Client\RequestBuilder;
use Zoho\Desk\Exception\CouldNotDeleteException;
use Zoho\Desk\Exception\Exception;
use Zoho\Desk\Exception\InvalidArgumentException;
use Zoho\Desk\Exception\InvalidRequestException;
use function array_merge;
use function reset;
use function rtrim;
use function sprintf;

final class DeleteOperation implements DeleteOperationInterface
{
    private RequestBuilder $requestBuilder;

    private string $entityType;

    private ?string $path;

    /**
     * @var string[]
     */
    private array $arguments;

    public function __construct(
        RequestBuilder $requestBuilder,
        string $entityType,
        ?string $path = null,
        array $arguments = []
    ) {
        $this->requestBuilder = $requestBuilder;
        $this->entityType = $entityType;
        $this->path = $path;
        $this->arguments = $arguments;
    }

    public function delete(array $bind): void
    {
        try {
            $this->requestBuilder
                ->setPath($this->path ?? $this->entityType, $bind)
                ->setMethod(RequestBuilder::HTTP_DELETE)
                ->setArguments($this->path ? $this->arguments : array_merge([reset($bind)], $this->arguments))
                ->create()
                ->execute();
        } catch (InvalidArgumentException $e) {
            throw new CouldNotDeleteException($e->getMessage(), $e->getCode(), $e);
        } catch (InvalidRequestException $e) {
            throw new CouldNotDeleteException($e->getMessage(), $e->getCode(), $e);
        } catch (Exception $e) {
            $flatten = '';
            foreach ($bind as $key => $value) {
                $flatten .= sprintf('%s: %s ', $key, $value);
            }
            throw new CouldNotDeleteException(
                sprintf('Could not delete the entity with %s.', rtrim($flatten)),
                $e->getCode(),
                $e
            );
        }
    }
}
