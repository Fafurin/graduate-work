<?php

namespace App\Service;

use App\Model\BookTypeListItem;
use App\Model\BookTypeListResponse;

interface BookTypeServiceInterface
{
    function getBookTypes(): BookTypeListResponse;

    function getBookType(string $slug): ?BookTypeListItem;

    function getBookTypeById(int $id): ?BookTypeListItem;
}
