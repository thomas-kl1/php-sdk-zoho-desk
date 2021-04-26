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
    private array $fields;

    /**
     * @var string[]
     */
    private array $filters;

    /**
     * @var string[]
     */
    private array $include;

    private ?int $from;

    private ?int $limit;

    private ?string $sortBy;

    private ?string $sortOrder;

    private ?int $viewId;

    public function __construct(
        array $filters,
        array $fields,
        array $include,
        ?int $from,
        ?int $limit,
        ?string $sortBy,
        ?string $sortOrder,
        ?int $viewId
    ) {
        $this->filters = $filters;
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
        $query = $this->getFilters();

        if (!$query) {
            if ($this->getFields()) {
                $query['fields'] = implode(',', $this->getFields());
            }
            if ($this->getInclude()) {
                $query['include'] = implode(',', $this->getInclude());
            }
            if ($this->getViewId()) {
                $query['viewId'] = $this->getViewId();
            }
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

        return $query;
    }
}
