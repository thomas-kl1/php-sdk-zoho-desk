<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 */
declare(strict_types=1);

namespace Zoho\Desk\Model;

/**
 * @api
 */
interface DataObjectInterface
{
    public function toArray(): array;

    public function toJson(): string;

    public function getEntityId(): ?int;
}
