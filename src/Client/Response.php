<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 */
declare(strict_types=1);

namespace Zoho\Desk\Client;

final class Response implements ResponseInterface
{
    /**
     * @var string[]
     */
    private $result;

    /**
     * @var string[]
     */
    private $info;

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
