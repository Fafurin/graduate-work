<?php

namespace App\Model;

class BookFormatListItem
{
    /**
     * @param int $id
     * @param string $title
     * @param string $size
     * @param string $slug
     */
    public function __construct(
        private int $id,
        private string $title,
        private string $size,
        private string $slug)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }
}
