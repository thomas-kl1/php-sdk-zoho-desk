<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Zoho\Desk\Service;

use Zoho\Desk\Exception\CouldNotReadException;
use Zoho\Desk\Model\DataObjectInterface;

/**
 * @api
 */
interface ReadOperationInterface
{
    /**
     * @throws CouldNotReadException
     */
    public function get(array $bind, array $query = []): DataObjectInterface;
}
