<?php

namespace App\Command\Customer;

use App\Exception\CustomerNotFoundException;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeleteCustomerHandler implements DeleteCustomerHandlerInterface
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly CustomerRepository     $customerRepository
    )
    {
    }

    function handle(int $id): void
    {
        $customer = $this->customerRepository->find($id);

        if (!$customer) {
            throw new CustomerNotFoundException(
                "No customer found for id " . $id
            );
        }
        $customer->setIsDeleted(true);

        $this->entityManager->persist($customer);
        $this->entityManager->flush();
    }

}
