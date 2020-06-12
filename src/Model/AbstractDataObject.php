<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 */
declare(strict_types=1);

namespace Zoho\Desk\Model;

use function json_encode;

abstract class AbstractDataObject implements DataObjectInterface
{
    /**
     * @var string
     */
    protected $entityIdFieldName;
    
    /**
     * @var array
     */
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    final public function toArray(): array
    {
        return $this->data;
    }

    final public function toJson(): string
    {
        return json_encode($this->data);
    }

    final public function getEntityId(): ?int
    {
        return $this->data[$this->entityIdFieldName] ?? null;
    }
}
