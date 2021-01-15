<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Zoho\Desk\Model;

final class DataObject extends AbstractDataObject
{
    public function __construct(array $data)
    {
        $this->entityIdFieldName = $data['entityIdFieldName'] ?? 'id';
        parent::__construct($data);
    }
}
