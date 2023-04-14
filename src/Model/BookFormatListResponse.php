<?php

namespace App\Model;

class BookFormatListResponse
{
    /**
     * @param BookFormatListItem[] $items
     */
    public function __construct(private array $items)
    {
    }

    /**
     * @return BookFormatListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
