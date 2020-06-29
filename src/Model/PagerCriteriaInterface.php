<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 */
declare(strict_types=1);

namespace Zoho\Desk\Model;

/**
 * @api
 */
interface PagerCriteriaInterface extends CriteriaInterface
{
    public function getFrom(): ?int;

    public function getLimit(): ?int;

    public function getSortBy(): ?string;

    public function getSortOrder(): ?string;
}
