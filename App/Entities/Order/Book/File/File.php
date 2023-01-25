<?php

namespace App\Entities\Order\Book\File;

use App\Traits\Id;

class File implements FileInterface
{

    use Id;

    public function __construct(
        private int $bookId,
        private string $path,
    )
    {}

    public function getBookId(): int
    {
        return $this->bookId;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}