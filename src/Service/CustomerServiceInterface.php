<?php

namespace App\Service;

use App\Model\CustomerListItem;
use App\Model\CustomerListResponse;

interface CustomerServiceInterface
{
    public function getCustomers(): CustomerListResponse;

    public function getCustomer(string $name): ?CustomerListItem;

    public function getCustomerById(int $id): ?CustomerListItem;
}
