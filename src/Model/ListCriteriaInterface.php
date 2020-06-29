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
interface ListCriteriaInterface
{
    public function getFields(): array;

    public function getInclude(): array;

    public function getFrom(): ?int;

    public function getLimit(): ?int;

    public function getSortBy(): ?string;

    public function getSortOrder(): ?string;

    public function getViewId(): ?int;

    public function getQueryParams(): array;
}
