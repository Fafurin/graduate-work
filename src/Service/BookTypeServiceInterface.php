<?php

namespace App\Service;

use App\Model\BookTypeListResponse;

interface BookTypeServiceInterface
{
    function getBookTypes(): BookTypeListResponse;
}
