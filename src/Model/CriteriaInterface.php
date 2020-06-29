<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 */
declare(strict_types=1);

namespace Zoho\Desk\Model;

/**
 * @api
 */
interface CriteriaInterface
{
    /**
     * @return string[]
     */
    public function getQueryParams(): array;
}
