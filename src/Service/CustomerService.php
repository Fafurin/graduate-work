<?php

namespace App\Service;

use App\Entity\Customer;
use App\Exception\CustomerNotFoundException;
use App\Model\CustomerListItem;
use App\Model\CustomerListResponse;
use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\Criteria;

class CustomerService implements CustomerServiceInterface
{
    public function __construct(private readonly CustomerRepository $customerRepository)
    {
    }

    public function getCustomers(): CustomerListResponse
    {
        $customers = $this->customerRepository->findBy(['isDeleted' => false], ['name' => Criteria::ASC]);
        $items = array_map(
            fn(Customer $customer) => new CustomerListItem(
                $customer->getId(),
                $customer->getName(),
                $customer->getPhone(),
                $customer->getEmail(),
                $customer->getContactPerson()
            ),
            $customers
        );

        return new CustomerListResponse($items);
    }

    public function getCustomerById(int $id): ?CustomerListItem
    {
        $customer = $this->customerRepository->find($id);
        if (!$customer) {
            throw new CustomerNotFoundException(
                "No customer found for id " . $id
            );
        }

        return $this->getCustomerListItem($customer);
    }

    public function getCustomer(string $name): ?CustomerListItem
    {
        $customer = $this->customerRepository->findOneBy(["name" => $name, 'isDeleted' => false]);
        if (!$customer) {
            throw new CustomerNotFoundException(
                "No customer found for name " . $name
            );
        }

        return $this->getCustomerListItem($customer);
    }

    private function getCustomerListItem(Customer $customer): CustomerListItem
    {
        return new CustomerListItem(
            $customer->getId(),
            $customer->getName(),
            $customer->getPhone(),
            $customer->getEmail(),
            $customer->getContactPerson()
        );
    }
}
