<?php

namespace App\Entities\Order\Book;

use App\Traits\Id;
use App\Traits\Title;

class Book implements BookInterface
{

    use Id;
    use Title;

    public function __construct(
        private string $title,
        private string $author,
        private ?string $isbn = null,
        private ?int $circulation = null,
        private ?float $convPrintSheets = null,
        private ?float $publishingSheets = null,
        private int $typeId,
        private int $formatId,
    ){}

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getIsbn(): string|null
    {
        return $this->isbn;
    }

    public function getCirculation(): int|null
    {
        return $this->circulation;
    }

    public function getConvPrintSheets(): float|null
    {
        return $this->convPrintSheets;
    }

    public function getPublishingSheets(): float|null
    {
        return $this->publishingSheets;
    }

    public function getTypeId(): int|null
    {
        return $this->typeId;
    }

    public function getFormatId(): int|null
    {
        return $this->formatId;
    }

}