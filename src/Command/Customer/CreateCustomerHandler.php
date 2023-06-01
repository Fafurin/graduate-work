<?php

namespace App\Command\Customer;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class CreateCustomerHandler implements CreateCustomerHandlerInterface
{

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    function handle(Request $request): void
    {
        $customer = new Customer();

        $data = json_decode($request->getContent(), true);
        $customer->setName($data['name']);
        $customer->setPhone($data['phone']);
        $customer->setEmail($data['email']);
        $customer->setContactPerson($data['contactPerson']);

        $this->entityManager->persist($customer);
        $this->entityManager->flush();
    }
}
