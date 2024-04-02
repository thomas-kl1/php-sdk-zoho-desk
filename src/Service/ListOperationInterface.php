<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Zoho\Desk\Service;

use Zoho\Desk\Exception\CouldNotReadException;
use Zoho\Desk\Model\DataObjectInterface;
use Zoho\Desk\Model\ListCriteriaInterface;

/**
 * @api
 */
interface ListOperationInterface
{
    /**
     * @throws CouldNotReadException
     */
    public function getList(ListCriteriaInterface $listCriteria, array $bind = []): array;
}
