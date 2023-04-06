<?php

namespace App\Model;

class BookTypeListResponse
{
    /**
     * @param BookTypeListItem[] $items
     */
    public function __construct(private array $items)
    {
    }

    /**
     * @return BookTypeListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
