<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Zoho\Desk\Model;

/**
 * @api
 */
final class DataObjectFactory
{
    /**
     * @var string[]
     */
    private array $dataObjectTypes;

    public function __construct(array $dataObjectTypes = [])
    {
        $this->dataObjectTypes = $dataObjectTypes;
    }

    public function create(string $entityType, array $data = []): DataObjectInterface
    {
        $dataObjectClass = $this->dataObjectTypes[$entityType] ?? DataObject::class;

        return new $dataObjectClass($data);
    }
}
