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
interface DataObjectInterface
{
    public function toArray(): array;

    public function toJson(): string;

    public function getEntityId(): ?int;
}
