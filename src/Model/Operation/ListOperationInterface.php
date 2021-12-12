<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Zoho\Desk\Model\Operation;

use Zoho\Desk\Exception\CouldNotReadException;
use Zoho\Desk\Model\DataObjectInterface;
use Zoho\Desk\Model\ListCriteriaInterface;

/**
 * @api
 * @deprecated
 * @see \Zoho\Desk\Service\ListOperationInterface
 */
interface ListOperationInterface
{
    /**
     * @param int[] $entityIds
     * @return DataObjectInterface[]
     * @throws CouldNotReadException
     */
    public function getByIds(array $entityIds): array;

    /**
     * @param ListCriteriaInterface $listCriteria
     * @return DataObjectInterface[]
     * @throws CouldNotReadException
     */
    public function getList(ListCriteriaInterface $listCriteria): array;
}
