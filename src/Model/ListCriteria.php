<?php
/**
 * Copyright © Thomas Klein, All rights reserved.
 */
declare(strict_types=1);

namespace Zoho\Desk\Model;

use function implode;

final class ListCriteria implements ListCriteriaInterface
{
    /**
     * @var string[]
     */
    private $fields;

    /**
     * @var string[]
     */
    private $filters;

    /**
     * @var string[]
     */
    private $include;

    /**
     * @var int|null
     */
    private $from;

    /**
     * @var int|null
     */
    private $limit;

    /**
     * @var string|null
     */
    private $sortBy;

    /**
     * @var string|null
     */
    private $sortOrder;

    /**
     * @var int|null
     */
    private $viewId;

    public function __construct(
        array $fitlers,
        array $fields,
        array $include,
        ?int $from,
        ?int $limit,
        ?string $sortBy,
        ?string $sortOrder,
        ?int $viewId
    ) {
        $this->filters = $fitlers;
        $this->fields = $fields;
        $this->include = $include;
        $this->from = $from;
        $this->limit = $limit;
        $this->sortBy = $sortBy;
        $this->sortOrder = $sortOrder;
        $this->viewId = $viewId;
    }

    public function getFilters(): array
    {
        return (array) $this->filters;
    }

    public function getFields(): array
    {
        return (array) $this->fields;
    }

    public function getInclude(): array
    {
        return (array) $this->include;
    }

    public function getFrom(): ?int
    {
        return $this->from ? (int) $this->from : null;
    }

    public function getLimit(): ?int
    {
        return $this->limit ? (int) $this->limit : null;
    }

    public function getSortBy(): ?string
    {
        return $this->sortBy ? (string) $this->sortBy : null;
    }

    public function getSortOrder(): ?string
    {
        return $this->sortOrder ? (string) $this->sortOrder : null;
    }

    public function getViewId(): ?int
    {
        return $this->viewId ? (int) $this->viewId : null;
    }

    public function getQueryParams(): array
    {
        $query = [];

        if ($this->getFilters()) {
            $query = $this->getFilters();
        }
        if ($this->getFields()) {
            $query['fields'] = implode(',', $this->getFields());
        }
        if ($this->getInclude()) {
            $query['include'] = implode(',', $this->getInclude());
        }
        if ($this->getFrom()) {
            $query['from'] = $this->getFrom();
        }
        if ($this->getLimit()) {
            $query['limit'] = $this->getLimit();
        }
        if ($this->getSortBy()) {
            $query['sortBy'] = ($this->getSortOrder() === 'DESC' ? '-' : '') . $this->getSortBy();
        }
        if ($this->getViewId()) {
            $query['viewId'] = $this->getViewId();
        }

        return $query;
    }
}
