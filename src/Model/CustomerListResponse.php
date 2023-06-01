<?php

namespace App\Model;

class CustomerListResponse
{
    /**
     * @param CustomerListItem[] $items
     */
    public function __construct(private array $items)
    {
    }

    /**
     * @return CustomerListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
