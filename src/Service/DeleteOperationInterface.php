<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Zoho\Desk\Service;

use Zoho\Desk\Exception\CouldNotDeleteException;

/**
 * @api
 */
interface DeleteOperationInterface
{
    /**
     * @throws CouldNotDeleteException
     */
    public function delete(array $bind): void;
}
