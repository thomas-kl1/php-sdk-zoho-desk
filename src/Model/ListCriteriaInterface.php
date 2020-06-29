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
interface ListCriteriaInterface extends PagerCriteriaInterface
{
    public function getFilters(): array;

    public function getFields(): array;

    public function getInclude(): array;

    public function getViewId(): ?int;
}
