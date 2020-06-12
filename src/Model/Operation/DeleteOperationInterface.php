<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 */
declare(strict_types=1);

namespace Zoho\Desk\Model\Operation;

use Zoho\Desk\Exception\CouldNotDeleteException;

/**
 * @api
 */
interface DeleteOperationInterface
{
    /**
     * @param int $entityId
     * @return void
     * @throws CouldNotDeleteException
     */
    public function delete(int $entityId): void;
}
