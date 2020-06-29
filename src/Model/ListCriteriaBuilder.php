<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 */
declare(strict_types=1);

namespace Zoho\Desk\Model;

/**
 * @api
 */
final class ListCriteriaBuilder
{
    private $data = [];

    public function setFields(array $fields): self
    {
        $this->data['fields'] = $fields;

        return $this;
    }

    public function setInclude(array $include): self
    {
        $this->data['include'] = $include;

        return $this;
    }

    public function setFrom(int $from): self
    {
        $this->data['from'] = $from;

        return $this;
    }

    public function setLimit(int $limit): self
    {
        $this->data['limit'] = $limit;

        return $this;
    }

    public function setSortBy(string $sortBy): self
    {
        $this->data['sortBy'] = $sortBy;

        return $this;
    }

    public function setSortOrder(string $sortOrder): self
    {
        $this->data['sortOrder'] = $sortOrder;

        return $this;
    }

    public function setViewId(int $viewId): self
    {
        $this->data['viewId'] = $viewId;

        return $this;
    }

    public function create(): ListCriteriaInterface
    {
        return new ListCriteria(
            $this->data['fields'] ?? [],
            $this->data['include'] ?? [],
            $this->data['from'] ?? null,
            $this->data['limit'] ?? null,
            $this->data['sortBy'] ?? null,
            $this->data['sortOrder'] ?? null,
            $this->data['viewId'] ?? null,
        );
    }
}
