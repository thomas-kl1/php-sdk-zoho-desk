<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Zoho\Desk\Client;

final class Response implements ResponseInterface
{
    /**
     * @var string[]
     */
    private array $result;

    /**
     * @var string[]
     */
    private array $info;

    public function __construct(array $result, array $info)
    {
        $this->result = $result;
        $this->info = $info;
    }

    public function getResult(): array
    {
        return $this->result;
    }

    public function getInfo(): array
    {
        return $this->info;
    }
}
