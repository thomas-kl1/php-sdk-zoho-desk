<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Zoho\Desk\Service;

use Zoho\Desk\Exception\CouldNotSaveException;
use Zoho\Desk\Model\DataObjectInterface;

/**
 * @api
 */
interface UpdateOperationInterface
{
    /**
     * @throws CouldNotSaveException
     */
    public function update(DataObjectInterface $dataObject, array $bind = []): DataObjectInterface;
}
