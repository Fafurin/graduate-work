<?php

namespace App\Service;

use App\Model\BookFormatListItem;
use App\Model\BookFormatListResponse;

interface BookFormatServiceInterface
{
    function getBookFormats(): BookFormatListResponse;

    function getBookFormat(string $slug): ?BookFormatListItem;

    function getBookFormatById(int $id): ?BookFormatListItem;
}
