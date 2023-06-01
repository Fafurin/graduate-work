<?php

namespace App\Command\Customer;

use App\Exception\CustomerNotFoundException;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class UpdateCustomerHandler implements UpdateCustomerHandlerInterface
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly CustomerRepository $customerRepository
    )
    {
    }

    function handle(Request $request, int $id): void
    {
        $customer = $this->customerRepository->find($id);

        if (!$customer) {
            throw new CustomerNotFoundException(
                "No customer found for id " . $id
            );
        }

        $data = json_decode($request->getContent(), true);
        $customer->setName($data['name']);
        $customer->setPhone($data['phone']);
        $customer->setEmail($data['email']);
        $customer->setContactPerson($data['contactPerson']);

        $this->entityManager->persist($customer);
        $this->entityManager->flush();
    }

}
